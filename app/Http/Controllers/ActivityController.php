<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /** "Tahap" describes the event level only; every activity is owned by one school (tenant). */
    private const TAHAP_OPTIONS = [
        'sekolah' => 'Peringkat Sekolah',
        'daerah'  => 'Peringkat Daerah',
        'negeri'  => 'Peringkat Negeri',
    ];

    public function index()
    {
        $user = Auth::user();

        $activities = Activity::with('school')
            ->when(!$user->isSuperAdmin(), fn($q) => $q->where('school_id', $user->school_id))
            ->latest()
            ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $tahapOptions = self::TAHAP_OPTIONS;

        return view('activities.create', compact('tahapOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahap'       => 'required|in:sekolah,daerah,negeri',
        ]);

        $user = Auth::user();
        abort_unless($user->school_id, 403, 'Akaun anda belum dikaitkan dengan mana-mana sekolah.');

        $data = $request->only(['name', 'date', 'description', 'tahap']);
        $data['school_id'] = $user->school_id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('activities', 'public');
        }

        Activity::create($data);

        return redirect()->route('activities.index')->with('success', 'Aktiviti berjaya didaftarkan.');
    }

    public function show(Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        $attendedStudents = $activity->students()
            ->with(['kafaClass', 'school', 'certificates' => fn($q) => $q->where('activity_id', $activity->id)])
            ->orderBy('name')
            ->get();

        $templates = \App\Models\CertificateTemplate::query()
            ->where(fn($q) => $q->where('school_id', $activity->school_id)->orWhereNull('school_id'))
            ->orderBy('name')
            ->get();

        return view('activities.show', compact('activity', 'attendedStudents', 'templates'));
    }

    public function edit(Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        $tahapOptions = self::TAHAP_OPTIONS;

        return view('activities.edit', compact('activity', 'tahapOptions'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahap'       => 'required|in:sekolah,daerah,negeri',
        ]);

        $data = $request->only(['name', 'date', 'description', 'tahap']);

        if ($request->hasFile('photo')) {
            if ($activity->photo_path) {
                Storage::disk('public')->delete($activity->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('activities', 'public');
        }

        $activity->update($data);

        return redirect()->route('activities.index')->with('success', 'Aktiviti berjaya dikemaskini.');
    }

    public function destroy(Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        if ($activity->photo_path) {
            Storage::disk('public')->delete($activity->photo_path);
        }
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Aktiviti telah dipadam.');
    }

    public function attendance(Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        $students = Student::where('school_id', $activity->school_id)
            ->with('kafaClass')
            ->orderBy('name')
            ->get()
            ->groupBy(fn($s) => optional($s->kafaClass)->name ?? 'Tiada Kelas');

        $attendedStudentIds = $activity->students()->pluck('students.id')->toArray();

        return view('activities.attendance', compact('activity', 'students', 'attendedStudentIds'));
    }

    public function saveAttendance(Request $request, Activity $activity)
    {
        $this->authorizeSchool($activity->school_id);

        // Only students of the activity's school may be attached.
        $studentIds = Student::where('school_id', $activity->school_id)
            ->whereIn('id', (array) $request->input('student_ids', []))
            ->pluck('id');

        $activity->students()->sync($studentIds);
        return redirect()->route('activities.index')->with('success', 'Kehadiran aktiviti berjaya dikemaskini.');
    }
}
