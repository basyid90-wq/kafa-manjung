<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user     = auth()->user();
        $authRole = $user->getRoleNames()->first();

        $filterDistrict = $request->input('district_id');
        $filterSchool   = $request->input('school_id');
        $filterTahun    = $request->input('tahun');
        $search         = $request->input('search');

        // ── Base scope (role isolation + archive) ──
        $applyScope = function ($q) use ($user, $authRole, $request, $filterDistrict, $filterSchool) {
            if ($authRole === 'Penyelia KAFA') {
                $q->whereHas('school', fn($sq) => $sq->where('district_id', $user->district_id));
            } elseif (!in_array($authRole, ['Super Admin', 'Pentadbir', 'Pembekal'])) {
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
            if ($filterDistrict && in_array($authRole, ['Super Admin', 'Pentadbir'])) {
                $q->whereHas('school', fn($sq) => $sq->where('district_id', $filterDistrict));
            }
            if ($filterSchool) {
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
            ->paginate(15)
            ->fragment('student-list-section')
            ->withQueryString();

        // ── Dropdown data ──
        $districts = in_array($authRole, ['Super Admin', 'Pentadbir'])
            ? District::orderBy('name')->get() : collect();

        if (in_array($authRole, ['Super Admin', 'Pentadbir'])) {
            $schools = $filterDistrict
                ? School::where('district_id', $filterDistrict)->orderBy('name')->get()
                : School::orderBy('name')->get();
        } elseif ($authRole === 'Penyelia KAFA') {
            $schools = School::where('district_id', $user->district_id)->orderBy('name')->get();
        } else {
            $schools = collect();
        }

        if ($filterSchool) {
            $classes = KafaClass::where('school_id', $filterSchool)->orderBy('tahun')->orderBy('name')->get();
        } elseif (in_array($authRole, ['Super Admin', 'Pentadbir'])) {
            $classes = $filterDistrict
                ? KafaClass::whereHas('school', fn($q) => $q->where('district_id', $filterDistrict))->orderBy('tahun')->orderBy('name')->get()
                : KafaClass::orderBy('tahun')->orderBy('name')->get();
        } elseif ($authRole === 'Penyelia KAFA') {
            $classes = KafaClass::whereHas('school', fn($q) => $q->where('district_id', $user->district_id))->orderBy('tahun')->orderBy('name')->get();
        } else {
            $classes = KafaClass::where('school_id', $user->school_id)->orderBy('tahun')->orderBy('name')->get();
        }

        $importSchools = in_array($authRole, ['Super Admin', 'Pentadbir', 'Pembekal'])
            ? School::orderBy('name')->get()
            : ($authRole === 'Penyelia KAFA'
                ? School::where('district_id', $user->district_id)->orderBy('name')->get()
                : collect());

        return view('students.index', compact(
            'students', 'classes', 'importSchools',
            'districts', 'schools',
            'tahunCounts', 'filterTahun', 'filterDistrict', 'filterSchool',
            'search', 'authRole'
        ));
    }

    public function create()
    {
        $user = auth()->user();
        $schools = null;
        $classes = collect();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $schools = \App\Models\School::all();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = \App\Models\School::where('district_id', $user->district_id)->get();
        } else {
            $classes = KafaClass::where('school_id', $user->school_id)->get();
        }

        return view('students.create', compact('classes', 'schools'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $requiresSchool = $user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal', 'Penyelia KAFA']);

        $validated = $request->validate([
            'school_id' => $requiresSchool ? 'required|exists:schools,id' : 'nullable',
            'kafa_class_id' => 'nullable|exists:kafa_classes,id',
            'name' => 'required|string|max:255',
            'jawi_name' => 'nullable|string|max:255',
            'mykid' => 'required|string|max:20|unique:students,mykid',
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
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('students', 'public');
        }

        $validated['school_id'] = $requiresSchool ? $validated['school_id'] : $user->school_id;

        // Extra district check for Penyelia KAFA to prevent cross-district tampering
        if ($user->hasRole('Penyelia KAFA')) {
            $schoolInDistrict = School::where('id', $validated['school_id'])
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

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
        $user = auth()->user();
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolInDistrict = School::where('id', $student->school_id)
                    ->where('district_id', $user->district_id)->exists();
                if (!$schoolInDistrict) abort(403);
            } else {
                if ($student->school_id !== $user->school_id) abort(403);
            }
        }
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolInDistrict = School::where('id', $student->school_id)
                    ->where('district_id', $user->district_id)->exists();
                if (!$schoolInDistrict) abort(403);
            } else {
                if ($student->school_id !== $user->school_id) abort(403);
            }
        }

        $schools = null;
        $classes = collect();

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $schools = \App\Models\School::all();
            $classes = KafaClass::where('school_id', $student->school_id)->get();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = \App\Models\School::where('district_id', $user->district_id)->get();
            $classes = KafaClass::where('school_id', $student->school_id)->get();
        } else {
            $classes = KafaClass::where('school_id', $user->school_id)->get();
        }

        return view('students.edit', compact('student', 'classes', 'schools'));
    }

    public function update(Request $request, Student $student)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolInDistrict = School::where('id', $student->school_id)
                    ->where('district_id', $user->district_id)->exists();
                if (!$schoolInDistrict) abort(403);
            } else {
                if ($student->school_id !== $user->school_id) abort(403);
            }
        }

        $requiresSchool = $user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal', 'Penyelia KAFA']);

        $validated = $request->validate([
            'school_id' => $requiresSchool ? 'required|exists:schools,id' : 'nullable',
            'kafa_class_id' => 'nullable|exists:kafa_classes,id',
            'name' => 'required|string|max:255',
            'jawi_name' => 'nullable|string|max:255',
            'mykid' => 'required|string|max:20|unique:students,mykid,' . $student->id,
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
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($student->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('students', 'public');
        }

        if ($requiresSchool) {
            // Extra district check for Penyelia KAFA
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolInDistrict = School::where('id', $validated['school_id'])
                    ->where('district_id', $user->district_id)->exists();
                if (!$schoolInDistrict) abort(403);
            }
            $student->school_id = $validated['school_id'];
        }

        $student->update($validated);

        // Auto-kemaskini / cipta akaun Ibu Bapa / Penjaga
        $this->handleParentAccountCreation($request->father_ic, $request->father_name, $request->father_phone);
        $this->handleParentAccountCreation($request->mother_ic, $request->mother_name, $request->mother_phone);

        return redirect()->route('students.index', request()->query())->with('success', 'Maklumat murid berjaya dikemaskini.');
    }

    public function destroy(Student $student)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolInDistrict = School::where('id', $student->school_id)
                    ->where('district_id', $user->district_id)->exists();
                if (!$schoolInDistrict) abort(403);
            } else {
                if ($student->school_id !== $user->school_id) abort(403);
            }
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Murid berjaya dipadam.');
    }

    private function handleParentAccountCreation(?string $ic, ?string $name, ?string $phone): void
    {
        $ic = preg_replace('/[^0-9]/', '', $ic ?? '');
        if (!$ic) return;

        $email = $ic . '@ibubapa.apkm.my';
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
        $user = auth()->user();

        // Semak hak akses: sekolah sendiri sahaja (kecuali Super Admin/Pentadbir)
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $user->school_id) abort(403);
        }

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

        // Data Isolation Security Check
        if ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('school', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        } elseif (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $query->where('school_id', $user->school_id);
        }

        $deletedCount = $query->delete();

        return redirect()->route('students.index', ['page' => $request->page])
            ->with('success', $deletedCount . ' rekod terpilih berjaya dipadam.');
    }
}
