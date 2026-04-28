<?php

namespace App\Services;

use App\Models\FinancialRecord;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class FinancialService
{
    /**
     * Calculate current balance for a school.
     */
    public function calculateBalance($schoolId)
    {
        $totals = FinancialRecord::where('school_id', $schoolId)
            ->where('status', 'Verified')
            ->select('transaction_type', DB::raw('SUM(amount) as total'))
            ->groupBy('transaction_type')
            ->pluck('total', 'transaction_type');

        $income = $totals->get('in', 0);
        $expense = $totals->get('out', 0);

        return $income - $expense;
    }

    /**
     * Map financial record data to a PDF template.
     * Uses dummy logic as official template is not provided.
     */
    public function exportToPdfTemplate(FinancialRecord $record)
    {
        $mpdf = new Mpdf();

        // Placeholder for FPDI template mapping:
        // $pagecount = $mpdf->setSourceFile('path/to/template.pdf');
        // $tplId = $mpdf->importPage(1);
        // $mpdf->useTemplate($tplId);

        $mpdf->WriteHTML('<h1>Laporan Kewangan Sekolah</h1>');
        $mpdf->WriteHTML('<p>RUJ: ' . $record->reference_no . '</p>');
        $mpdf->WriteHTML('<table>');
        $mpdf->WriteHTML('<tr><td>Tarikh:</td><td>' . $record->transaction_date . '</td></tr>');
        $mpdf->WriteHTML('<tr><td>Kategori:</td><td>' . $record->category->name . '</td></tr>');
        $mpdf->WriteHTML('<tr><td>Keterangan:</td><td>' . $record->description . '</td></tr>');
        $mpdf->WriteHTML('<tr><td>Jumlah (RM):</td><td>' . number_format($record->amount, 2) . '</td></tr>');
        $mpdf->WriteHTML('</table>');

        return $mpdf->Output('Laporan_Kewangan_' . $record->id . '.pdf', 'I');
    }
}
