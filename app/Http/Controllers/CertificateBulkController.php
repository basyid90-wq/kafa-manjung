<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CertificateTemplate;
use App\Models\StudentCertificate;
use App\Services\CertificateEngineService;
use Illuminate\Http\Request;

class CertificateBulkController extends Controller
{
    public function generate(Request $request, Activity $activity)
    {
        $request->validate([
            'certificate_template_id' => 'required|exists:certificate_templates,id',
        ]);

        $template = CertificateTemplate::findOrFail($request->certificate_template_id);

        $service = new CertificateEngineService();
        $base64  = $service->generateBulkPdf($activity, $template);

        return response()->json(['pdf' => $base64]);
    }

    public function downloadSingle(StudentCertificate $studentCertificate)
    {
        // Authorization: Ibu Bapa may only download their own child's cert
        $user = auth()->user();
        if ($user->hasRole('Ibu Bapa')) {
            $ic = preg_replace('/[^0-9]/', '', $user->ic_number ?? '');
            $student = $studentCertificate->student;
            if (!$ic || ($student->father_ic !== $ic && $student->mother_ic !== $ic)) {
                abort(403);
            }
        }

        $service = new CertificateEngineService();
        $base64  = $service->generateSinglePdf($studentCertificate);

        return response()->json(['pdf' => $base64]);
    }

    public function verify(string $refNo)
    {
        $cert = StudentCertificate::with([
            'student.school',
            'student.kafaClass',
            'template',
            'activity',
            'exam',
        ])->where('reference_no', $refNo)->first();

        return view('certificates.verify', compact('cert'));
    }
}
