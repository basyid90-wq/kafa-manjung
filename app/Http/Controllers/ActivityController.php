<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activities = Activity::with('school', 'district')
            ->when($user->hasRole('Super Admin'), fn($q) => $q)
            ->when($user->hasRole('Penyelia KAFA'), function ($q) use ($user) {
                $schoolIds = School::where('district_id', $user->district_id)->pluck('id');
                $q->where(function ($q) use ($user, $schoolIds) {
                    $q->whereIn('school_id', $schoolIds)
                      ->orWhere(function ($q) use ($user) {
                          $q->where('tahap', 'daerah')->where('district_id', $user->district_id);
                      })
                      ->orWhere('tahap', 'negeri');
                });
            })
            ->when(
                !$user->hasAnyRole(['Super Admin', 'Penyelia KAFA']),
                fn($q) => $q->where(function ($q) use ($user) {
                    $q->where('school_id', $user->school_id)
                      ->orWhereIn('tahap', ['daerah', 'negeri']);
                })
            )
            ->latest()
            ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            $tahapOptions = ['sekolah' => 'Peringkat Sekolah', 'daerah' => 'Peringkat Daerah', 'negeri' => 'Peringkat Negeri'];
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $tahapOptions = ['daerah' => 'Peringkat Daerah'];
        } else {
            $tahapOptions = ['sekolah' => 'Peringkat Sekolah'];
        }

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
        $data = $request->only(['name', 'date', 'description', 'tahap']);

        if ($data['tahap'] === 'sekolah') {
            $data['school_id']   = $user->school_id;
            $data['district_id'] = null;
        } elseif ($data['tahap'] === 'daerah') {
            $data['school_id']   = null;
            $data['district_id'] = $user->district_id;
        } else {
            $data['school_id']   = null;
            $data['district_id'] = null;
        }

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('activities', 'public');
        }

        Activity::create($data);

        return redirect()->route('activities.index')->with('success', 'Aktiviti berjaya didaftarkan.');
    }

    public function show(Activity $activity)
    {
        $attendedStudents = $activity->students()
            ->with(['kafaClass', 'school', 'certificates' => fn($q) => $q->where('activity_id', $activity->id)])
            ->orderBy('name')
            ->get();

        $user = Auth::user();
        $templates = \App\Models\CertificateTemplate::query()
            ->when($user->hasRole('Penyelia KAFA'), fn($q) => $q->where('district_id', $user->district_id))
            ->when(
                !$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA']),
                fn($q) => $q->where('school_id', $user->school_id)
            )
            ->orderBy('name')
            ->get();

        return view('activities.show', compact('activity', 'attendedStudents', 'templates'));
    }

    public function edit(Activity $activity)
    {
        $user = Auth::user();
        $this->authorizeEdit($activity, $user);

        if ($user->hasRole('Super Admin')) {
            $tahapOptions = ['sekolah' => 'Peringkat Sekolah', 'daerah' => 'Peringkat Daerah', 'negeri' => 'Peringkat Negeri'];
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $tahapOptions = ['daerah' => 'Peringkat Daerah'];
        } else {
            $tahapOptions = ['sekolah' => 'Peringkat Sekolah'];
        }

        return view('activities.edit', compact('activity', 'tahapOptions'));
    }

    public function update(Request $request, Activity $activity)
    {
        $user = Auth::user();
        $this->authorizeEdit($activity, $user);

        $request->validate([
            'name'        => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahap'       => 'required|in:sekolah,daerah,negeri',
        ]);

        $data = $request->only(['name', 'date', 'description', 'tahap']);

        if ($data['tahap'] === 'sekolah') {
            $data['school_id']   = $user->school_id;
            $data['district_id'] = null;
        } elseif ($data['tahap'] === 'daerah') {
            $data['school_id']   = null;
            $data['district_id'] = $user->district_id;
        } else {
            $data['school_id']   = null;
            $data['district_id'] = null;
        }

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
        $user = Auth::user();
        $this->authorizeEdit($activity, $user);

        if ($activity->photo_path) {
            Storage::disk('public')->delete($activity->photo_path);
        }
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Aktiviti telah dipadam.');
    }

    public function attendance(Activity $activity)
    {
        if ($activity->tahap === 'sekolah') {
            $students = Student::where('school_id', $activity->school_id)
                ->with('kafaClass')
                ->orderBy('name')
                ->get()
                ->groupBy(fn($s) => optional($s->kafaClass)->name ?? 'Tiada Kelas');

        } elseif ($activity->tahap === 'daerah') {
            $schoolIds = School::where('district_id', $activity->district_id)->pluck('id');
            $students = Student::whereIn('school_id', $schoolIds)
                ->with(['kafaClass', 'school'])
                ->orderBy('name')
                ->get()
                ->groupBy(fn($s) => optional($s->school)->name ?? 'Tiada Sekolah');

        } else {
            // negeri — semua pelajar, groupkan ikut sekolah
            $students = Student::with(['kafaClass', 'school'])
                ->orderBy('name')
                ->get()
                ->groupBy(fn($s) => optional($s->school)->name ?? 'Tiada Sekolah');
        }

        $attendedStudentIds = $activity->students()->pluck('students.id')->toArray();

        return view('activities.attendance', compact('activity', 'students', 'attendedStudentIds'));
    }

    public function saveAttendance(Request $request, Activity $activity)
    {
        $activity->students()->sync($request->student_ids ?? []);
        return redirect()->route('activities.index')->with('success', 'Kehadiran aktiviti berjaya dikemaskini.');
    }

    /**
     * Guard: hanya pemilik tahap boleh edit/padam.
     */
    private function authorizeEdit(Activity $activity, $user): void
    {
        if ($user->hasRole('Super Admin')) return;

        if ($user->hasRole('Penyelia KAFA')) {
            abort_if(
                $activity->tahap !== 'daerah' || (int)$activity->district_id !== (int)$user->district_id,
                403,
                'Anda tidak mempunyai kebenaran untuk mengubah aktiviti ini.'
            );
            return;
        }

        // Guru Besar / Guru KAFA
        abort_if(
            $activity->tahap !== 'sekolah' || (int)$activity->school_id !== (int)$user->school_id,
            403,
            'Anda tidak mempunyai kebenaran untuk mengubah aktiviti ini.'
        );
    }
}
