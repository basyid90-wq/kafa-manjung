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

        if ($role === 'Super Admin') {
            // ── Super Admin: System-level stats ──
            $data['stats'] = [
                'schools'      => \App\Models\School::count(),
                'total_users'  => \App\Models\User::count(),
                'students'     => \App\Models\Student::count(),
                'new_users_yr' => \App\Models\User::whereYear('created_at', now()->year)->count(),
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

        } elseif ($role === 'Guru Besar') {
            // Guru Besar (School Scope)
            $schoolId = $user->school_id;
            $data['stats'] = [
                'guru_kafa' => \App\Models\User::role('Guru KAFA')->where('school_id', $schoolId)->count(),
                'classes' => \App\Models\KafaClass::where('school_id', $schoolId)->count(),
                'students' => \App\Models\Student::where('school_id', $schoolId)->count(),
            ];

            // Onboarding checklist for new workspaces (hidden once every step is done)
            $school = $user->school;
            $steps = [
                ['label' => 'Lengkapkan profil sekolah', 'done' => (bool) ($school?->alamat || $school?->logo || $school?->no_telefon), 'url' => $school ? route('schools.edit', $school) : '#'],
                ['label' => 'Tambah kelas pertama',      'done' => $data['stats']['classes'] > 0,  'url' => route('kafa_classes.create')],
                ['label' => 'Daftar murid',              'done' => $data['stats']['students'] > 0, 'url' => route('students.create')],
                ['label' => 'Tetapkan slot masa',        'done' => \App\Models\TimeSlot::where('school_id', $schoolId)->exists(), 'url' => route('time_slots.index')],
            ];
            if ($school && !$school->isPersonal()) {
                $steps[] = [
                    'label' => 'Jemput guru KAFA',
                    'done'  => $data['stats']['guru_kafa'] > 0 || \App\Models\Invitation::where('school_id', $schoolId)->exists(),
                    'url'   => $user->canUse('pengguna') ? route('users.index') : route('subscription.index', ['modul' => 'pengguna']),
                    'plan'  => $user->canUse('pengguna') ? null : 'Pakej Sekolah',
                ];
            }
            $data['onboarding'] = collect($steps)->every('done') ? null : $steps;

            // 5 Latest Pending RPH for this school
            $data['pending_rphs'] = \App\Models\RphRecord::where('school_id', $schoolId)
                ->where('status', 'pending')
                ->with(['user', 'kafaClass'])
                ->latest()
                ->take(5)
                ->get();
            $data['stats']['pending_rph'] = \App\Models\RphRecord::where('school_id', $schoolId)->where('status', 'pending')->count();

            $data += $this->schoolInsights($user, $schoolId);

        } elseif ($role === 'Guru KAFA') {
            // Guru KAFA
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

            $classIds = \App\Models\KafaClass::where('teacher_id', $user->id)->pluck('id')->all();
            $data += $this->schoolInsights($user, $user->school_id, $classIds);
        }

        return view('dashboard.index-fb', compact('data', 'role'));
    }

    /**
     * Attendance, marks and announcement summaries for one school (optionally limited to some classes).
     * Uses DB::table, so every query is scoped to $schoolId by hand.
     */
    private function schoolInsights(\App\Models\User $user, ?int $schoolId, ?array $classIds = null): array
    {
        if (!$schoolId) {
            return [];
        }

        $att = fn () => DB::table('attendances')->where('school_id', $schoolId)
            ->when($classIds !== null, fn ($q) => $q->whereIn('kafa_class_id', $classIds));

        // Today's attendance
        $today = $att()->whereDate('date', today())
            ->selectRaw("SUM(status = 'Hadir') h, SUM(status = 'Lewat') l, SUM(status = 'Tidak Hadir') t, COUNT(*) n")
            ->first();
        $todayN = (int) ($today->n ?? 0);

        // Last 7 school days (Mon–Fri), oldest first
        $days = collect();
        for ($d = today(); $days->count() < 7; $d = $d->copy()->subDay()) {
            if (!$d->isWeekend()) $days->prepend($d->copy());
        }
        $byDate = $att()->whereBetween('date', [$days->first()->toDateString(), $days->last()->toDateString()])
            ->selectRaw("DATE(date) d, SUM(status IN ('Hadir','Lewat')) p, COUNT(*) n")
            ->groupBy('d')->get()->keyBy('d');
        $week7 = $days->map(function ($d) use ($byDate) {
            $row = $byDate->get($d->toDateString());
            return [
                'label'   => $d->locale('ms')->isoFormat('ddd'),
                'date'    => $d->format('d/m'),
                'pct'     => $row && $row->n ? (int) round($row->p / $row->n * 100) : null,
                'isToday' => $d->isToday(),
            ];
        })->values();
        $recorded = $week7->whereNotNull('pct');

        // Average marks per subject for the latest exam that has results
        $examQuery = DB::table('exams')->where('exams.school_id', $schoolId)
            ->whereExists(fn ($q) => $q->from('exam_results')->whereColumn('exam_results.exam_id', 'exams.id'));
        $exam = $examQuery->orderByDesc('year')->orderByDesc('id')->first();
        $subjectAvg = collect();
        if ($exam) {
            $subjectAvg = DB::table('exam_results')
                ->join('subjects', 'subjects.id', '=', 'exam_results.subject_id')
                ->join('students', 'students.id', '=', 'exam_results.student_id')
                ->where('exam_results.exam_id', $exam->id)
                ->where('students.school_id', $schoolId)
                ->when($classIds !== null, fn ($q) => $q->whereIn('students.kafa_class_id', $classIds))
                ->groupBy('subjects.id', 'subjects.name')
                ->orderBy('subjects.id')
                ->selectRaw('subjects.name, ROUND(AVG(exam_results.marks)) avg')
                ->get();
        }

        // Same targeting rule as the Hebahan page: only announcements addressed to this user
        $announcements = Announcement::forUser($user)
            ->where('is_homepage', false)
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->latest()->take(3)->get(['id', 'title', 'content', 'category', 'created_at']);

        $students = DB::table('students')->where('school_id', $schoolId)
            ->when($classIds !== null, fn ($q) => $q->whereIn('kafa_class_id', $classIds))
            ->selectRaw("SUM(gender = 'L') l, SUM(gender = 'P') p")->first();

        return [
            'today' => [
                'recorded' => $todayN,
                'present'  => (int) $today->h + (int) $today->l,
                'absent'   => (int) $today->t,
                'pct'      => $todayN ? (int) round(((int) $today->h + (int) $today->l) / $todayN * 100) : null,
            ],
            'week7'         => $week7,
            'week7_avg'     => $recorded->isNotEmpty() ? (int) round($recorded->avg('pct')) : null,
            'exam'          => $exam,
            'subject_avg'   => $subjectAvg,
            'announcements' => $announcements,
            'gender'        => ['l' => (int) ($students->l ?? 0), 'p' => (int) ($students->p ?? 0)],
        ];
    }
}
