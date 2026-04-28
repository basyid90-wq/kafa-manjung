<?php

namespace App\Http\Controllers;

use App\Models\ManualDownloadLog;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class ManualController extends Controller
{
    // Map role name → blade file slug
    private array $roleMap = [
        'Guru KAFA'        => 'guru-kafa',
        'Guru Besar'       => 'guru-besar',
        'Penyelia KAFA'    => 'penyelia-kafa',
        'Ibu Bapa'         => 'ibu-bapa',
        'Bendahari Sekolah'=> 'bendahari-sekolah',
        'Pentadbir'        => 'pentadbir',
        'Pembekal'         => 'pembekal',
    ];

    public function download()
    {
        $user     = Auth::user();
        $roleName = $user->getRoleNames()->first() ?? 'Pentadbir';
        $slug     = $this->roleMap[$roleName] ?? 'pentadbir';
        $view     = "manuals.{$slug}";

        // Log the download
        ManualDownloadLog::create([
            'user_id'       => $user->id,
            'role_name'     => $roleName,
            'school_id'     => $user->school_id,
            'downloaded_at' => now(),
        ]);

        // Render Blade → HTML
        $html = view($view)->render();

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4',
            'autoArabic'   => true,
            'default_font' => 'lateef',
            'tempDir'      => storage_path('app/mpdf_temp'),
            'margin_top'   => 12,
            'margin_right' => 14,
            'margin_bottom'=> 12,
            'margin_left'  => 14,
        ]);

        $mpdf->WriteHTML($html);

        $base64 = base64_encode($mpdf->Output('', 'S'));

        return response()->json([
            'data'     => $base64,
            'filename' => 'Panduan-Pengguna-' . str_replace(' ', '-', $roleName) . '.pdf',
        ]);
    }

    public function logs()
    {
        $logs = ManualDownloadLog::with(['user', 'school'])
            ->orderByDesc('downloaded_at')
            ->paginate(10);

        return view('admin.manual-logs.index', compact('logs'));
    }
}
