<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\District;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = School::with('district');

        if ($user->hasRole('Penyelia KAFA')) {
            $query->where('district_id', $user->district_id);
        } elseif ($user->hasRole('Guru Besar')) {
            $query->where('id', $user->school_id);
        }

        $schools = $query->paginate(10);
        return view('schools.index', compact('schools'));
    }

    public function show(School $school)
    {
        return view('schools.show', compact('school'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('Guru Besar')) {
            abort(403, 'Akses dinafikan. Guru Besar tidak dibenarkan menambah sekolah.');
        }

        if ($user->hasRole('Penyelia KAFA')) {
            $districts = District::where('id', $user->district_id)->get();
        } else {
            $districts = District::all();
        }

        return view('schools.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('Guru Besar')) {
            abort(403, 'Akses dinafikan.');
        }

        if ($user->hasRole('Penyelia KAFA')) {
            $request->merge(['district_id' => $user->district_id]);
        }

        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code',
            'jenis_premis' => 'nullable|string|max:255',
            'nama_guru_besar' => 'nullable|string|max:255',
            'no_telefon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        School::create($data);

        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya ditambah.');
    }

    public function edit(School $school)
    {
        $user = auth()->user();

        if ($user->hasRole('Penyelia KAFA') && $school->district_id !== $user->district_id) {
            abort(403);
        }

        if ($user->hasRole('Penyelia KAFA')) {
            $districts = District::where('id', $user->district_id)->get();
        } else {
            $districts = District::all();
        }

        return view('schools.edit', compact('school', 'districts'));
    }

    public function update(Request $request, School $school)
    {
        $user = auth()->user();

        if ($user->hasRole('Penyelia KAFA')) {
            if ($school->district_id !== $user->district_id) abort(403);
            $request->merge(['district_id' => $user->district_id]);
        }

        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code,' . $school->id,
            'jenis_premis' => 'nullable|string|max:255',
            'nama_guru_besar' => 'nullable|string|max:255',
            'no_telefon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attendance_cutoff_time' => 'nullable|date_format:H:i',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($school->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($school->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $school->update($data);

        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya dikemaskini.');
    }

    public function destroy(School $school)
    {
        $user = auth()->user();

        if ($user->hasRole('Guru Besar') || ($user->hasRole('Penyelia KAFA') && $school->district_id !== $user->district_id)) {
            abort(403, 'Akses dinafikan.');
        }

        if ($school->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($school->logo);
        }

        $school->delete();
        return redirect()->route('schools.index')->with('success', 'Sekolah berjaya dipadam.');
    }
}
