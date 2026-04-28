<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaryRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Ibu Bapa')) {
            $studentIds = Student::where('parent_id', $user->id)->pluck('id');
            $records = DisciplinaryRecord::whereIn('student_id', $studentIds)
                ->with(['student', 'reporter'])
                ->latest()
                ->paginate(10);
        } elseif ($user->hasRole('Super Admin')) {
            $records = DisciplinaryRecord::with(['student', 'school', 'reporter'])
                ->latest()
                ->paginate(15);
        } else {
            $records = DisciplinaryRecord::where('school_id', $user->school_id)
                ->with(['student', 'reporter'])
                ->latest()
                ->paginate(10);
        }

        return view('disciplinary.index', compact('records'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Super Admin')) {
            $students = Student::all();
        } else {
            $students = Student::where('school_id', $user->school_id)->get();
        }
        
        return view('disciplinary.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'offense_details' => 'required|string',
            'action_taken' => 'required|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        DisciplinaryRecord::create([
            'student_id' => $request->student_id,
            'school_id' => $student->school_id,
            'reported_by' => Auth::id(),
            'date' => $request->date,
            'offense_details' => $request->offense_details,
            'action_taken' => $request->action_taken,
        ]);

        return redirect()->route('disciplinary.index')->with('success', 'Rekod disiplin berjaya disimpan.');
    }

    public function destroy(DisciplinaryRecord $disciplinary)
    {
        $disciplinary->delete();
        return redirect()->route('disciplinary.index')->with('success', 'Rekod disiplin telah dipadam.');
    }
}
