<?php

namespace App\Http\Controllers;

use App\Models\RphRecord;
use App\Models\School;

class RphPdfController extends Controller
{
    private const HARI_JAWI = [
        'Ahad'   => 'احد',
        'Isnin'  => 'اثنين',
        'Selasa' => 'ثلاث',
        'Rabu'   => 'رابو',
        'Khamis' => 'خميس',
        'Jumaat' => 'جمعة',
        'Sabtu'  => 'سبتو',
    ];

    public function download(RphRecord $rph)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                if (!School::where('id', $rph->school_id)->where('district_id', $user->district_id)->exists()) {
                    abort(403);
                }
            } else {
                if ($rph->school_id !== $user->school_id) abort(403);
            }
        }

        $rph->load(['user', 'school', 'reviewer', 'periods.kafaClass']);

        // Check if gabungan
        if ($rph->isGabungan()) {
            return $this->downloadGabungan($rph);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'default_font'  => 'lateef',
            'autoArabic'    => true,
            'margin_top'    => 6,
            'margin_bottom' => 6,
            'margin_left'   => 10,
            'margin_right'  => 10,
            'tempDir'       => storage_path('app/mpdf_tmp'),
        ]);

        $hariJawi = self::HARI_JAWI;
        $html     = view('rph.pdf', compact('rph', 'hariJawi'))->render();
        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');
        $filename   = 'RPH-' . $rph->date . '-' . str_replace(' ', '_', $rph->user->name ?? 'guru') . '.pdf';

        return response()->json([
            'data'     => base64_encode($pdfContent),
            'filename' => $filename,
        ]);
    }

    private function downloadGabungan(RphRecord $rph)
    {
        $isNewFormat = $rph->periods()->whereNotNull('tajuk_by_year')->exists();

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'default_font'  => 'lateef',
            'autoArabic'    => true,
            'margin_top'    => 8,
            'margin_bottom' => 8,
            'margin_left'   => 12,
            'margin_right'  => 12,
            'tempDir'       => storage_path('app/mpdf_tmp'),
        ]);

        $hariJawi = self::HARI_JAWI;

        if ($isNewFormat) {
            $rph->load('periods');
            $html = view('rph.pdf_gabungan', compact('rph', 'hariJawi'))->render();
        } else {
            // Legacy format — rekod lama sebelum struktur baharu
            $html = view('rph.pdf_gabungan_legacy', compact('rph', 'hariJawi'))->render();
        }

        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');
        $filename   = 'RPH-Cantum-' . $rph->date . '-' . str_replace(' ', '_', $rph->user->name ?? 'guru') . '.pdf';

        return response()->json([
            'data'     => base64_encode($pdfContent),
            'filename' => $filename,
        ]);
    }
}
