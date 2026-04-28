<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        return view('districts.index', compact('districts'));
    }

    public function create()
    {
        return view('districts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        District::create($request->all());

        return redirect()->route('districts.index')->with('success', 'Daerah berjaya ditambah.');
    }

    public function show(District $district)
    {
        $district->load(['schools' => function($q) {
            $q->withCount('students');
        }]);
        return view('districts.show', compact('district'));
    }

    public function edit(District $district)
    {
        return view('districts.edit', compact('district'));
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        $district->update($request->all());

        return redirect()->route('districts.index')->with('success', 'Daerah berjaya dikemaskini.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('districts.index')->with('success', 'Daerah berjaya dipadam.');
    }
}
