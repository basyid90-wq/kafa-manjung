@extends('layout-fb.layout')
@section('title', 'Tetapan Chatbot AI')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">🤖 Tetapan Chatbot AI</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Urus provider AI, API Key dan mod akses data.</p>
        </div>
    </div>

    {{-- ── Bot Profile ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-6">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">🤖 Profil Chatbot</h2>
        <form method="POST" action="{{ route('chatbot.bot-profile') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">

                {{-- Avatar preview --}}
                <div style="position:relative;flex-shrink:0;">
                    <div id="avatar-preview"
                         style="width:80px;height:80px;border-radius:50%;overflow:hidden;
                                border:3px solid #e2e8f0;display:flex;align-items:center;
                                justify-content:center;background:#eff6ff;font-size:2rem;cursor:pointer;"
                         onclick="document.getElementById('bot_avatar').click()">
                        @if($settings->bot_avatar)
                            <img src="{{ asset('storage/'.$settings->bot_avatar) }}"
                                 id="avatar-img"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span id="avatar-emoji">🤖</span>
                        @endif
                    </div>
                    <div style="position:absolute;bottom:0;right:0;width:24px;height:24px;border-radius:50%;
                                background:#1d4ed8;display:flex;align-items:center;justify-content:center;
                                border:2px solid white;cursor:pointer;"
                         onclick="document.getElementById('bot_avatar').click()">
                        <svg style="width:12px;height:12px;color:white;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <input type="file" id="bot_avatar" name="bot_avatar"
                           accept="image/*" style="display:none;"
                           onchange="previewAvatar(this)">
                    <p style="font-size:0.68rem;color:#9ca3af;text-align:center;margin-top:4px;">Klik untuk tukar</p>
                </div>

                {{-- Name + submit --}}
                <div style="flex:1;min-width:200px;">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Chatbot</label>
                    <input type="text" name="bot_name" value="{{ $settings->bot_name ?? 'Pembantu KAFA AI' }}"
                           maxlength="50" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Nama ini akan dipaparkan dalam widget chatbot.</p>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors mt-3">
                        Simpan Profil
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Global: Data Access Toggle ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-6">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-0.5">
                    🔒 Mod Akses Data Penuh (PDPA)
                </h2>
                <p class="text-xs text-gray-400 max-w-lg">
                    <strong>OFF</strong> — Chatbot hanya jawab soalan prosedur &amp; panduan sistem. Tiada data murid.
                    <br><strong>ON</strong> — Chatbot boleh akses data sistem secara mendalam.
                    Aktifkan <u>hanya</u> jika provider aktif bukan DeepSeek (isu PDPA).
                </p>
            </div>
            <form method="POST" action="{{ route('chatbot.toggle-data') }}">
                @csrf
                <button type="submit"
                        style="display:inline-flex;align-items:center;gap:10px;padding:10px 20px;
                               border-radius:999px;border:none;cursor:pointer;font-weight:700;font-size:0.875rem;
                               {{ $settings->data_access_enabled
                                   ? 'background:#dcfce7;color:#166534;'
                                   : 'background:#fee2e2;color:#991b1b;' }}"
                        onmouseover="this.style.opacity='.85'"
                        onmouseout="this.style.opacity='1'">
                    <span style="width:40px;height:22px;border-radius:999px;position:relative;display:inline-block;
                                 {{ $settings->data_access_enabled ? 'background:#16a34a;' : 'background:#d1d5db;' }}">
                        <span style="position:absolute;top:3px;width:16px;height:16px;border-radius:50%;background:white;
                                     transition:left .2s;
                                     {{ $settings->data_access_enabled ? 'left:21px;' : 'left:3px;' }}">
                        </span>
                    </span>
                    {{ $settings->data_access_enabled ? 'AKTIF — Klik untuk Matikan' : 'TIDAK AKTIF — Klik untuk Aktifkan' }}
                </button>
            </form>
        </div>

        @if($settings->data_access_enabled)
        <div style="margin-top:12px;padding:10px 14px;border-radius:8px;background:#fef9c3;border:1px solid #fde047;">
            <p style="font-size:0.8rem;color:#713f12;margin:0;">
                ⚠️ <strong>Peringatan PDPA:</strong> Pastikan provider aktif adalah OpenAI, Gemini atau Groq — bukan DeepSeek.
                Data murid boleh terdedah jika menggunakan server luar negara yang tidak patuh PDPA.
            </p>
        </div>
        @endif
    </div>

    {{-- ── Provider Cards ── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;">
        @foreach($providers as $provider)
        @php
            $isActive = $provider->is_active;
            $hasSafeWarning = $isActive && !$provider->is_safe && $settings->data_access_enabled;
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-xl border {{ $isActive ? 'border-blue-400 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700' }} overflow-hidden"
             style="{{ $isActive ? 'box-shadow:0 0 0 3px rgba(59,130,246,0.15);' : '' }}">

            {{-- Card Header --}}
            <div style="padding:14px 16px;border-bottom:1px solid {{ $isActive ? '#bfdbfe' : '#f3f4f6' }};
                        display:flex;align-items:center;justify-content:space-between;
                        {{ $isActive ? 'background:#eff6ff;' : 'background:#f8fafc;' }}">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.5rem;">{{ $provider->icon }}</span>
                    <div>
                        <p style="font-size:0.9rem;font-weight:700;color:#111827;margin:0;">{{ $provider->name }}</p>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:2px;">
                            @if($isActive)
                            <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:999px;
                                         background:#1d4ed8;color:white;">● AKTIF</span>
                            @endif
                            @if($provider->is_free)
                            <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:999px;
                                         background:#dcfce7;color:#166534;">Tier Percuma</span>
                            @endif
                            @if(!$provider->is_safe)
                            <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:999px;
                                         background:#fee2e2;color:#991b1b;">⚠ PDPA</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Body: Edit Form --}}
            <form method="POST" action="{{ route('chatbot.provider.update', $provider) }}"
                  style="padding:14px 16px;">
                @csrf @method('PATCH')

                <div style="margin-bottom:10px;">
                    <label style="display:block;font-size:0.7rem;font-weight:700;color:#6b7280;
                                  text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">
                        API Key
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="api_key" id="key-{{ $provider->id }}"
                               placeholder="{{ $provider->api_key ? '••••••••• (ada key, kosongkan untuk kekal)' : ($provider->is_free ? 'Daftar percuma → dapat key → tampal di sini' : 'Masukkan API Key...') }}"
                               style="width:100%;padding:8px 36px 8px 10px;font-size:0.8rem;border:1px solid #e5e7eb;
                                      border-radius:8px;background:#f9fafb;outline:none;box-sizing:border-box;">
                        <button type="button" onclick="toggleKey('key-{{ $provider->id }}')"
                                style="position:absolute;right:8px;top:50%;transform:translateY(-50%);
                                       border:none;background:none;cursor:pointer;color:#9ca3af;padding:2px;">
                            <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block;font-size:0.7rem;font-weight:700;color:#6b7280;
                                  text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">
                        Model
                    </label>
                    <input type="text" name="model" value="{{ $provider->model }}"
                           list="models-{{ $provider->slug }}"
                           placeholder="Pilih atau taip nama model..."
                           style="width:100%;padding:8px 10px;font-size:0.8rem;border:1px solid #e5e7eb;
                                  border-radius:8px;background:#f9fafb;outline:none;box-sizing:border-box;">
                    <datalist id="models-{{ $provider->slug }}">
                        @foreach(\App\Models\ChatbotProvider::MODEL_SUGGESTIONS[$provider->slug] ?? [] as $m)
                        <option value="{{ $m }}">
                        @endforeach
                    </datalist>
                    <p style="font-size:0.68rem;color:#9ca3af;margin-top:3px;">Klik field untuk senarai model, atau taip sendiri.</p>
                </div>

                <div style="display:flex;gap:8px;">
                    <button type="submit"
                            style="flex:1;padding:8px;font-size:0.8rem;font-weight:600;border:none;cursor:pointer;
                                   border-radius:8px;background:#f3f4f6;color:#374151;"
                            onmouseover="this.style.background='#e5e7eb'"
                            onmouseout="this.style.background='#f3f4f6'">
                        💾 Simpan
                    </button>

                    @if(!$isActive)
                    <form method="POST" action="{{ route('chatbot.provider.activate', $provider) }}" style="flex:1;">
                        @csrf
                        <button type="submit"
                                style="width:100%;padding:8px;font-size:0.8rem;font-weight:600;border:none;cursor:pointer;
                                       border-radius:8px;background:#1d4ed8;color:white;"
                                onmouseover="this.style.background='#1e40af'"
                                onmouseout="this.style.background='#1d4ed8'">
                            ✓ Aktifkan
                        </button>
                    </form>
                    @else
                    <div style="flex:1;padding:8px;font-size:0.8rem;font-weight:600;text-align:center;
                                border-radius:8px;background:#dcfce7;color:#166534;">
                        ✓ Sedang Aktif
                    </div>
                    @endif
                </div>
            </form>

            {{-- PDPA Warning on active unsafe provider --}}
            @if($hasSafeWarning)
            <div style="margin:0 16px 14px;padding:8px 12px;border-radius:8px;background:#fef9c3;">
                <p style="font-size:0.72rem;color:#713f12;margin:0;">
                    ⚠️ Provider ini di server China. Matikan Akses Data atau tukar ke provider lain.
                </p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- ── Cara Tukar Provider ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-blue-100 dark:border-blue-900/40 p-4 mt-6"
         style="background:linear-gradient(135deg,rgba(239,246,255,0.8),rgba(238,242,255,0.8));">
        <div class="dark:hidden">
            <p style="font-size:0.82rem;color:#1e40af;margin:0;">
                💡 <strong>Cara tukar provider (termasuk yang percuma):</strong>
                Daftar di laman web provider → salin API Key → tampal di sini → klik <strong>Simpan</strong> → klik <strong>Aktifkan</strong>.
                Provider lama auto dimatikan. <strong>Semua provider — termasuk Groq &amp; Gemini — memerlukan API Key</strong> walaupun ia percuma.
            </p>
        </div>
        <div class="hidden dark:block">
            <p style="font-size:0.82rem;color:#93c5fd;margin:0;">
                💡 <strong>Cara tukar provider (termasuk yang percuma):</strong>
                Daftar di laman web provider → salin API Key → tampal di sini → klik <strong>Simpan</strong> → klik <strong>Aktifkan</strong>.
                Provider lama auto dimatikan. <strong>Semua provider — termasuk Groq &amp; Gemini — memerlukan API Key</strong> walaupun ia percuma.
            </p>
        </div>
    </div>

    {{-- ── Panduan Provider ── --}}
    <style>
        .guide-table { width:100%; font-size:0.8rem; border-collapse:collapse; }
        .guide-table th {
            padding:9px 12px; text-align:left; font-weight:600;
            background:#f8fafc; color:#6b7280;
            border-bottom:1px solid #e5e7eb;
        }
        .guide-table th.center { text-align:center; }
        .guide-table td {
            padding:9px 12px; color:#111827;
            border-bottom:1px solid #f3f4f6;
        }
        .guide-table td.center { text-align:center; }
        .guide-table tr:last-child td { border-bottom:none; }
        /* Dark mode */
        .dark .guide-table th { background:#1f2937; color:#9ca3af; border-color:#374151; }
        .dark .guide-table td { color:#e5e7eb; border-color:#374151; }
        .dark .guide-table tr:last-child td { border-color:transparent; }
        .guide-table a { color:#1d4ed8; text-decoration:none; }
        .dark .guide-table a { color:#60a5fa; }
        .guide-table a:hover { text-decoration:underline; }
    </style>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mt-4">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📋 Panduan Provider</h3>
        <div style="overflow-x:auto;">
            <table class="guide-table">
                <thead>
                    <tr>
                        <th>Provider</th>
                        <th class="center">Kualiti</th>
                        <th class="center">Kos (~300 guru)</th>
                        <th class="center">PDPA</th>
                        <th>Daftar API Key</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight:600;">🧠 DeepSeek V4 Pro</td>
                        <td class="center">⭐⭐⭐⭐</td>
                        <td class="center">~RM1.30/bln</td>
                        <td class="center" style="color:#f87171;">⚠️ Tidak</td>
                        <td><a href="https://platform.deepseek.com" target="_blank">platform.deepseek.com</a></td>
                    </tr>
                    <tr>
                        <td style="font-weight:600;">✨ OpenAI (ChatGPT)</td>
                        <td class="center">⭐⭐⭐⭐⭐</td>
                        <td class="center">~RM20–95/bln</td>
                        <td class="center" style="color:#4ade80;">✅ Ya</td>
                        <td><a href="https://platform.openai.com" target="_blank">platform.openai.com</a></td>
                    </tr>
                    <tr>
                        <td style="font-weight:600;">♊ Google Gemini Flash</td>
                        <td class="center">⭐⭐⭐</td>
                        <td class="center">Percuma (had)</td>
                        <td class="center" style="color:#4ade80;">✅ Ya</td>
                        <td><a href="https://aistudio.google.com" target="_blank">aistudio.google.com</a></td>
                    </tr>
                    <tr>
                        <td style="font-weight:600;">⚡ Groq (Llama)</td>
                        <td class="center">⭐⭐⭐</td>
                        <td class="center">Percuma</td>
                        <td class="center" style="color:#4ade80;">✅ Ya</td>
                        <td><a href="https://console.groq.com" target="_blank">console.groq.com</a></td>
                    </tr>
                    <tr>
                        <td style="font-weight:600;">🔮 Anthropic (Claude)</td>
                        <td class="center">⭐⭐⭐⭐⭐</td>
                        <td class="center">~RM24–467/bln</td>
                        <td class="center" style="color:#4ade80;">✅ Ya</td>
                        <td><a href="https://console.anthropic.com" target="_blank">console.anthropic.com</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function toggleKey(id) {
    var el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}

function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview = document.getElementById('avatar-preview');
        preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
