<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user     = auth()->user();
        $authRole = $user->getRoleNames()->first();

        $filterSchool   = $request->input('school_id');
        $filterTahun    = $request->input('tahun');
        $search         = $request->input('search');

        // ── Base scope (role isolation + archive) ──
        $applyScope = function ($q) use ($user, $request, $filterSchool) {
            if (!$user->isSuperAdmin()) {
                $q->where('school_id', $user->school_id);
            }
            if (!$request->has('show_archive')) {
                $q->whereNotIn('status', ['Berhenti', 'Pindah'])
                  ->where(fn($sq) => $sq->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) <= 13')->orWhereNull('dob'));
            } else {
                $q->where(fn($sq) => $sq->where('status', 'Berhenti')
                    ->orWhere('status', 'Pindah')
                    ->orWhereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) > 13'));
            }
            if ($filterSchool && $user->isSuperAdmin()) {
                $q->where('school_id', $filterSchool);
            }
        };

        // ── Tahun counts ──
        $tahunCounts = ['semua' => Student::query()->tap($applyScope)->count()];
        for ($t = 1; $t <= 6; $t++) {
            $tahunCounts[$t] = Student::query()->tap($applyScope)
                ->whereHas('kafaClass', fn($q) => $q->where('tahun', $t))->count();
        }

        // ── Main query ──
        $query = Student::with(['kafaClass', 'school'])->tap($applyScope);
        if ($filterTahun) {
            $query->whereHas('kafaClass', fn($q) => $q->where('tahun', $filterTahun));
        }
        if ($request->filled('class_id')) {
            $request->class_id === 'none'
                ? $query->whereNull('kafa_class_id')
                : $query->where('kafa_class_id', $request->class_id);
        }
        if ($search) {
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('mykid', 'like', "%{$search}%")
                ->orWhere('registration_no', 'like', "%{$search}%"));
        }

        $students = $query->orderBy('name')
            ->paginate(10)
            ->fragment('student-list-section')
            ->withQueryString();

        // ── Dropdown data ──
        $schools = $user->isSuperAdmin() ? School::orderBy('name')->get() : collect();

        $classes = KafaClass::query()
            ->when(!$user->isSuperAdmin(), fn($q) => $q->where('school_id', $user->school_id))
            ->when($user->isSuperAdmin() && $filterSchool, fn($q) => $q->where('school_id', $filterSchool))
            ->orderBy('tahun')->orderBy('name')->get();

        $importSchools = $schools;

        return view('students.index', compact(
            'students', 'classes', 'importSchools', 'schools',
            'tahunCounts', 'filterTahun', 'filterSchool',
            'search', 'authRole'
        ));
    }

    public function create()
    {
        $user = auth()->user();
        $schools = null;
        $classes = collect();

        if ($user->isSuperAdmin()) {
            $schools = School::orderBy('name')->get();
        } else {
            $classes = KafaClass::where('school_id', $user->school_id)->get();
        }

        return view('students.create', compact('classes', 'schools'));
    }

    /** Validation rules; class and MyKid uniqueness are scoped to the target school (tenant). */
    private function rules($schoolId, bool $requiresSchool, ?Student $student = null): array
    {
        $mykidUnique = Rule::unique('students', 'mykid')->where('school_id', $schoolId);
        if ($student) {
            $mykidUnique->ignore($student->id);
        }

        return [
            'school_id' => $requiresSchool ? 'required|exists:schools,id' : 'nullable',
            'kafa_class_id' => ['nullable', Rule::exists('kafa_classes', 'id')->where('school_id', $schoolId)],
            'name' => 'required|string|max:255',
            'jawi_name' => 'nullable|string|max:255',
            'mykid' => ['required', 'string', 'max:20', $mykidUnique],
            'gender' => 'nullable|in:L,P',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer',
            'birth_place' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:100',
            'citizenship' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'oku_status' => 'nullable|string|max:100',
            'registration_no' => 'nullable|string|max:100',
            'session_year' => 'nullable|string|max:20',
            'entry_date' => 'nullable|date',
            'origin_school' => 'nullable|string|max:255',
            'upkk_number' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:100',
            'father_name' => 'nullable|string|max:255',
            'father_ic' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'father_job' => 'nullable|string|max:255',
            'father_income' => 'nullable|numeric',
            'mother_name' => 'nullable|string|max:255',
            'mother_ic' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'mother_job' => 'nullable|string|max:255',
            'mother_income' => 'nullable|numeric',
            'dependents_count' => 'nullable|integer',
            'parents_relationship_status' => 'nullable|string|max:100',
            'chronic_disease' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
        ];
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $requiresSchool = $user->isSuperAdmin();
        $schoolId = $requiresSchool ? $request->input('school_id') : $user->school_id;

        $validated = $request->validate($this->rules($schoolId, $requiresSchool));

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('students', 'public');
        }

        $validated['school_id'] = $schoolId;

        $student = Student::create($validated);

        // Jana QR string unik untuk kad kehadiran
        $student->update([
            'qr_code_string' => 'KAFA-' . $student->school_id . '-' . $student->id . '-' . strtoupper(Str::random(8)),
        ]);

        // Auto-daftar akaun Ibu Bapa / Penjaga
        $this->handleParentAccountCreation($request->father_ic, $request->father_name, $request->father_phone);
        $this->handleParentAccountCreation($request->mother_ic, $request->mother_name, $request->mother_phone);

        return redirect()->route('students.index')->with('success', 'Murid berjaya ditambah.');
    }

    public function show(Student $student)
    {
        $this->authorizeSchool($student->school_id);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $user = auth()->user();
        $this->authorizeSchool($student->school_id);

        $schools = $user->isSuperAdmin() ? School::orderBy('name')->get() : null;
        $classes = KafaClass::where('school_id', $student->school_id)->get();

        return view('students.edit', compact('student', 'classes', 'schools'));
    }

    public function update(Request $request, Student $student)
    {
        $user = auth()->user();
        $this->authorizeSchool($student->school_id);

        $requiresSchool = $user->isSuperAdmin();
        $schoolId = $requiresSchool ? $request->input('school_id') : $student->school_id;

        $validated = $request->validate($this->rules($schoolId, $requiresSchool, $student));

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('students', 'public');
        }

        $validated['school_id'] = $schoolId;

        $student->update($validated);

        // Auto-kemaskini / cipta akaun Ibu Bapa / Penjaga
        $this->handleParentAccountCreation($request->father_ic, $request->father_name, $request->father_phone);
        $this->handleParentAccountCreation($request->mother_ic, $request->mother_name, $request->mother_phone);

        return redirect()->route('students.index', request()->query())->with('success', 'Maklumat murid berjaya dikemaskini.');
    }

    public function destroy(Student $student)
    {
        $this->authorizeSchool($student->school_id);

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Murid berjaya dipadam.');
    }

    private function handleParentAccountCreation(?string $ic, ?string $name, ?string $phone): void
    {
        $ic = preg_replace('/[^0-9]/', '', $ic ?? '');
        if (!$ic) return;

        $email = $ic . '@ibubapa.ekafa.online';
        $user  = User::where('ic_number', $ic)->first();

        if (!$user) {
            $user = User::create([
                'name'               => $name ?: ('Penjaga ' . $ic),
                'email'              => $email,
                'ic_number'          => $ic,
                'phone'              => $phone,
                'password'           => Hash::make($ic),
                'email_verified_at'  => now(),
            ]);
            $user->assignRole('Ibu Bapa');
        } else {
            $patch = [];
            if ($name)  $patch['name']  = $name;
            if ($phone) $patch['phone'] = $phone;
            if ($patch) $user->update($patch);

            if (!$user->hasRole('Ibu Bapa')) {
                $user->assignRole('Ibu Bapa');
            }
        }
    }

    public function printQrCards(KafaClass $kafaClass)
    {
        $this->authorizeSchool($kafaClass->school_id);

        // Jana QR string untuk murid yang belum ada
        $kafaClass->students()->whereNull('qr_code_string')->each(function ($s) {
            $s->update([
                'qr_code_string' => 'KAFA-' . $s->school_id . '-' . $s->id . '-' . strtoupper(Str::random(8)),
            ]);
        });

        $students = $kafaClass->students()->orderBy('name')->get();
        $school   = $kafaClass->school;

        return view('students.qr_cards', compact('students', 'kafaClass', 'school'));
    }

    public function bulkDestroy(Request $request)
    {
        $user = auth()->user();
        $studentIds = $request->input('student_ids', []);

        if (empty($studentIds)) {
            return back()->with('error', 'Tiada rekod dipilih.');
        }

        $query = Student::whereIn('id', $studentIds);

        if (!$user->isSuperAdmin()) {
            $query->where('school_id', $user->school_id);
        }

        $deletedCount = $query->delete();

        return redirect()->route('students.index', ['page' => $request->page])
            ->with('success', $deletedCount . ' rekod terpilih berjaya dipadam.');
    }
}
