<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\KafaClass;
use App\Models\Student;
use App\Models\ExamResult;
use App\Models\StudentAchievementRecord;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{
    protected $examService;

    // form_slot values used by Rekod Pencapaian — subjek tanpa slot ini tak akan muncul dalam rekod
    const EXPECTED_SLOTS = [
        'amali_solat', 'tilawah_tahfiz', 'akidah', 'ibadah',
        'sirah', 'adab', 'jawi_khat', 'bahasa_arab', 'lughati',
    ];

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index()
    {
        $user = auth()->user();
        $exams = Exam::where('school_id', $user->school_id)->orderBy('year', 'desc')->get();
        $classes = KafaClass::where('school_id', $user->school_id)
            ->when($user->hasRole('Guru KAFA'), fn($q) => $q->where('teacher_id', $user->id))
            ->get();

        // Tag each subject with whether it has a valid form_slot
        $subjects = Subject::where(function($q) use ($user) {
            $q->whereNull('school_id')->orWhere('school_id', $user->school_id);
        })->orderBy('name')->get()->map(function ($s) {
            $s->has_slot     = filled($s->form_slot);
            $s->slot_linked  = in_array($s->form_slot, self::EXPECTED_SLOTS);
            return $s;
        });

        // Warn if any expected slot has no subject assigned
        $assignedSlots = $subjects->whereNotNull('form_slot')->pluck('form_slot')->toArray();
        $missingSlots  = array_diff(self::EXPECTED_SLOTS, $assignedSlots);

        return view('exams.results.index', compact('exams', 'classes', 'subjects', 'missingSlots'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id'    => 'required|exists:subjects,id',
        ]);

        $authUser  = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);

        if (!$authUser->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $authUser->school_id) {
                abort(403, 'Capaian tidak dibenarkan.');
            }
        }

        $exam     = Exam::findOrFail($request->exam_id);
        $subject  = Subject::findOrFail($request->subject_id);
        $students = Student::where('kafa_class_id', $kafaClass->id)->get();

        $results = ExamResult::where('exam_id', $exam->id)
            ->where('subject_id', $subject->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        $is_locked    = $results->where('is_locked', true)->isNotEmpty();
        $slot_warning = !in_array($subject->form_slot, self::EXPECTED_SLOTS);

        return view('exams.results.show', compact('exam', 'kafaClass', 'subject', 'students', 'results', 'is_locked', 'slot_warning'));
    }

    public function enterMarks(Request $request)
    {
        $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id'    => 'required|exists:subjects,id',
        ]);

        $authUser  = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);

        if (!$authUser->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $authUser->school_id) {
                abort(403, 'Capaian tidak dibenarkan.');
            }
        }

        $exam     = Exam::findOrFail($request->exam_id);
        $subject  = Subject::findOrFail($request->subject_id);
        $students = Student::where('kafa_class_id', $kafaClass->id)->get();

        $results = ExamResult::where('exam_id', $exam->id)
            ->where('subject_id', $subject->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        if ($results->where('is_locked', true)->isNotEmpty()) {
            return redirect()->route('exams.results.show', $request->all())
                ->with('error', 'Rekod telah dikunci dan tidak boleh dikemaskini.');
        }

        $slot_warning = !in_array($subject->form_slot, self::EXPECTED_SLOTS);

        return view('exams.results.enter', compact('exam', 'kafaClass', 'subject', 'students', 'results', 'slot_warning'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id'    => 'required|exists:subjects,id',
            'marks'         => 'required|array',
            'marks.*'       => 'nullable|integer|between:0,100',
            'absent'        => 'nullable|array',
            'clear'         => 'nullable|array',  // explicit clear checkbox per student
        ]);

        $authUser  = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);

        if (!$authUser->hasAnyRole(['Super Admin', 'Pentadbir']) && $kafaClass->school_id !== $authUser->school_id) {
            abort(403, 'Capaian tidak dibenarkan.');
        }

        foreach ($request->marks as $studentId => $mark) {
            $student = Student::find($studentId);
            if (!$student || (!$authUser->hasAnyRole(['Super Admin', 'Pentadbir']) && $student->school_id !== $authUser->school_id)) {
                continue;
            }

            $existing = ExamResult::where([
                'exam_id'    => $request->exam_id,
                'subject_id' => $request->subject_id,
                'student_id' => $studentId,
            ])->first();

            if ($existing && $existing->is_locked) {
                continue;
            }

            $isAbsent    = isset($request->absent[$studentId]);
            $explicitClear = isset($request->clear[$studentId]);

            if ($isAbsent) {
                // TH — Tidak Hadir
                ExamResult::updateOrCreate(
                    ['exam_id' => $request->exam_id, 'subject_id' => $request->subject_id, 'student_id' => $studentId],
                    ['marks' => null, 'grade' => 'TH', 'is_absent' => true]
                );
            } elseif ($mark !== null && $mark !== '') {
                // Simpan markah
                $grade = $this->examService->calculateGrade($mark);
                ExamResult::updateOrCreate(
                    ['exam_id' => $request->exam_id, 'subject_id' => $request->subject_id, 'student_id' => $studentId],
                    ['marks' => $mark, 'grade' => $grade, 'is_absent' => false]
                );
            } elseif ($explicitClear && $existing) {
                // FIX 5: only delete if user ticked the explicit "Kosongkan" checkbox
                $existing->delete();
            }
            // else: mark kosong + tiada clear checkbox → skip, kekal rekod sedia ada
        }

        // FIX 2: Recalculate rankings for all achievement records that use this exam
        $this->recalculateAffectedRankings($request->exam_id);

        return redirect()->route('exams.results.show', [
            'exam_id'       => $request->exam_id,
            'kafa_class_id' => $request->kafa_class_id,
            'subject_id'    => $request->subject_id,
        ])->with('success', 'Markah telah berjaya disimpan.');
    }

    public function lockMarks(Request $request)
    {
        $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id'    => 'required|exists:subjects,id',
        ]);

        $authUser = auth()->user();
        if (!$authUser->hasRole('Guru Besar')) {
            abort(403, 'Hanya Guru Besar boleh mengesahkan markah.');
        }

        $students = Student::where('kafa_class_id', $request->kafa_class_id)->pluck('id');

        ExamResult::where('exam_id', $request->exam_id)
            ->where('subject_id', $request->subject_id)
            ->whereIn('student_id', $students)
            ->update(['is_locked' => true]);

        // FIX 2: Recalculate rankings after lock (markah confirmed = final)
        $this->recalculateAffectedRankings($request->exam_id);

        return back()->with('success', 'Markah telah disahkan, dikunci dan ranking dikemaskini.');
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    /**
     * FIX 2: Find all StudentAchievementRecords linked to this exam
     * and recalculate their rankings.
     */
    private function recalculateAffectedRankings(int $examId): void
    {
        $affected = StudentAchievementRecord::where(function ($q) use ($examId) {
            $q->where('midyear_exam_id', $examId)
              ->orWhere('endyear_exam_id', $examId);
        })->select('kafa_class_id', 'academic_year')->distinct()->get();

        foreach ($affected as $row) {
            $this->rankForClass($row->kafa_class_id, $row->academic_year);
        }
    }

    private function rankForClass(int $kafaClassId, int $academicYear): void
    {
        $records = StudentAchievementRecord::where('kafa_class_id', $kafaClassId)
            ->where('academic_year', $academicYear)
            ->get();

        if ($records->isEmpty()) return;

        $schoolId     = $records->first()->school_id;
        $totalInClass = $records->count();

        $scored = $records->map(function ($rec) {
            $mid = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $end = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            return ['model' => $rec, 'total' => $mid + $end];
        })->sortByDesc('total')->values();

        foreach ($scored as $rank => $item) {
            $item['model']->update([
                'class_rank'     => $rank + 1,
                'total_in_class' => $totalInClass,
            ]);
        }

        // School-wide ranking
        $allYear      = StudentAchievementRecord::where('school_id', $schoolId)
            ->where('academic_year', $academicYear)->get();
        $totalInGrade = $allYear->count();

        $gradeScored = $allYear->map(function ($rec) {
            $mid = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->midyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            $end = ExamResult::where('student_id', $rec->student_id)
                ->where('exam_id', $rec->endyear_exam_id)
                ->where('is_absent', false)->sum('marks');
            return ['model' => $rec, 'total' => $mid + $end];
        })->sortByDesc('total')->values();

        foreach ($gradeScored as $rank => $item) {
            $item['model']->update([
                'grade_rank'     => $rank + 1,
                'total_in_grade' => $totalInGrade,
            ]);
        }
    }
}
