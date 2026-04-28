<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\School;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Subject::with('school');

        // Filter based on District (for Admin)
        if ($request->filled('district_id') && $user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $query->where(function($q) use ($request) {
                $q->whereHas('school', function ($sq) use ($request) {
                    $sq->where('district_id', $request->district_id);
                });
            });
        }

        // Filter based on School
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                $query->where(function($q) use ($user) {
                    $q->whereHas('school', function ($sq) use ($user) {
                        $sq->where('district_id', $user->district_id);
                    })->orWhereNull('school_id');
                });
            } else {
                $query->where(function($q) use ($user) {
                    $q->where('school_id', $user->school_id)->orWhereNull('school_id');
                });
            }
        }

        // Sorting Logic
        // Priority 1: GLOBAL (school_id IS NULL)
        // Priority 2: School (school_id ASC)
        // Priority 3: Subject Name (name ASC)
        $query->orderByRaw('school_id IS NOT NULL')
              ->orderBy('school_id', 'asc')
              ->orderBy('name', 'asc');

        $subjects = $query->get();

        // Dropdown Data
        $districts = [];
        $schools = [];
        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $districts = \App\Models\District::orderBy('name')->get();
            $schoolsQuery = \App\Models\School::query();
            if ($request->filled('district_id')) {
                $schoolsQuery->where('district_id', $request->district_id);
            }
            $schools = $schoolsQuery->orderBy('name')->get();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = \App\Models\School::where('district_id', $user->district_id)->orderBy('name')->get();
        }

        return view('subjects.index', compact('subjects', 'districts', 'schools'));
    }

    public function create()
    {
        $user = auth()->user();
        $schools = [];
        if ($user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            $schools = School::query()
                ->when($user->hasRole('Penyelia KAFA'), fn($q) => $q->where('district_id', $user->district_id))
                ->orderBy('name')
                ->get();
        }
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

        if ($user->hasRole(['Guru Besar', 'Guru KAFA'])) {
            $validated['school_id'] = $user->school_id;
        }

        Subject::create($validated);
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya ditambah.');
    }

    public function edit(Subject $subject)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA') && $subject->school && $subject->school->district_id !== $user->district_id) {
                abort(403);
            }
            if ($user->hasAnyRole(['Guru Besar', 'Guru KAFA']) && $subject->school_id !== $user->school_id) {
                abort(403);
            }
        }

        $schools = [];
        if ($user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            $schools = School::query()
                ->when($user->hasRole('Penyelia KAFA'), fn($q) => $q->where('district_id', $user->district_id))
                ->orderBy('name')
                ->get();
        }
        return view('subjects.edit', compact('subject', 'schools'));
    }

    public function update(Request $request, Subject $subject)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA') && $subject->school && $subject->school->district_id !== $user->district_id) {
                abort(403);
            }
            if ($user->hasAnyRole(['Guru Besar', 'Guru KAFA']) && $subject->school_id !== $user->school_id) {
                abort(403);
            }
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'form_slot' => 'nullable|string|max:50',
        ]);

        if ($user->hasRole(['Guru Besar', 'Guru KAFA'])) {
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
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA') && $subject->school && $subject->school->district_id !== $user->district_id) {
                abort(403);
            }
            if ($user->hasAnyRole(['Guru Besar', 'Guru KAFA']) && $subject->school_id !== $user->school_id) {
                abort(403);
            }
        }

        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya dipadam.');
    }
}
