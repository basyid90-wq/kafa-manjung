<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\KafaClass;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();
        
        // Data according to role
        $data = [];

        if ($user->hasRole('Super Admin')) {
            // ── Super Admin: System-level stats ──
            $data['stats'] = [
                'schools'      => \App\Models\School::count(),
                'active_users' => \App\Models\User::where('created_at', '>=', now()->subDays(90))->count(),
                'students'     => \App\Models\Student::count(),
                'new_users_30' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
            ];

            // Recent feedback (latest 5)
            $data['recent_feedback'] = Feedback::with('user')->latest()->take(5)->get();

            // Feedback counts by status
            $data['feedback_counts'] = [
                'baru'          => Feedback::where('status', 'baru')->count(),
                'dalam_semakan' => Feedback::where('status', 'dalam_semakan')->count(),
                'selesai'       => Feedback::where('status', 'selesai')->count(),
            ];

            // System health: last error from log
            $data['last_error_time'] = null;
            $logPath = storage_path('logs/laravel.log');
            if (file_exists($logPath)) {
                $lines = array_reverse(array_slice(file($logPath), -200));
                foreach ($lines as $line) {
                    if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(error|critical|emergency|alert):/i', $line, $m)) {
                        $data['last_error_time'] = $m[1];
                        break;
                    }
                }
            }

            // DB + storage health
            $data['db_ok']      = true;
            $data['storage_ok'] = is_writable(storage_path('app/public'));
            try { DB::connection()->getPdo(); } catch (\Exception $e) { $data['db_ok'] = false; }

        } elseif ($user->hasRole('Pentadbir')) {
            // ── Pentadbir ──
            $data['user_counts'] = [
                'Admin' => \App\Models\User::role(['Super Admin', 'Pentadbir'])->count(),
                'Penyelia' => \App\Models\User::role('Penyelia KAFA')->count(),
                'Guru Besar' => \App\Models\User::role('Guru Besar')->count(),
                'Pembekal' => \App\Models\User::role('Pembekal')->count(),
            ];

            $data['districts'] = \App\Models\District::withCount(['schools'])->get()->map(function($district) {
                $district->students_count = \App\Models\Student::whereHas('school', function($q) use ($district) {
                    $q->where('district_id', $district->id);
                })->count();
                return $district;
            });

        } elseif ($user->hasRole('Penyelia KAFA')) {
            // 2. Penyelia KAFA Logic (District Scope)
            $districtId = $user->district_id;
            $data['stats'] = [
                'schools' => \App\Models\School::where('district_id', $districtId)->count(),
                'guru_besar' => \App\Models\User::role('Guru Besar')->where('district_id', $districtId)->count(),
                'guru_kafa' => \App\Models\User::role('Guru KAFA')->where('district_id', $districtId)->count(),
                'classes' => \App\Models\KafaClass::whereHas('school', fn($q) => $q->where('district_id', $districtId))->count(),
                'students' => \App\Models\Student::whereHas('school', fn($q) => $q->where('district_id', $districtId))->count(),
            ];
            
            // Recent pending RPH in district
            $data['pending_rphs'] = \App\Models\RphRecord::whereHas('school', fn($q) => $q->where('district_id', $districtId))
                ->where('status', 'Pending')
                ->with(['user', 'kafaClass'])
                ->latest()
                ->take(5)
                ->get();

        } elseif ($user->hasRole('Guru Besar')) {
            // 3. Guru Besar Logic (School Scope)
            $schoolId = $user->school_id;
            $data['stats'] = [
                'guru_kafa' => \App\Models\User::role('Guru KAFA')->where('school_id', $schoolId)->count(),
                'classes' => \App\Models\KafaClass::where('school_id', $schoolId)->count(),
                'students' => \App\Models\Student::where('school_id', $schoolId)->count(),
            ];

            // 5 Latest Pending RPH for this school
            $data['pending_rphs'] = \App\Models\RphRecord::where('school_id', $schoolId)
                ->where('status', 'Pending')
                ->with(['user', 'kafaClass'])
                ->latest()
                ->take(5)
                ->get();

        } elseif ($user->hasRole('Guru KAFA')) {
            // 4. Guru KAFA Logic
            $data['stats'] = [
                'classes_taught' => \App\Models\KafaClass::where('teacher_id', $user->id)->count(),
                'students_supervised' => \App\Models\Student::whereHas('kafaClass', fn($q) => $q->where('teacher_id', $user->id))->count(),
                'announcements_count' => \App\Models\Announcement::where('is_global', true)
                    ->orWhere('school_id', $user->school_id)
                    ->latest()
                    ->count(),
            ];

            // Today's schedule
            $dayOfWeek = date('l'); // Current day
            $data['today_schedule'] = \App\Models\Timetable::where('user_id', $user->id)
                ->where('day_of_week', $dayOfWeek)
                ->with(['kafaClass', 'subject', 'timeSlot'])
                ->get()
                ->sortBy(function($timetable) {
                    return $timetable->timeSlot->start_time;
                });
        }

        return view('dashboard.index', compact('data', 'role'));
    }
}
