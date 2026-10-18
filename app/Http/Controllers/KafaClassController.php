<?php

namespace App\Http\Controllers;

use App\Models\KafaClass;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KafaClassController extends Controller
{
    private function teachersOf($schoolId)
    {
        return User::role(['Guru KAFA', 'Guru Besar'])->where('school_id', $schoolId)->get();
    }

    private function validated(Request $request, User $user): array
    {
        $isSuperAdmin = $user->isSuperAdmin();
        $schoolId     = $isSuperAdmin ? $request->input('school_id') : $user->school_id;

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'tahun'      => 'required|integer|between:1,6',
            'teacher_id' => ['nullable', Rule::exists('users', 'id')->where('school_id', $schoolId)],
            'school_id'  => $isSuperAdmin ? 'required|exists:schools,id' : 'nullable',
        ], [
            'tahun.required'    => 'Sila pilih tahun pengajian.',
            'tahun.between'     => 'Tahun mesti antara 1 hingga 6.',
            'teacher_id.exists' => 'Guru yang dipilih bukan dari sekolah ini.',
        ]);

        return [
            'school_id'  => $schoolId,
            'name'       => $validated['name'],
            'tahun'      => $validated['tahun'],
            'teacher_id' => $validated['teacher_id'] ?? null,
        ];
    }

    public function index()
    {
        $user = auth()->user();
        $query = KafaClass::with(['school', 'teacher']);

        if (!$user->isSuperAdmin()) {
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

        if ($user->isSuperAdmin()) {
            $schools = School::orderBy('name')->get();
        } else {
            $teachers = $this->teachersOf($user->school_id);
        }

        return view('kafa_classes.create', compact('teachers', 'schools'));
    }

    public function store(Request $request)
    {
        KafaClass::create($this->validated($request, auth()->user()));

        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya ditambah.');
    }

    public function edit(KafaClass $kafaClass)
    {
        $user = auth()->user();
        $this->authorizeSchool($kafaClass->school_id);

        $schools  = $user->isSuperAdmin() ? School::orderBy('name')->get() : null;
        $teachers = $this->teachersOf($kafaClass->school_id);

        return view('kafa_classes.edit', compact('kafaClass', 'teachers', 'schools'));
    }

    public function update(Request $request, KafaClass $kafaClass)
    {
        $this->authorizeSchool($kafaClass->school_id);

        $kafaClass->update($this->validated($request, auth()->user()));

        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya dikemaskini.');
    }

    public function getTeachersBySchool($school_id)
    {
        $this->authorizeSchool($school_id);

        $teachers = User::role(['Guru KAFA', 'Guru Besar'])
            ->where('school_id', $school_id)
            ->get(['id', 'name']);

        return response()->json($teachers);
    }

    public function getClassesBySchool($school_id)
    {
        $this->authorizeSchool($school_id);

        $classes = KafaClass::where('school_id', $school_id)
            ->orderBy('tahun')
            ->orderBy('name')
            ->get(['id', 'name', 'tahun'])
            ->map(fn($c) => ['id' => $c->id, 'name' => $c->display_name]);

        return response()->json($classes);
    }

    public function destroy(KafaClass $kafaClass)
    {
        $this->authorizeSchool($kafaClass->school_id);

        $kafaClass->delete();
        return redirect()->route('kafa_classes.index')->with('success', 'Kelas berjaya dipadam.');
    }
}
