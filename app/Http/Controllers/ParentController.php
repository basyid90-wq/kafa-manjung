<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\StudentCertificate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $ic   = preg_replace('/[^0-9]/', '', $user->ic_number ?? '');

        $children = collect();

        if ($ic) {
            $children = Student::with(['school', 'kafaClass'])
                ->where(function ($q) use ($ic) {
                    $q->where('father_ic', $ic)
                      ->orWhere('mother_ic', $ic);
                })
                ->orderBy('name')
                ->get();
        }

        return view('parents.dashboard', compact('children'));
    }

    public function showStudent(Student $student)
    {
        $user = Auth::user();
        $ic   = preg_replace('/[^0-9]/', '', $user->ic_number ?? '');

        // Strict: parent can only view their own child
        if (!$ic || ($student->father_ic !== $ic && $student->mother_ic !== $ic)) {
            abort(403, 'Akses tidak dibenarkan.');
        }

        $student->load(['school', 'kafaClass']);

        // --- Tab 1: Attendance monthly summary (current year) ---
        $year = now()->year;
        $attendanceRows = Attendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->get();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $key   = sprintf('%04d-%02d', $year, $m);
            $group = $attendanceRows->filter(fn($a) => Carbon::parse($a->date)->format('Y-m') === $key);
            if ($group->count() === 0) continue;
            $months[$key] = [
                'label'       => Carbon::createFromDate($year, $m, 1)->translatedFormat('F Y'),
                'hadir'       => $group->where('status', 'Hadir')->count(),
                'lewat'       => $group->where('status', 'Lewat')->count(),
                'tidak_hadir' => $group->where('status', 'Tidak Hadir')->count(),
                'cuti_sakit'  => $group->where('status', 'Cuti Sakit')->count(),
                'total'       => $group->count(),
            ];
        }

        $attendanceTotals = [
            'hadir'       => $attendanceRows->where('status', 'Hadir')->count(),
            'lewat'       => $attendanceRows->where('status', 'Lewat')->count(),
            'tidak_hadir' => $attendanceRows->where('status', 'Tidak Hadir')->count(),
            'cuti_sakit'  => $attendanceRows->where('status', 'Cuti Sakit')->count(),
            'total'       => $attendanceRows->count(),
        ];

        // --- Tab 2: Academic results grouped by exam ---
        $examResultGroups = ExamResult::where('student_id', $student->id)
            ->with(['exam', 'subject'])
            ->get()
            ->groupBy('exam_id');

        $examsById = Exam::whereIn('id', $examResultGroups->keys())->get()->keyBy('id');

        // --- Tab 3: Digital Certificates ---
        $certificates = StudentCertificate::where('student_id', $student->id)
            ->with(['template', 'activity', 'exam'])
            ->latest('issue_date')
            ->get();

        return view('parents.student_profile', compact(
            'student', 'months', 'attendanceTotals',
            'examResultGroups', 'examsById', 'certificates', 'year'
        ));
    }
}
