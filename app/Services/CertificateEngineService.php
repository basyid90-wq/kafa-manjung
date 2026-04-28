<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\CertificateTemplate;
use App\Models\StudentCertificate;
use Carbon\Carbon;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateEngineService
{
    // Text Y-positions (mm from top) on A4-L (297×210)
    private array $layoutPositions = [
        'center' => ['name_top' => 80,  'desc_top' => 105],
        'bottom' => ['name_top' => 120, 'desc_top' => 145],
        'left'   => ['name_top' => 90,  'desc_top' => 115],
        'right'  => ['name_top' => 90,  'desc_top' => 115],
    ];

    public function generateSinglePdf(StudentCertificate $cert): string
    {
        $cert->loadMissing(['student', 'template', 'activity']);

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4-L',
            'autoArabic'   => true,
            'default_font' => 'lateef',
            'tempDir'      => storage_path('app/mpdf_temp'),
            'margin_top'   => 0,
            'margin_right' => 0,
            'margin_bottom'=> 0,
            'margin_left'  => 0,
        ]);

        $html = $this->buildCertificateHtml(
            $cert->student,
            $cert->activity,
            $cert->template,
            $cert->reference_no
        );

        $mpdf->WriteHTML($html);

        return base64_encode($mpdf->Output('', 'S'));
    }

    public function generateBulkPdf(Activity $activity, CertificateTemplate $template): string
    {
        $attendedStudents = $activity->students()->orderBy('name')->get();

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4-L',
            'autoArabic'   => true,
            'default_font' => 'lateef',
            'tempDir'      => storage_path('app/mpdf_temp'),
            'margin_top'   => 0,
            'margin_right' => 0,
            'margin_bottom'=> 0,
            'margin_left'  => 0,
        ]);

        foreach ($attendedStudents as $index => $student) {
            // Generate or fetch reference_no
            $cert = StudentCertificate::firstOrCreate(
                [
                    'student_id'               => $student->id,
                    'certificate_template_id'  => $template->id,
                    'activity_id'              => $activity->id,
                ],
                [
                    'reference_no' => $this->generateReferenceNo(),
                    'issue_date'   => Carbon::today(),
                ]
            );

            $html = $this->buildCertificateHtml($student, $activity, $template, $cert->reference_no);

            if ($index > 0) {
                $mpdf->AddPage('L');
            }

            $mpdf->WriteHTML($html);
        }

        return base64_encode($mpdf->Output('', 'S'));
    }

    private function buildCertificateHtml($student, Activity $activity, CertificateTemplate $template, string $refNo): string
    {
        $pos    = $this->layoutPositions[$template->layout_style] ?? $this->layoutPositions['center'];
        $nameTop = $pos['name_top'];
        $descTop = $pos['desc_top'];

        $textAlign = in_array($template->layout_style, ['left']) ? 'left' : (in_array($template->layout_style, ['right']) ? 'right' : 'center');

        $bgHtml = '';
        if ($template->background_path) {
            $bgUrl  = storage_path('app/public/' . $template->background_path);
            if (file_exists($bgUrl)) {
                $bgHtml = '<img src="' . $bgUrl . '" style="position:fixed;top:0;left:0;width:297mm;height:210mm;z-index:-1;" />';
            }
        }

        $sigHtml = '';
        if ($template->include_signature && $template->signature_path) {
            $sigPath = storage_path('app/public/' . $template->signature_path);
            if (file_exists($sigPath)) {
                $sigHtml = '<div style="position:fixed;bottom:20mm;left:50%;transform:translateX(-50%);text-align:center;">
                    <img src="' . $sigPath . '" style="height:15mm;" /><br>
                    <span style="font-size:9pt;">Tandatangan</span>
                </div>';
            }
        }

        $qrUrl  = url('/verify-certificate/' . $refNo);
        $qrData = base64_encode(QrCode::format('png')->size(84)->generate($qrUrl));

        $studentName = htmlspecialchars($student->name);
        $jawiName    = $student->jawi_name ? '<div dir="rtl" style="font-family:lateef;font-size:18pt;margin-top:4pt;">' . htmlspecialchars($student->jawi_name) . '</div>' : '';
        $activityName= htmlspecialchars($activity->name);
        $dateStr     = Carbon::parse($activity->date)->translatedFormat('d F Y');
        $schoolName  = htmlspecialchars($activity->school->name ?? '');

        $marginLeft  = $template->layout_style === 'left'  ? '20mm' : ($template->layout_style === 'right' ? '100mm' : '30mm');
        $marginRight = $template->layout_style === 'right' ? '20mm' : ($template->layout_style === 'left'  ? '100mm' : '30mm');

        return <<<HTML
        <html><body style="margin:0;padding:0;font-family:Arial,sans-serif;">
        {$bgHtml}
        <div style="position:fixed;top:{$nameTop}mm;left:{$marginLeft};right:{$marginRight};text-align:{$textAlign};">
            <div style="font-size:22pt;font-weight:700;color:#1a1a2e;">{$studentName}</div>
            {$jawiName}
        </div>
        <div style="position:fixed;top:{$descTop}mm;left:{$marginLeft};right:{$marginRight};text-align:{$textAlign};">
            <div style="font-size:11pt;color:#333;line-height:1.6;">
                telah menyertai aktiviti <strong>{$activityName}</strong><br>
                pada {$dateStr}<br>
                <em style="font-size:9pt;color:#666;">{$schoolName}</em>
            </div>
        </div>
        {$sigHtml}
        <div style="position:fixed;bottom:8mm;right:8mm;">
            <img src="data:image/png;base64,{$qrData}" style="width:25mm;height:25mm;" />
            <div style="font-size:6pt;text-align:center;color:#888;">{$refNo}</div>
        </div>
        </body></html>
        HTML;
    }

    private function generateReferenceNo(): string
    {
        $year  = date('y');
        $count = StudentCertificate::whereYear('created_at', date('Y'))->count() + 1;
        return sprintf('APKM-%s-%04d', $year, $count);
    }
}
