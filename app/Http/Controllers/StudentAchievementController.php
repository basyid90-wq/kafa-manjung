<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\KafaClass;
use App\Models\StudentAchievementRecord;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAchievementController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Penyelia KAFA & Pentadbir: Paparan Analitik
        if ($user->hasAnyRole(['Penyelia KAFA', 'Pentadbir'])) {
            return $this->indexPenyelia($request);
        }

        // Guru Besar & Guru KAFA: Paparan Senarai Pelajar
        return $this->indexGuru($request);
    }

    private function indexGuru(Request $request)
    {
        $user = auth()->user();
        $query = StudentAchievementRecord::with(['student', 'kafaClass', 'school']);

        if ($user->hasRole('Super Admin')) {
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query->where('school_id', $user->school_id);
        }

        if ($request->filled('kafa_class_id')) {
            $query->where('kafa_class_id', $request->kafa_class_id);
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $records = $query->orderBy('academic_year', 'desc')
            ->orderBy('kafa_class_id')
            ->paginate(10);

        $classes = KafaClass::where('school_id', $user->school_id ?? 0)->orderBy('name')->get();
        $years   = range(date('Y'), 2024);

        return view('achievements.index', compact('records', 'classes', 'years'));
    }

    private function indexPenyelia(Request $request)
    {
        $user = auth()->user();
        $currentYear = date('Y');

        // Query Senarai Sekolah dengan statistik
        $schoolsQuery = \App\Models\School::query();

        if ($user->hasRole('Penyelia KAFA')) {
            $schoolsQuery->where('district_id', $user->district_id);
        }

        $schools = $schoolsQuery->withCount([
            'students',
            'achievementRecords as achievements_count' => function ($q) use ($currentYear) {
                $q->where('academic_year', $currentYear);
            }
        ])->orderBy('name')->get();

        // Query Top 10 Pelajar Terbaik
        $topStudentsQuery = StudentAchievementRecord::with(['student', 'school'])
            ->where('academic_year', $currentYear);

        if ($user->hasRole('Penyelia KAFA')) {
            $topStudentsQuery->whereHas('school', fn($q) => $q->where('district_id', $user->district_id));
        }

        $topStudents = $topStudentsQuery->get()->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $rec->total_marks = $midSum + $endSum;
            return $rec;
        })->sortByDesc('total_marks')->take(10)->values();

        return view('achievements.index_penyelia', compact('schools', 'topStudents'));
    }

    public function schoolList(\App\Models\School $school, Request $request)
    {
        $user = auth()->user();

        // Pastikan Penyelia hanya boleh akses sekolah dalam daerahnya
        if ($user->hasRole('Penyelia KAFA') && $school->district_id !== $user->district_id) {
            abort(403, 'Akses tidak dibenarkan.');
        }

        $query = StudentAchievementRecord::with(['student', 'kafaClass', 'school'])
            ->where('school_id', $school->id);

        if ($request->filled('kafa_class_id')) {
            $query->where('kafa_class_id', $request->kafa_class_id);
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $records = $query->orderBy('academic_year', 'desc')
            ->orderBy('kafa_class_id')
            ->paginate(10);

        $classes = KafaClass::where('school_id', $school->id)->orderBy('name')->get();
        $years   = range(date('Y'), 2024);

        return view('achievements.index', compact('records', 'classes', 'years', 'school'));
    }

    public function create(Request $request)
    {
        $user    = auth()->user();
        $classes = KafaClass::where('school_id', $user->school_id)->orderBy('name')->get();
        $exams   = Exam::where('school_id', $user->school_id)
            ->whereIn('term', ['pertengahan_tahun', 'akhir_tahun'])
            ->orderBy('year', 'desc')
            ->get();

        $selectedClass = $request->kafa_class_id
            ? KafaClass::with('students')->find($request->kafa_class_id)
            : null;

        return view('achievements.create', compact('classes', 'exams', 'selectedClass'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'kafa_class_id'    => 'required|exists:kafa_classes,id',
            'academic_year'    => 'required|integer|min:2000|max:2099',
            'midyear_exam_id'  => 'nullable|exists:exams,id',
            'endyear_exam_id'  => 'nullable|exists:exams,id',
            'phci.*'           => 'nullable|integer|min:0|max:100',
            'kelakuan'         => 'nullable|in:A,B,C,D',
            'kebersihan'       => 'nullable|in:A,B,C,D',
            'teacher_comments' => 'nullable|string',
            'status'           => 'nullable|in:draft,final',
        ]);

        $class   = KafaClass::with('students')->findOrFail($request->kafa_class_id);
        $students = $class->students;

        DB::transaction(function () use ($request, $user, $students) {
            foreach ($students as $student) {
                $phciMid = $request->input("phci_midyear.{$student->id}");
                $phciEnd = $request->input("phci_endyear.{$student->id}");
                $kelakuan    = $request->input("kelakuan.{$student->id}");
                $kebersihan  = $request->input("kebersihan.{$student->id}");
                $comments    = $request->input("teacher_comments.{$student->id}");

                StudentAchievementRecord::updateOrCreate(
                    [
                        'student_id'    => $student->id,
                        'academic_year' => $request->academic_year,
                    ],
                    [
                        'school_id'        => $user->school_id,
                        'kafa_class_id'    => $request->kafa_class_id,
                        'midyear_exam_id'  => $request->midyear_exam_id ?: null,
                        'endyear_exam_id'  => $request->endyear_exam_id ?: null,
                        'phci_midyear'     => is_numeric($phciMid) ? $phciMid : null,
                        'phci_endyear'     => is_numeric($phciEnd) ? $phciEnd : null,
                        'kelakuan'         => $kelakuan ?: null,
                        'kebersihan'       => $kebersihan ?: null,
                        'teacher_comments' => $comments,
                        'generated_by'     => $user->id,
                        'status'           => $request->input('status', 'draft'),
                    ]
                );
            }
        });

        // Recalculate rankings after save
        $this->recalculateRankings($request->kafa_class_id, $request->academic_year);

        return redirect()->route('achievements.index')
            ->with('success', 'Rekod pencapaian berjaya disimpan.');
    }

    public function show(StudentAchievementRecord $achievement)
    {
        $achievement->load(['student', 'kafaClass', 'school', 'midyearExam', 'endyearExam']);

        $subjects = $this->getSubjectsWithSlots($achievement->school_id);
        $midResults = $this->getResultsBySlot($achievement->student_id, $achievement->midyear_exam_id);
        $endResults = $this->getResultsBySlot($achievement->student_id, $achievement->endyear_exam_id);

        return view('achievements.show', compact('achievement', 'subjects', 'midResults', 'endResults'));
    }

    public function generatePdf(StudentAchievementRecord $achievement)
    {
        $achievement->load(['student', 'kafaClass', 'school', 'midyearExam', 'endyearExam', 'generatedBy']);

        $subjects    = $this->getSubjectsWithSlots($achievement->school_id);
        $midResults  = $this->getResultsBySlot($achievement->student_id, $achievement->midyear_exam_id);
        $endResults  = $this->getResultsBySlot($achievement->student_id, $achievement->endyear_exam_id);
        $examService = $this->examService;

        $html = view('achievements.pdf', compact(
            'achievement', 'subjects', 'midResults', 'endResults', 'examService'
        ))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode'         => 'utf-8',
            'autoArabic'   => true,
            'default_font' => 'lateef',
            'format'       => 'A4',
            'tempDir'      => storage_path('app/mpdf_temp'),
            'margin_top'   => 8,
            'margin_bottom'=> 8,
            'margin_left'  => 10,
            'margin_right' => 10,
        ]);
        $mpdf->SetTitle('Rekod Pencapaian Murid');
        $mpdf->WriteHTML($html);

        $base64 = base64_encode($mpdf->Output('', 'S'));
        $name   = 'Rekod-Pencapaian-' . str_replace(' ', '-', $achievement->student->name) . '-' . $achievement->academic_year . '.pdf';

        return response()->json(['data' => $base64, 'filename' => $name]);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function getSubjectsWithSlots($schoolId)
    {
        return Subject::where(function ($q) use ($schoolId) {
            $q->whereNull('school_id')->orWhere('school_id', $schoolId);
        })
        ->whereNotNull('form_slot')
        ->orderBy('form_slot')
        ->get()
        ->keyBy('form_slot');
    }

    private function getResultsBySlot($studentId, $examId)
    {
        if (!$examId) return collect();

        return ExamResult::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->with('subject')
            ->get()
            ->filter(fn($r) => $r->subject && $r->subject->form_slot)
            ->keyBy(fn($r) => $r->subject->form_slot);
    }

    private function recalculateRankings($kafaClassId, $academicYear)
    {
        $records = StudentAchievementRecord::where('kafa_class_id', $kafaClassId)
            ->where('academic_year', $academicYear)
            ->with(['student'])
            ->get();

        if ($records->isEmpty()) return;

        $schoolId = $records->first()->school_id;
        $totalInClass = $records->count();

        // Sum total marks (midyear + endyear) for ranking
        $scored = $records->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $rec->_total = $midSum + $endSum;
            return $rec;
        })->sortByDesc('_total')->values();

        foreach ($scored as $rank => $rec) {
            $rec->update([
                'class_rank'      => $rank + 1,
                'total_in_class'  => $totalInClass,
            ]);
        }

        // Grade ranking: across all classes in same academic year & school
        $allYear = StudentAchievementRecord::where('school_id', $schoolId)
            ->where('academic_year', $academicYear)
            ->get();

        $totalInGrade = $allYear->count();

        $gradeScored = $allYear->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)
                ->sum('marks');
            $rec->_total = $midSum + $endSum;
            return $rec;
        })->sortByDesc('_total')->values();

        foreach ($gradeScored as $rank => $rec) {
            $rec->update([
                'grade_rank'     => $rank + 1,
                'total_in_grade' => $totalInGrade,
            ]);
        }
    }
}
