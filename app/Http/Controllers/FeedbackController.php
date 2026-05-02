<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    /** Form hantar aduan (semua role kecuali Super Admin) */
    public function create()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Super Admin tidak perlu hantar aduan.');
        }

        $modules = Feedback::MODULES;
        return view('feedback.create', compact('modules'));
    }

    /** Simpan aduan */
    public function store(Request $request)
    {
        if (auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $request->validate([
            'module'      => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('feedback', 'public');
        }

        Feedback::create([
            'user_id'     => auth()->id(),
            'module'      => $request->module,
            'description' => $request->description,
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Aduan berjaya dihantar. Super Admin akan menyemaknya dalam masa terdekat.');
    }

    /** Senarai aduan (Super Admin sahaja) */
    public function index(Request $request)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $query = Feedback::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        $feedbacks = $query->paginate(15);
        $modules   = Feedback::MODULES;
        $statuses  = Feedback::STATUSES;

        return view('feedback.index', compact('feedbacks', 'modules', 'statuses'));
    }

    /** Lihat satu aduan */
    public function show(Feedback $feedback)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        // Auto-set status dari 'baru' ke 'dalam_semakan' bila Super Admin buka
        if ($feedback->status === 'baru') {
            $feedback->update(['status' => 'dalam_semakan']);
        }

        return view('feedback.show', compact('feedback'));
    }

    /** Log Viewer — baca laravel.log terkini (Super Admin sahaja) */
    public function systemLog()
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $logPath = storage_path('logs/laravel.log');
        $entries = [];

        if (file_exists($logPath)) {
            // Baca 300 baris terakhir
            $lines = array_reverse(array_slice(file($logPath), -300));
            $current = null;

            foreach ($lines as $line) {
                // Detect Laravel log entry: [YYYY-MM-DD HH:MM:SS] production.LEVEL: ...
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.+)/', $line, $m)) {
                    if ($current) {
                        $entries[] = $current;
                    }
                    $current = [
                        'datetime' => $m[1],
                        'level'    => strtolower($m[2]),
                        'message'  => trim($m[3]),
                        'trace'    => '',
                    ];
                } elseif ($current) {
                    $current['trace'] .= $line;
                }
            }
            if ($current) {
                $entries[] = $current;
            }
        }

        // Filter: tunjuk ERROR dan WARNING sahaja secara default
        $filterLevel = request('level', 'error');
        if ($filterLevel !== 'all') {
            $entries = array_filter($entries, fn($e) => $e['level'] === $filterLevel);
        }

        $entries = array_slice(array_values($entries), 0, 50);

        return view('admin.system_log', compact('entries', 'filterLevel'));
    }

    /** Kemaskini status & balasan (Super Admin sahaja) */
    public function update(Request $request, Feedback $feedback)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $request->validate([
            'status'      => 'required|in:baru,dalam_semakan,selesai',
            'admin_reply' => 'nullable|string|max:2000',
        ]);

        $feedback->update([
            'status'      => $request->status,
            'admin_reply' => $request->admin_reply,
        ]);

        return back()->with('success', 'Status aduan berjaya dikemaskini.');
    }
}
