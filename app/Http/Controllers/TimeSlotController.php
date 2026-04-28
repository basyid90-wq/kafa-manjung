<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $slots = TimeSlot::where('school_id', $schoolId)
            ->orderBy('start_time')
            ->get();

        return view('time_slots.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        TimeSlot::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Slot masa berjaya ditambah.');
    }

    public function update(Request $request, TimeSlot $timeSlot)
    {
        // Data Isolation check
        if ($timeSlot->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $timeSlot->update($request->only('name', 'start_time', 'end_time'));

        return back()->with('success', 'Slot masa berjaya dikemaskini.');
    }

    public function destroy(TimeSlot $timeSlot)
    {
        // Data Isolation check
        if ($timeSlot->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $timeSlot->delete();

        return back()->with('success', 'Slot masa berjaya dipadam.');
    }
}
