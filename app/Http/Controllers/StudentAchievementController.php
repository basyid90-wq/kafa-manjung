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

        if ($user->hasAnyRole(['Penyelia KAFA', 'Pentadbir'])) {
            return $this->indexPenyelia($request);
        }

        return $this->indexGuru($request);
    }

    private function indexGuru(Request $request)
    {
        $user  = auth()->user();
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
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->orderBy('academic_year', 'desc')
            ->orderBy('kafa_class_id')
            ->paginate(10);

        $classes = KafaClass::where('school_id', $user->school_id ?? 0)->orderBy('name')->get();
        $years   = range(date('Y'), 2024);

        // Class completion stats for Guru Besar
        $completionStats = null;
        if ($user->hasRole('Guru Besar')) {
            $selectedYear = $request->get('academic_year', date('Y'));
            $completionStats = KafaClass::where('school_id', $user->school_id)
                ->withCount([
                    'students as students_count',
                    'achievementRecords as recorded_count' => fn($q) => $q->where('academic_year', $selectedYear),
                    'achievementRecords as final_count'    => fn($q) => $q->where('academic_year', $selectedYear)->where('status', 'final'),
                ])->orderBy('name')->get();
        }

        return view('achievements.index', compact('records', 'classes', 'years', 'completionStats'));
    }

    private function indexPenyelia(Request $request)
    {
        $user        = auth()->user();
        $selectedYear = (int) $request->get('academic_year', date('Y'));

        $schoolsQuery = \App\Models\School::query();

        if ($user->hasRole('Penyelia KAFA')) {
            $schoolsQuery->where('district_id', $user->district_id);
        }

        $schools = $schoolsQuery->withCount([
            'students as students_count',
            'achievementRecords as achievements_count' => fn($q) => $q->where('academic_year', $selectedYear),
        ])->orderBy('name')->get();

        // Ranking: sort by achievement % descending
        $schools = $schools->sortByDesc(function ($s) {
            return $s->students_count > 0 ? ($s->achievements_count / $s->students_count) : 0;
        })->values();

        // Summary stats
        $totalSchools   = $schools->count();
        $totalStudents  = $schools->sum('students_count');
        $totalRecorded  = $schools->sum('achievements_count');
        $overallPct     = $totalStudents > 0 ? round(($totalRecorded / $totalStudents) * 100, 1) : 0;
        $belumRekod     = $schools->where('achievements_count', 0)->count();

        $summary = compact('totalSchools', 'totalStudents', 'totalRecorded', 'overallPct', 'belumRekod');

        // Top 10 students for selected year
        $topStudentsQuery = StudentAchievementRecord::with(['student', 'school'])
            ->where('academic_year', $selectedYear);

        if ($user->hasRole('Penyelia KAFA')) {
            $topStudentsQuery->whereHas('school', fn($q) => $q->where('district_id', $user->district_id));
        }

        $topStudents = $topStudentsQuery->get()->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $rec->total_marks = $midSum + $endSum;
            return $rec;
        })->sortByDesc('total_marks')->take(10)->values();

        $years = range(date('Y'), 2024);

        return view('achievements.index_penyelia', compact('schools', 'topStudents', 'summary', 'selectedYear', 'years'));
    }

    public function schoolList(\App\Models\School $school, Request $request)
    {
        $user = auth()->user();

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
        if ($request->filled('status')) {
            $query->where('status', $request->status);
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

        // Security: verify selected class belongs to user's school
        $selectedClass   = null;
        $existingRecords = collect();
        if ($request->filled('kafa_class_id')) {
            $selectedClass = KafaClass::with('students')
                ->where('school_id', $user->school_id)
                ->find($request->kafa_class_id);

            if (!$selectedClass) {
                return redirect()->route('achievements.create')
                    ->with('error', 'Kelas tidak dijumpai atau tidak dalam sekolah anda.');
            }

            // Load all existing records for students in this class
            $studentIds = $selectedClass->students->pluck('id');
            $existingRecords = StudentAchievementRecord::whereIn('student_id', $studentIds)
                ->orderBy('academic_year', 'desc')
                ->get()
                ->keyBy('student_id');
        }

        $scrollToStudents = $request->filled('kafa_class_id');

        return view('achievements.create', compact('classes', 'exams', 'selectedClass', 'scrollToStudents', 'existingRecords'));
    }

    public function edit(StudentAchievementRecord $achievement, Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Guru Besar', 'Guru KAFA', 'Super Admin'])) {
            abort(403);
        }

        // Security: verify achievement belongs to user's school
        if (!$user->hasRole('Super Admin') && $achievement->school_id !== $user->school_id) {
            abort(403, 'Anda tidak dibenarkan mengedit rekod ini.');
        }

        // Status lock: Guru KAFA cannot edit Final records (Guru Besar + Super Admin can unlock)
        if ($achievement->status === 'final' && $user->hasRole('Guru KAFA')) {
            return redirect()->route('achievements.show', $achievement->id)
                ->with('error', 'Rekod ini telah difinalkan. Hubungi Guru Besar untuk membuka semula.');
        }

        $classes = KafaClass::where('school_id', $user->school_id ?? $achievement->school_id)->orderBy('name')->get();
        $exams   = Exam::where('school_id', $user->school_id ?? $achievement->school_id)
            ->whereIn('term', ['pertengahan_tahun', 'akhir_tahun'])
            ->orderBy('year', 'desc')
            ->get();

        $selectedClass = $achievement->kafaClass()->with('students')->first();

        $existingRecords = StudentAchievementRecord::where('kafa_class_id', $achievement->kafa_class_id)
            ->where('academic_year', $achievement->academic_year)
            ->get()
            ->keyBy('student_id');

        $page = $request->page;
        $scrollToStudents = true;

        return view('achievements.create', compact('classes', 'exams', 'selectedClass', 'existingRecords', 'achievement', 'page', 'scrollToStudents'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'kafa_class_id'      => 'required|exists:kafa_classes,id',
            'academic_year'      => 'required|integer|min:2000|max:2099',
            'midyear_exam_id'    => 'nullable|exists:exams,id',
            'endyear_exam_id'    => 'nullable|exists:exams,id',
            'phci_midyear.*'     => 'nullable|integer|min:0|max:100',
            'phci_endyear.*'     => 'nullable|integer|min:0|max:100',
            'kelakuan.*'         => 'nullable|in:A,B,C,D',
            'kebersihan.*'       => 'nullable|in:A,B,C,D',
            'amali_solat.*'      => 'nullable|in:Lulus,Tidak Lulus',
            'teacher_comments.*' => 'nullable|string|max:1000',
            'status'             => 'nullable|in:draft,final',
        ]);

        // Security: verify class belongs to user's school
        $class = KafaClass::with('students')
            ->where('school_id', $user->school_id)
            ->findOrFail($request->kafa_class_id);

        $students = $class->students;

        DB::transaction(function () use ($request, $user, $students) {
            foreach ($students as $student) {
                if ($student->school_id !== $user->school_id) {
                    continue;
                }

                // Respect status lock: skip Final records for Guru KAFA
                $existing = StudentAchievementRecord::where('student_id', $student->id)
                    ->where('academic_year', $request->academic_year)
                    ->first();

                if ($existing && $existing->status === 'final' && auth()->user()->hasRole('Guru KAFA')) {
                    continue;
                }

                $phciMid    = $request->input("phci_midyear.{$student->id}");
                $phciEnd    = $request->input("phci_endyear.{$student->id}");
                $kelakuan   = $request->input("kelakuan.{$student->id}");
                $kebersihan = $request->input("kebersihan.{$student->id}");
                $amaliSolat = $request->input("amali_solat.{$student->id}");
                $comments   = $request->input("teacher_comments.{$student->id}");

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
                        'amali_solat'      => $amaliSolat ?: null,
                        'teacher_comments' => $comments,
                        'generated_by'     => $user->id,
                        'status'           => $request->input('status', 'draft'),
                    ]
                );
            }
        });

        $this->recalculateRankings($request->kafa_class_id, $request->academic_year);

        return redirect()->route('achievements.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Rekod pencapaian berjaya disimpan.');
    }

    public function bulkFinalize(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Guru Besar', 'Super Admin'])) {
            abort(403, 'Hanya Guru Besar boleh finalisasikan rekod kelas.');
        }

        $request->validate([
            'kafa_class_id'  => 'required|exists:kafa_classes,id',
            'academic_year'  => 'required|integer|min:2000|max:2099',
        ]);

        $class = KafaClass::where('school_id', $user->school_id)->findOrFail($request->kafa_class_id);

        $updated = StudentAchievementRecord::where('kafa_class_id', $class->id)
            ->where('academic_year', $request->academic_year)
            ->where('status', 'draft')
            ->update(['status' => 'final']);

        return redirect()->back()
            ->with('success', "{$updated} rekod kelas {$class->name} ({$request->academic_year}) telah difinalkan.");
    }

    public function unlock(StudentAchievementRecord $achievement)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Guru Besar', 'Super Admin'])) {
            abort(403, 'Hanya Guru Besar boleh membuka semula rekod final.');
        }

        if (!$user->hasRole('Super Admin') && $achievement->school_id !== $user->school_id) {
            abort(403);
        }

        $achievement->update(['status' => 'draft']);

        return redirect()->route('achievements.edit', $achievement->id)
            ->with('success', 'Rekod berjaya dibuka semula sebagai Draf.');
    }

    public function show(StudentAchievementRecord $achievement)
    {
        $user = auth()->user();
        $this->authorizeRecordAccess($achievement, $user);

        $achievement->load(['student', 'kafaClass', 'school', 'midyearExam', 'endyearExam']);

        $subjects   = $this->getSubjectsWithSlots($achievement->school_id);
        $midResults = $this->getResultsBySlot($achievement->student_id, $achievement->midyear_exam_id);
        $endResults = $this->getResultsBySlot($achievement->student_id, $achievement->endyear_exam_id);

        return view('achievements.show', compact('achievement', 'subjects', 'midResults', 'endResults'));
    }

    public function generatePdf(StudentAchievementRecord $achievement)
    {
        $user = auth()->user();
        $this->authorizeRecordAccess($achievement, $user);

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
            'margin_bottom'=> 6,
            'margin_left'  => 8,
            'margin_right' => 8,
        ]);
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetTitle('Rekod Pencapaian Murid');
        $mpdf->WriteHTML($html);

        $base64 = base64_encode($mpdf->Output('', 'S'));
        $name   = 'Rekod-Pencapaian-' . str_replace(' ', '-', $achievement->student->name) . '-' . $achievement->academic_year . '.pdf';

        return response()->json(['data' => $base64, 'filename' => $name]);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function authorizeRecordAccess(StudentAchievementRecord $achievement, $user): void
    {
        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            return;
        }

        if ($user->hasRole('Penyelia KAFA')) {
            $school = \App\Models\School::find($achievement->school_id);
            if (!$school || $school->district_id !== $user->district_id) {
                abort(403, 'Akses tidak dibenarkan.');
            }
            return;
        }

        if ($achievement->school_id !== $user->school_id) {
            abort(403, 'Akses tidak dibenarkan.');
        }
    }

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

        $schoolId     = $records->first()->school_id;
        $totalInClass = $records->count();

        $scored = $records->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            return ['model' => $rec, 'total' => $midSum + $endSum];
        })->sortByDesc('total')->values();

        foreach ($scored as $rank => $item) {
            $item['model']->update([
                'class_rank'     => $rank + 1,
                'total_in_class' => $totalInClass,
            ]);
        }

        $allYear      = StudentAchievementRecord::where('school_id', $schoolId)
            ->where('academic_year', $academicYear)->get();
        $totalInGrade = $allYear->count();

        $gradeScored = $allYear->map(function ($rec) {
            $midSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $endSum = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            return ['model' => $rec, 'total' => $midSum + $endSum];
        })->sortByDesc('total')->values();

        foreach ($gradeScored as $rank => $item) {
            $item['model']->update([
                'grade_rank'     => $rank + 1,
                'total_in_grade' => $totalInGrade,
            ]);
        }
    }
}
