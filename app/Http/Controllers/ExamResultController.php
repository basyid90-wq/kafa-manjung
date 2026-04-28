<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\KafaClass;
use App\Models\Student;
use App\Models\ExamResult;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index()
    {
        $user = auth()->user();
        $exams = Exam::where('school_id', $user->school_id)->get();
        $classes = KafaClass::where('school_id', $user->school_id)
            ->when($user->hasRole('Guru KAFA'), function($q) use ($user) {
                return $q->where('teacher_id', $user->id);
            })->get();
        $subjects = Subject::all();

        return view('exams.results.index', compact('exams', 'classes', 'subjects'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $authUser = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);
        
        // Anti-IDOR
        if (!$authUser->hasRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $authUser->school_id) {
                abort(403, 'Capaian tidak dibenarkan.');
            }
        }

        $exam = Exam::findOrFail($request->exam_id);
        $subject = Subject::findOrFail($request->subject_id);
        $students = Student::where('kafa_class_id', $kafaClass->id)->get();
        
        $results = ExamResult::where('exam_id', $exam->id)
            ->where('subject_id', $subject->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        // Check if any record in this selection is locked
        $is_locked = $results->where('is_locked', true)->isNotEmpty();

        return view('exams.results.show', compact('exam', 'kafaClass', 'subject', 'students', 'results', 'is_locked'));
    }

    public function enterMarks(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $authUser = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);

        // Anti-IDOR
        if (!$authUser->hasRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $authUser->school_id) {
                abort(403, 'Capaian tidak dibenarkan.');
            }
        }

        $exam = Exam::findOrFail($request->exam_id);
        $subject = Subject::findOrFail($request->subject_id);
        $students = Student::where('kafa_class_id', $kafaClass->id)->get();
        
        $results = ExamResult::where('exam_id', $exam->id)
            ->where('subject_id', $subject->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        // Block entry if locked
        if ($results->where('is_locked', true)->isNotEmpty()) {
            return redirect()->route('exams.results.show', $request->all())
                ->with('error', 'Rekod telah dikunci dan tidak boleh dikemaskini.');
        }

        return view('exams.results.enter', compact('exam', 'kafaClass', 'subject', 'students', 'results'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|between:0,100',
            'absent' => 'nullable|array',
        ]);

        $authUser = auth()->user();
        $kafaClass = KafaClass::findOrFail($request->kafa_class_id);

        // Anti-IDOR (Class validation)
        if (!$authUser->hasRole(['Super Admin', 'Pentadbir']) && $kafaClass->school_id !== $authUser->school_id) {
            abort(403, 'Capaian tidak dibenarkan.');
        }

        foreach ($request->marks as $studentId => $mark) {
            // Anti-IDOR (Student validation)
            $student = Student::find($studentId);
            if (!$student || (!$authUser->hasRole(['Super Admin', 'Pentadbir']) && $student->school_id !== $authUser->school_id)) {
                continue; // Skip invalid student
            }

            // Check Lock
            $existing = ExamResult::where([
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'student_id' => $studentId,
            ])->first();

            if ($existing && $existing->is_locked) {
                continue;
            }

            $isAbsent = isset($request->absent[$studentId]);

            if ($isAbsent) {
                // Logik TH
                ExamResult::updateOrCreate(
                    ['exam_id' => $request->exam_id, 'subject_id' => $request->subject_id, 'student_id' => $studentId],
                    ['marks' => null, 'grade' => 'TH', 'is_absent' => true]
                );
            } elseif ($mark !== null && $mark !== '') {
                // Logik Simpan
                $grade = $this->examService->calculateGrade($mark);
                ExamResult::updateOrCreate(
                    ['exam_id' => $request->exam_id, 'subject_id' => $request->subject_id, 'student_id' => $studentId],
                    ['marks' => $mark, 'grade' => $grade, 'is_absent' => false]
                );
            } elseif ($existing) {
                // Logik Padam (Null and not absent)
                $existing->delete();
            }
        }

        return redirect()->route('exams.results.show', [
            'exam_id' => $request->exam_id,
            'kafa_class_id' => $request->kafa_class_id,
            'subject_id' => $request->subject_id
        ])->with('success', 'Markah telah berjaya disimpan.');
    }

    public function lockMarks(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id' => 'required|exists:subjects,id',
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

        return back()->with('success', 'Markah telah disahkan dan dikunci.');
    }
}
