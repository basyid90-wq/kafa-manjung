<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\School;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /** Subjects with school_id NULL are platform defaults: visible to all, editable by Super Admin only. */
    private function authorizeSubject(Subject $subject): void
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && (int) $subject->school_id !== (int) $user->school_id) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Subject::with('school');

        if ($request->filled('school_id') && $user->isSuperAdmin()) {
            $query->where('school_id', $request->school_id);
        }

        if (!$user->isSuperAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('school_id', $user->school_id)->orWhereNull('school_id');
            });
        }

        // Sorting: platform defaults first, then per school, then by name
        $query->orderByRaw('school_id IS NOT NULL')
              ->orderBy('school_id', 'asc')
              ->orderBy('name', 'asc');

        $subjects = $query->get();

        $schools = $user->isSuperAdmin() ? School::orderBy('name')->get() : [];

        return view('subjects.index', compact('subjects', 'schools'));
    }

    public function create()
    {
        $schools = auth()->user()->isSuperAdmin() ? School::orderBy('name')->get() : [];

        return view('subjects.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'form_slot' => 'nullable|string|max:50',
        ]);

        if (!$user->isSuperAdmin()) {
            $validated['school_id'] = $user->school_id;
        }

        Subject::create($validated);
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya ditambah.');
    }

    public function edit(Subject $subject)
    {
        $this->authorizeSubject($subject);

        $schools = auth()->user()->isSuperAdmin() ? School::orderBy('name')->get() : [];

        return view('subjects.edit', compact('subject', 'schools'));
    }

    public function update(Request $request, Subject $subject)
    {
        $user = auth()->user();
        $this->authorizeSubject($subject);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'form_slot' => 'nullable|string|max:50',
        ]);

        if (!$user->isSuperAdmin()) {
            $validated['school_id'] = $user->school_id;
        }

        $subject->update($validated);

        $page = $request->input('page', 1);
        return redirect()->route('subjects.index', ['page' => $page])
            ->withFragment('row-' . $subject->id)
            ->with('success', 'Mata pelajaran berjaya dikemaskini.');
    }

    public function destroy(Subject $subject)
    {
        $this->authorizeSubject($subject);

        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya dipadam.');
    }
}
