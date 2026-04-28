<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ParentResultController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Find students linked to this parent
        $children = Student::where('parent_id', $user->id)->get();
        
        return view('parent.results.index', compact('children'));
    }

    public function showResults(Student $student)
    {
        // Ensure this parent owns the student
        if ($student->parent_id !== auth()->id()) {
            abort(403);
        }

        $exams = Exam::whereHas('results', function($q) use ($student) {
            $q->where('student_id', $student->id);
        })->get();

        return view('parent.results.show', compact('student', 'exams'));
    }

    public function detail(Student $student, Exam $exam)
    {
        if ($student->parent_id !== auth()->id()) {
            abort(403);
        }

        $results = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->with('subject')
            ->get();

        return view('parent.results.detail', compact('student', 'exam', 'results'));
    }
}
