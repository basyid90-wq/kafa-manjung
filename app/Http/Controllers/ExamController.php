<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Exam::query();

        // FASA 5: Tapisan Keselamatan Global
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $query->where('school_id', $user->school_id);
        }

        $exams = $query->get();
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'school_id' => $user->hasAnyRole(['Super Admin', 'Pentadbir']) ? 'required|exists:schools,id' : 'nullable',
        ]);

        Exam::create([
            'school_id' => $user->hasAnyRole(['Super Admin', 'Pentadbir']) ? $request->school_id : $user->school_id,
            'name' => $request->name,
            'year' => $request->year,
            'term' => $request->input('term', 'lain'),
        ]);

        return redirect()->route('exams.index')->with('success', 'Peperiksaan berjaya dicipta.');
    }

    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
        ]);

        $exam->update($request->only('name', 'year'));

        return redirect()->route('exams.index')->with('success', 'Peperiksaan berjaya dikemaskini.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Peperiksaan berjaya dipadam.');
    }
}
