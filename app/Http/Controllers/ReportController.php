<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\KafaClass;
use App\Models\RphRecord;
use App\Models\Student;
use App\Models\StudentTransfer;
use App\Models\User;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function __construct(private ExamService $examService) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->get('search');

        $query = Student::with(['kafaClass', 'school']);

        if (!$user->isSuperAdmin()) {
            $query->where('school_id', $user->school_id);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mykid', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(10);
        return view('reports.index', compact('students'));
    }

    public function show(Student $student)
    {
        $this->authorizeSchool($student->school_id);
        $student->load(['kafaClass', 'school', 'examResults.subject', 'examResults.exam', 'disciplinaryRecords', 'activities']);

        $totalDays = $student->attendances()->count();
        $presentDays = $student->attendances()->whereIn('status', ['Hadir', 'Lewat'])->count();
        $percentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

        $data = [
            'attendance' => [
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'percentage' => $percentage,
            ],
            'disciplinary_records' => $student->disciplinaryRecords,
            'activities' => $student->activities,
            'exam_results' => $student->examResults,
        ];

        return view('reports.show', compact('student', 'data'));
    }

    /**
     * School-level reports cover one school: the user's own school, or for
     * Super Admin the school picked in the filter (null until one is picked).
     *
     * @return array{0: ?School, 1: \Illuminate\Support\Collection}
     */
    private function reportSchool(Request $request): array
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $schools = School::orderBy('name')->get(['id', 'name']);
            $school  = $request->filled('school_id') ? School::find($request->integer('school_id')) : null;
            return [$school, $schools];
        }

        $this->authorizeSchool($user->school_id);
        return [School::findOrFail($user->school_id), collect()];
    }

    public function attendance(Request $request)
    {
        $month = min(12, max(1, (int) $request->get('month', date('n'))));
        $year  = (int) $request->get('year', date('Y'));

        [$school, $schools] = $this->reportSchool($request);

        $classRows   = collect();
        $monthly     = collect();
        $lowStudents = collect();
        $summary     = null;

        if ($school) {
            $present   = ['Hadir', 'Lewat'];
            $monthBase = fn () => Attendance::where('school_id', $school->id)
                ->whereYear('date', $year)->whereMonth('date', $month);

            // Status counts and recorded days per class for the month
            $statusCounts = $monthBase()
                ->selectRaw('kafa_class_id, status, COUNT(*) as total')
                ->groupBy('kafa_class_id', 'status')
                ->get();
            $countsByClass = $statusCounts->groupBy('kafa_class_id');
            $daysByClass   = $monthBase()
                ->selectRaw('kafa_class_id, COUNT(DISTINCT date) as days')
                ->groupBy('kafa_class_id')
                ->pluck('days', 'kafa_class_id');

            $classes = KafaClass::where('school_id', $school->id)
                ->with('teacher:id,name')
                ->withCount(['students as active_students' => fn ($q) => $q->where('status', 'Aktif')])
                ->orderBy('tahun')->orderBy('name')
                ->get();

            $classRows = $classes->map(function ($class) use ($countsByClass, $daysByClass, $present) {
                $counts = ($countsByClass[$class->id] ?? collect())->pluck('total', 'status');
                $total  = (int) $counts->sum();
                $hadir  = (int) $counts->only($present)->sum();

                return [
                    'name'        => $class->display_name,
                    'teacher'     => $class->teacher->name ?? null,
                    'students'    => $class->active_students,
                    'days'        => (int) ($daysByClass[$class->id] ?? 0),
                    'hadir'       => (int) ($counts['Hadir'] ?? 0),
                    'lewat'       => (int) ($counts['Lewat'] ?? 0),
                    'tidak_hadir' => (int) ($counts['Tidak Hadir'] ?? 0),
                    'cuti_sakit'  => (int) ($counts['Cuti Sakit'] ?? 0),
                    'total'       => $total,
                    'peratus'     => $total > 0 ? round($hadir / $total * 100, 1) : null,
                ];
            });

            $monthTotal   = (int) $statusCounts->sum('total');
            $monthPresent = (int) $statusCounts->whereIn('status', $present)->sum('total');

            // Students below 70% attendance this month (lowest first)
            $perStudent = $monthBase()
                ->selectRaw("student_id, COUNT(*) as total, SUM(CASE WHEN status IN ('Hadir', 'Lewat') THEN 1 ELSE 0 END) as hadir")
                ->groupBy('student_id')
                ->get()
                ->map(fn ($r) => $r->setAttribute('peratus', $r->total > 0 ? round($r->hadir / $r->total * 100, 1) : 0))
                ->filter(fn ($r) => $r->peratus < 70)
                ->sortBy('peratus');
            $studentNames = Student::whereIn('id', $perStudent->take(10)->pluck('student_id'))
                ->with('kafaClass:id,name,tahun')->get()->keyBy('id');
            $lowStudents = $perStudent->take(10)->map(fn ($r) => [
                'name'    => $studentNames->get($r->student_id)?->name ?? '—',
                'class'   => $studentNames->get($r->student_id)?->kafaClass?->display_name,
                'hadir'   => (int) $r->hadir,
                'total'   => (int) $r->total,
                'peratus' => $r->peratus,
            ])->values();

            // Monthly trend for the whole year
            $byDate = Attendance::where('school_id', $school->id)
                ->whereYear('date', $year)
                ->selectRaw('date, status, COUNT(*) as total')
                ->groupBy('date', 'status')
                ->get();
            $monthly = collect(range(1, 12))->mapWithKeys(function ($m) use ($byDate, $present) {
                $rows  = $byDate->filter(fn ($r) => Carbon::parse($r->date)->month === $m);
                $total = (int) $rows->sum('total');
                $hadir = (int) $rows->whereIn('status', $present)->sum('total');
                return [$m => [
                    'days'    => $rows->pluck('date')->unique()->count(),
                    'peratus' => $total > 0 ? round($hadir / $total * 100, 1) : null,
                ]];
            });

            $transfers = fn ($column) => StudentTransfer::where($column, $school->id)
                ->where('status', 'Diluluskan')
                ->whereYear('updated_at', $year)->whereMonth('updated_at', $month)
                ->count();

            $summary = [
                'students'     => Student::where('school_id', $school->id)->where('status', 'Aktif')->count(),
                'peratus'      => $monthTotal > 0 ? round($monthPresent / $monthTotal * 100, 1) : null,
                'days'         => $monthBase()->distinct()->count('date'),
                'low_students' => $perStudent->count(),
                'masuk'        => $transfers('to_school_id'),
                'keluar'       => $transfers('from_school_id'),
            ];
        }

        return view('reports.attendance', compact(
            'school', 'schools', 'month', 'year', 'classRows', 'monthly', 'lowStudents', 'summary'
        ));
    }

    public function exams(Request $request)
    {
        [$school, $schools] = $this->reportSchool($request);

        $exams = $school
            ? Exam::where('school_id', $school->id)->orderByDesc('year')->orderBy('name')->get()
            : collect();
        $exam  = $request->filled('exam_id') ? $exams->firstWhere('id', $request->integer('exam_id')) : null;

        $overall = $bySubject = $byClass = null;

        if ($exam) {
            $results = ExamResult::where('exam_id', $exam->id)
                ->whereHas('student', fn ($q) => $q->where('school_id', $school->id))
                ->with(['subject', 'student.kafaClass'])
                ->get();

            $overall = $this->examStats($results);

            $bySubject = $results->groupBy('subject_id')
                ->map(fn ($rows) => ['name' => $rows->first()->subject->name ?? '—'] + $this->examStats($rows))
                ->sortBy('name')->values();

            $byClass = $results->groupBy(fn ($r) => $r->student->kafa_class_id ?? 0)
                ->map(function ($rows) {
                    $class = $rows->first()->student->kafaClass;
                    return [
                        'name'  => $class?->display_name ?? 'Tiada Kelas',
                        'tahun' => $class->tahun ?? 99,
                    ] + $this->examStats($rows);
                })
                ->sortBy([['tahun', 'asc'], ['name', 'asc']])->values();
        }

        $gradeScale = $this->examService->gradeScale();

        return view('reports.exams', compact(
            'school', 'schools', 'exams', 'exam', 'overall', 'bySubject', 'byClass', 'gradeScale'
        ));
    }

    /** Old per-school detail URL: the exam report now covers one school, so send it there. */
    public function examsSchoolDetail(Request $request, School $school)
    {
        $this->authorizeSchool($school->id);

        return redirect()->route('reports.exams', array_filter([
            'school_id' => auth()->user()->isSuperAdmin() ? $school->id : null,
            'exam_id'   => $request->get('exam_id'),
        ]));
    }

    /**
     * Pass rate, average mark and grade distribution for a set of results.
     * A candidate passes only when every subject they sat has a passing grade.
     */
    private function examStats($results): array
    {
        $byStudent  = $results->groupBy('student_id');
        $candidates = $byStudent->count();
        $pass       = $byStudent->filter(fn ($rows) => $this->examService->isCandidatePass($rows))->count();
        $sat        = $results->where('is_absent', false)->whereNotNull('marks');

        $gradeCounts = [];
        foreach ($this->examService->grades() as $g) {
            $gradeCounts[$g] = $results->where('grade', $g)->count();
        }

        return [
            'candidates' => $candidates,
            'pass'       => $pass,
            'pass_pct'   => $candidates > 0 ? round($pass / $candidates * 100, 1) : 0,
            'avg'        => $sat->isNotEmpty() ? round($sat->avg('marks'), 1) : null,
            'absent'     => $results->where('is_absent', true)->count(),
            'grades'     => $gradeCounts,
        ];
    }

    public function rphKpi(Request $request)
    {
        $jenis      = $request->get('jenis_laporan') === 'Mingguan' ? 'Mingguan' : 'Bulanan';
        $bulan      = min(12, max(1, (int) $request->get('bulan', date('n'))));
        $tahun      = (int) $request->get('tahun', date('Y'));
        $minggu     = min(53, max(1, (int) $request->get('minggu', date('W'))));
        $jumlahHari = max(1, (int) $request->get('jumlah_hari_persekolahan', $jenis === 'Mingguan' ? 5 : 20));

        [$school, $schools] = $this->reportSchool($request);

        $periodStart = $jenis === 'Mingguan'
            ? Carbon::now()->setISODate($tahun, $minggu)->startOfWeek()
            : Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $periodEnd   = $jenis === 'Mingguan' ? $periodStart->copy()->endOfWeek() : $periodStart->copy()->endOfMonth();

        $teacherRows = collect();
        $summary     = null;

        if ($school) {
            $rph = RphRecord::where('school_id', $school->id)
                ->whereBetween('date', [$periodStart->toDateString(), $periodEnd->toDateString()])
                ->selectRaw('user_id, status, COUNT(*) as total')
                ->groupBy('user_id', 'status')
                ->get()
                ->groupBy('user_id');

            // Guru KAFA of the school, plus anyone else who submitted RPH in the period
            $teachers = User::where('school_id', $school->id)
                ->where(fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'Guru KAFA'))
                    ->orWhereIn('id', $rph->keys()))
                ->orderBy('name')
                ->get(['id', 'name']);

            $classesByTeacher = KafaClass::where('school_id', $school->id)
                ->whereIn('teacher_id', $teachers->pluck('id'))
                ->orderBy('tahun')->orderBy('name')
                ->get()
                ->groupBy('teacher_id');

            $teacherRows = $teachers->map(function ($teacher) use ($rph, $jumlahHari, $classesByTeacher) {
                $counts = ($rph[$teacher->id] ?? collect())->pluck('total', 'status');
                $hantar = (int) $counts->sum();
                return [
                    'name'     => $teacher->name,
                    'classes'  => ($classesByTeacher[$teacher->id] ?? collect())->map->display_name->implode(', '),
                    'target'   => $jumlahHari,
                    'hantar'   => $hantar,
                    'approved' => (int) ($counts['approved'] ?? 0),
                    'pending'  => (int) ($counts['pending'] ?? 0),
                    'revise'   => (int) (($counts['rejected'] ?? 0) + ($counts['revision_needed'] ?? 0)),
                    'peratus'  => round(min($hantar, $jumlahHari) / $jumlahHari * 100, 1),
                ];
            })->values();

            $target  = $teacherRows->sum('target');
            $summary = [
                'teachers' => $teacherRows->count(),
                'target'   => $target,
                'hantar'   => $teacherRows->sum('hantar'),
                'approved' => $teacherRows->sum('approved'),
                'peratus'  => $target > 0 ? round($teacherRows->sum(fn ($t) => min($t['hantar'], $t['target'])) / $target * 100, 1) : 0,
                'achieved' => $teacherRows->where('peratus', '>=', 85)->count(),
            ];
        }

        return view('reports.rph_kpi', compact(
            'school', 'schools', 'jenis', 'bulan', 'tahun', 'minggu', 'jumlahHari',
            'teacherRows', 'summary', 'periodStart', 'periodEnd'
        ));
    }

    public function bulkExport() { /* Placeholder for existing logic */ }
    public function exportPdf(Student $student) { /* Placeholder for existing logic */ }
    public function exportExcel(Student $student) { /* Placeholder for existing logic */ }
}
