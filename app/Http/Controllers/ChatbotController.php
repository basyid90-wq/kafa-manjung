<?php

namespace App\Http\Controllers;

use App\Models\ChatbotProvider;
use App\Models\ChatbotSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ChatbotController extends Controller
{
    // ══════════════════════════════════════════════════════
    // CHAT MESSAGE — called by floating widget (all auth users)
    // ══════════════════════════════════════════════════════
    public function message(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $provider = ChatbotProvider::active();

        if (!$provider) {
            return response()->json(['error' => 'Chatbot tidak dikonfigurasi. Hubungi Super Admin.'], 503);
        }

        $apiKey = $provider->decrypted_key;
        if (!$apiKey) {
            return response()->json(['error' => 'API Key belum ditetapkan untuk provider ini.'], 503);
        }

        $settings          = ChatbotSetting::current();
        $dataAccessEnabled = $settings->data_access_enabled && $provider->is_safe;

        $systemPrompt = $this->buildSystemPrompt($dataAccessEnabled);
        $history      = $this->sanitiseHistory($request->input('history', []));

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $history,
            [['role' => 'user', 'content' => $request->message]]
        );

        try {
            // Anthropic uses a different API format from OpenAI-compatible providers
            if ($provider->slug === 'anthropic') {
                $historyOnly = array_merge(
                    $history,
                    [['role' => 'user', 'content' => $request->message]]
                );

                $response = Http::timeout(30)
                    ->withHeaders([
                        'x-api-key'         => $apiKey,
                        'anthropic-version' => '2023-06-01',
                        'content-type'      => 'application/json',
                    ])
                    ->post(rtrim($provider->base_url, '/') . '/messages', [
                        'model'      => $provider->model,
                        'max_tokens' => 600,
                        'system'     => $systemPrompt,
                        'messages'   => $historyOnly,
                    ]);

                if ($response->failed()) {
                    return response()->json(['error' => 'Ralat menghubungi Anthropic API.'], 500);
                }

                $reply = $response->json('content.0.text') ?? 'Tiada jawapan diterima.';

            } else {
                // OpenAI-compatible: DeepSeek, OpenAI, Gemini Flash, Groq
                $response = Http::timeout(30)
                    ->withToken($apiKey)
                    ->post(rtrim($provider->base_url, '/') . '/chat/completions', [
                        'model'       => $provider->model,
                        'messages'    => $messages,
                        'max_tokens'  => 600,
                        'temperature' => 0.7,
                    ]);

                if ($response->failed()) {
                    return response()->json(['error' => 'Ralat menghubungi AI. Cuba sebentar lagi.'], 500);
                }

                $reply = $response->json('choices.0.message.content') ?? 'Tiada jawapan diterima.';
            }

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ralat sambungan AI.'], 500);
        }
    }

    // ══════════════════════════════════════════════════════
    // SUPER ADMIN — Settings Page
    // ══════════════════════════════════════════════════════
    public function settings()
    {
        $providers = ChatbotProvider::orderBy('sort_order')->get();
        $settings  = ChatbotSetting::current();

        return view('super-admin.chatbot-settings', compact('providers', 'settings'));
    }

    public function updateProvider(Request $request, ChatbotProvider $provider)
    {
        $request->validate([
            'api_key' => 'nullable|string|max:500',
            'model'   => 'required|string|max:100',
        ]);

        $data = ['model' => $request->model];

        // Only update API key if a new one was typed (not blank)
        if (filled($request->api_key)) {
            $data['api_key'] = encrypt($request->api_key);
        }

        $provider->update($data);

        return redirect()->route('chatbot.settings')
            ->with('success', "✅ Tetapan {$provider->name} telah dikemaskini.");
    }

    public function activateProvider(ChatbotProvider $provider)
    {
        // ALL providers — including free tier — still require an API key
        if (!$provider->api_key) {
            $hint = $provider->is_free
                ? "Provider ini ada tier percuma — daftar di laman web mereka untuk dapatkan API Key, kemudian masukkan di sini."
                : "Masukkan API Key dahulu sebelum mengaktifkan provider ini.";

            return redirect()->route('chatbot.settings')->with('error', $hint);
        }

        // Deactivate all → activate selected
        ChatbotProvider::query()->update(['is_active' => false]);
        $provider->update(['is_active' => true, 'is_enabled' => true]);

        return redirect()->route('chatbot.settings')
            ->with('success', "✅ {$provider->name} kini aktif sebagai provider chatbot.");
    }

    public function updateBotProfile(Request $request)
    {
        $request->validate([
            'bot_name'   => 'required|string|max:50',
            'bot_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $settings = ChatbotSetting::current();
        $data     = ['bot_name' => $request->bot_name];

        if ($request->hasFile('bot_avatar')) {
            // Delete old avatar if exists
            if ($settings->bot_avatar && Storage::disk('public')->exists($settings->bot_avatar)) {
                Storage::disk('public')->delete($settings->bot_avatar);
            }
            $data['bot_avatar'] = $request->file('bot_avatar')->store('chatbot', 'public');
        }

        $settings->update($data);

        return redirect()->route('chatbot.settings')
            ->with('success', '✅ Profil chatbot berjaya dikemaskini.');
    }

    public function deactivateProvider(ChatbotProvider $provider)
    {
        // Deactivate this provider — chatbot goes offline until another is activated
        $provider->update(['is_active' => false, 'is_enabled' => false]);

        return redirect()->route('chatbot.settings')
            ->with('success', "⏹ {$provider->name} telah dimatikan. Chatbot tidak aktif sehingga provider lain diaktifkan.");
    }

    public function toggleDataAccess()
    {
        $settings = ChatbotSetting::current();
        $settings->update(['data_access_enabled' => !$settings->data_access_enabled]);

        $status = $settings->fresh()->data_access_enabled ? 'DIAKTIFKAN' : 'DIMATIKAN';

        return redirect()->route('chatbot.settings')
            ->with('success', "Mod Akses Data kini {$status}.");
    }

    // ══════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ══════════════════════════════════════════════════════
    private function buildSystemPrompt(bool $dataAccess): string
    {
        $user   = auth()->user();
        $role   = $user->getRoleNames()->first() ?? 'Pengguna';
        $school = $user->school?->name ?? '-';
        $name   = $user->name;

        $base = "Kamu adalah Pembantu AI rasmi untuk Sistem Pengurusan KAFA Manjung (APKM), Malaysia.
Sentiasa jawab dalam Bahasa Melayu yang mesra dan profesional.
Jawapan mestilah ringkas, jelas dan berguna. Elak jawapan terlalu panjang.
Pengguna: {$name} | Peranan: {$role} | Sekolah: {$school}.";

        $roleContext = match ($role) {
            'Guru KAFA' =>
                "Bantu guru dengan: penulisan Rancangan Pengajaran Harian (RPH), cadangan aktiviti PdP, " .
                "sukatan pelajaran KAFA, prosedur pengisian borang dalam sistem, teknik pengajaran Islam.",

            'Guru Besar' =>
                "Bantu guru besar dengan: pengurusan pentadbiran sekolah, prosedur laporan kehadiran, " .
                "statistik murid, penyeliaan guru, cara guna modul dalam sistem APKM.",

            'Penyelia KAFA' =>
                "Bantu penyelia dengan: pemantauan sekolah-sekolah dalam daerah, prosedur penilaian guru, " .
                "laporan pencapaian daerah, cara semak data dalam sistem.",

            'Ibu Bapa' =>
                "Bantu ibu bapa dengan: maklumat am tentang KAFA, jadual persekolahan, cara hubungi guru, " .
                "soalan lazim tentang UPKK, cara semak maklumat anak dalam sistem.",

            'Pentadbir' =>
                "Bantu pentadbir dengan: pengurusan pengguna sistem, laporan daerah, prosedur pendaftaran " .
                "sekolah baharu, cara guna semua modul dalam APKM.",

            'Pembekal' =>
                "Bantu pembekal dengan: prosedur tempahan buku, cara semak status pembekalan, " .
                "cara hantar invois, syarat dan prosedur pembekalan KAFA.",

            'Super Admin' =>
                "Kamu membantu Super Admin sistem. Boleh jawab soalan tentang semua aspek sistem APKM, " .
                "pengurusan pengguna, tetapan sistem, laporan, dan troubleshooting.",

            default =>
                "Bantu pengguna dengan soalan berkaitan Sistem Pengurusan KAFA Manjung.",
        };

        $pdpaNote = $dataAccess
            ? "\n\nMod Akses Data AKTIF: Kamu boleh membantu dengan pertanyaan berkaitan data sistem."
            : "\n\nPENTING — Mod Selamat (PDPA): JANGAN sebut, tanya, atau dedahkan data peribadi murid " .
              "(nama penuh, IC, markah, kehadiran individu). Fokus kepada soalan prosedur, panduan sistem, " .
              "dan maklumat am sahaja.";

        return $base . "\n\n" . $roleContext . $pdpaNote;
    }

    private function sanitiseHistory(array $history): array
    {
        // Keep last 6 messages max, only allow role=user|assistant
        return array_slice(
            array_filter($history, fn($m) =>
                isset($m['role'], $m['content']) &&
                in_array($m['role'], ['user', 'assistant']) &&
                is_string($m['content']) &&
                strlen($m['content']) <= 2000
            ),
            -6
        );
    }
}
