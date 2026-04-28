<?php

namespace App\Http\Controllers;

use App\Models\KafaClass;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class KafaClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = KafaClass::with(['school', 'teacher']);

        if ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('school', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        } elseif (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $query->where('school_id', $user->school_id);
        }

        $classes = $query->orderBy('tahun')->orderBy('name')->paginate(10);
        return view('kafa_classes.index', compact('classes'));
    }

    public function create()
    {
        $user = auth()->user();
        $schools = null;
        $teachers = collect();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schools = School::all();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = School::where('district_id', $user->district_id)->get();
        } else {
            $teachers = User::role(['Guru KAFA', 'Guru Besar'])
                ->where('school_id', $user->school_id)
                ->get();
        }

        return view('kafa_classes.create', compact('teachers', 'schools'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $requiresSchool = $user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'tahun'      => 'required|integer|between:1,6',
            'teacher_id' => 'nullable|exists:users,id',
            'school_id'  => $requiresSchool ? 'required|exists:schools,id' : 'nullable',
        ], [
            'tahun.required' => 'Sila pilih tahun pengajian.',
            'tahun.between'  => 'Tahun mesti antara 1 hingga 6.',
        ]);

        // Extra district check for Penyelia KAFA
        if ($user->hasRole('Penyelia KAFA')) {
            $schoolInDistrict = School::where('id', $validated['school_id'])
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        KafaClass::create([
            'school_id'  => $requiresSchool ? $validated['school_id'] : $user->school_id,
            'name'       => $validated['name'],
            'tahun'      => $validated['tahun'],
            'teacher_id' => $validated['teacher_id'],
        ]);

        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya ditambah.');
    }

    public function edit(KafaClass $kafaClass)
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            // Full access
        } elseif ($user->hasRole('Penyelia KAFA')) {
            if ($kafaClass->school->district_id !== $user->district_id) abort(403);
        } else {
            if ($kafaClass->school_id !== $user->school_id) abort(403);
        }

        $schools = null;
        $teachers = collect();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schools = School::all();
            $teachers = User::role(['Guru KAFA', 'Guru Besar'])
                ->where('school_id', $kafaClass->school_id)
                ->get();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = School::where('district_id', $user->district_id)->get();
            $teachers = User::role(['Guru KAFA', 'Guru Besar'])
                ->where('school_id', $kafaClass->school_id)
                ->get();
        } else {
            $teachers = User::role(['Guru KAFA', 'Guru Besar'])
                ->where('school_id', $user->school_id)
                ->get();
        }

        return view('kafa_classes.edit', compact('kafaClass', 'teachers', 'schools'));
    }

    public function update(Request $request, KafaClass $kafaClass)
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            // Full access
        } elseif ($user->hasRole('Penyelia KAFA')) {
            if ($kafaClass->school->district_id !== $user->district_id) abort(403);
        } else {
            if ($kafaClass->school_id !== $user->school_id) abort(403);
        }

        $requiresSchool = $user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'tahun'      => 'required|integer|between:1,6',
            'teacher_id' => 'nullable|exists:users,id',
            'school_id'  => $requiresSchool ? 'required|exists:schools,id' : 'nullable',
        ], [
            'tahun.required' => 'Sila pilih tahun pengajian.',
            'tahun.between'  => 'Tahun mesti antara 1 hingga 6.',
        ]);

        // Extra district check for Penyelia KAFA
        if ($user->hasRole('Penyelia KAFA')) {
            $schoolInDistrict = School::where('id', $validated['school_id'])
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        $kafaClass->update([
            'name'       => $validated['name'],
            'tahun'      => $validated['tahun'],
            'teacher_id' => $validated['teacher_id'],
            'school_id'  => $requiresSchool ? $validated['school_id'] : $user->school_id,
        ]);

        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya dikemaskini.');
    }

    public function getTeachersBySchool($school_id)
    {
        $teachers = User::role(['Guru KAFA', 'Guru Besar'])
            ->where('school_id', $school_id)
            ->get(['id', 'name']);

        return response()->json($teachers);
    }

    public function getClassesBySchool($school_id)
    {
        $classes = KafaClass::where('school_id', $school_id)
            ->orderBy('tahun')
            ->orderBy('name')
            ->get(['id', 'name', 'tahun'])
            ->map(fn($c) => ['id' => $c->id, 'name' => $c->display_name]);

        return response()->json($classes);
    }

    public function destroy(KafaClass $kafaClass)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                if ($kafaClass->school->district_id !== $user->district_id) abort(403);
            } else {
                if ($kafaClass->school_id !== $user->school_id) abort(403);
            }
        }

        $kafaClass->delete();
        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya dipadam.');
    }
}
