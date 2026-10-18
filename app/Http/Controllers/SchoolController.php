<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    // Guru Besar may only view/edit their own school; creating and deleting schools is Super Admin only.


    private function rules(?School $school = null): array
    {
        return [
            'name'                   => 'required|string|max:255',
            'code'                   => 'nullable|string|max:50|unique:schools,code' . ($school ? ',' . $school->id : ''),
            'jenis_premis'           => 'nullable|string|max:255',
            'nama_guru_besar'        => 'nullable|string|max:255',
            'no_telefon'             => 'nullable|string|max:20',
            'alamat'                 => 'nullable|string',
            'logo'                   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attendance_cutoff_time' => 'nullable|date_format:H:i',
        ];
    }

    public function index()
    {
        $user = auth()->user();
        $query = School::query();

        if (!$user->hasRole('Super Admin')) {
            $query->where('id', $user->school_id);
        }

        $schools = $query->orderBy('name')->paginate(10);
        return view('schools.index', compact('schools'));
    }

    public function show(School $school)
    {
        $this->authorizeSchool($school->id);

        return view('schools.show', compact('school'));
    }

    public function create()
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses dinafikan.');

        return view('schools.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses dinafikan.');

        $data = $request->validate($this->rules());

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        School::create($data);

        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya ditambah.');
    }

    public function edit(School $school)
    {
        $this->authorizeSchool($school->id);

        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $this->authorizeSchool($school->id);

        $data = $request->validate($this->rules($school));

        if ($request->hasFile('logo')) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if (auth()->user()->isSuperAdmin() && $request->has('plan')) {
            $this->updatePlan($request, $school);
        }

        $school->update($data);

        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya dikemaskini.');
    }

    /** Super Admin only: manual plan activation (until online billing takes over). */
    private function updatePlan(Request $request, School $school): void
    {
        $plan = $request->validate([
            'type'            => 'required|in:' . implode(',', array_keys(config('plans.types'))),
            'plan'            => 'required|in:' . implode(',', array_keys(config('plans.plans'))),
            'plan_expires_at' => 'nullable|date',
            'owner_id'        => ['nullable', \Illuminate\Validation\Rule::exists('users', 'id')->where('school_id', $school->id)],
        ]);

        if (!in_array($plan['plan'], config("plans.types.{$plan['type']}.plans"), true)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'plan' => 'Pakej ini tidak sah untuk jenis akaun ' . config("plans.types.{$plan['type']}.label") . '.',
            ]);
        }

        if ($plan['plan'] === 'free') {
            $plan['plan_expires_at'] = null;
        }

        $school->forceFill($plan)->save();
    }

    public function destroy(School $school)
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses dinafikan.');

        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();
        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya dipadam.');
    }
}
