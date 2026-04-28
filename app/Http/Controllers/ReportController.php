<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\RphRecord;
use App\Models\Student;
use App\Models\StudentTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->get('search');
        
        $query = Student::with(['kafaClass', 'school']);
        
        if ($user->hasRole('Guru Besar')) {
            $query->where('school_id', $user->school_id);
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
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

    public function attendance(Request $request)
    {
        $user  = auth()->user();
        $month = (int) $request->get('month', date('n'));
        $year  = (int) $request->get('year',  date('Y'));

        $query = School::query();

        if ($user->hasRole('Penyelia KAFA')) {
            $query->where('district_id', $user->district_id);
        } elseif ($user->hasRole('Guru Besar')) {
            $query->where('id', $user->school_id);
        }

        $schools = $query->orderBy('name')->get();

        foreach ($schools as $school) {
            // Murid masuk ke sekolah ini bulan tersebut (transfer diluluskan)
            $murid_masuk = StudentTransfer::where('to_school_id', $school->id)
                ->where('status', 'Diluluskan')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)
                ->count();

            // Murid keluar dari sekolah ini bulan tersebut
            $murid_keluar = StudentTransfer::where('from_school_id', $school->id)
                ->where('status', 'Diluluskan')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)
                ->count();

            // Bilangan murid aktif semasa (terkini)
            $bil_terkini = Student::where('school_id', $school->id)
                ->where('status', 'Aktif')
                ->count();

            // Anggaran bilangan bulan lepas
            $bil_bulan_lepas = max(0, $bil_terkini - $murid_masuk + $murid_keluar);

            // Kehadiran sebenar (Hadir + Lewat)
            $kedatangan_sebenar = Attendance::where('school_id', $school->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereIn('status', ['Hadir', 'Lewat'])
                ->count();

            // Total rekod (Hadir + Lewat + Tidak Hadir) sebagai penyebut peratus
            $total_records = Attendance::where('school_id', $school->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->count();

            $peratus = $total_records > 0
                ? round(($kedatangan_sebenar / $total_records) * 100, 1)
                : 0;

            $school->bil_bulan_lepas    = $bil_bulan_lepas;
            $school->murid_masuk        = $murid_masuk;
            $school->murid_keluar       = $murid_keluar;
            $school->bil_terkini        = $bil_terkini;
            $school->kedatangan_sebenar = $kedatangan_sebenar;
            $school->peratus_kehadiran  = $peratus;
            $school->status_color       = $peratus >= 85 ? 'success' : ($peratus >= 70 ? 'warning' : 'danger');
            $school->status_label       = $peratus >= 85 ? 'Cemerlang' : ($peratus >= 70 ? 'Memuaskan' : 'Perlu Perhatian');
        }

        return view('reports.attendance', compact('schools', 'month', 'year'));
    }

    public function exams(Request $request)
    {
        $user = auth()->user();
        $examId = $request->get('exam_id');
        $exams = Exam::orderBy('year', 'desc')->get();
        $schools = collect();

        if ($examId) {
            $schoolQuery = School::query();
            if ($user->hasRole('Penyelia KAFA')) {
                $schoolQuery->where('district_id', $user->district_id);
            }
            $schools = $schoolQuery->get();

            foreach ($schools as $school) {
                $results = ExamResult::where('exam_id', $examId)
                    ->whereHas('student', function ($q) use ($school) {
                        $q->where('school_id', $school->id);
                    })->get();

                $totalCandidates = $results->unique('student_id')->count();
                
                if ($totalCandidates > 0) {
                    $totalPass = $results->groupBy('student_id')->filter(function ($studentResults) {
                        return !$studentResults->contains(function ($res) {
                            return in_array($res->grade, ['G', 'TH']);
                        });
                    })->count();

                    $school->pass_percentage = ($totalPass / $totalCandidates) * 100;

                    $gradePoints = [
                        'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'G' => 6,
                    ];

                    $totalPoints = 0;
                    $totalSubjectsCounted = 0;

                    foreach ($results as $res) {
                        if (isset($gradePoints[$res->grade])) {
                            $totalPoints += $gradePoints[$res->grade];
                            $totalSubjectsCounted++;
                        }
                    }

                    $school->gps = $totalSubjectsCounted > 0 ? $totalPoints / $totalSubjectsCounted : 0;
                    $school->total_candidates = $totalCandidates;
                } else {
                    $school->pass_percentage = 0;
                    $school->gps = 0;
                    $school->total_candidates = 0;
                }
            }
        }

        return view('reports.exams', compact('exams', 'schools', 'examId'));
    }

    public function rphKpi(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA'])) {
            abort(403);
        }

        $jenis               = $request->get('jenis_laporan', 'Bulanan');
        $bulan               = (int) $request->get('bulan', date('n'));
        $tahun               = (int) $request->get('tahun', date('Y'));
        $minggu              = (int) $request->get('minggu', date('W'));
        $jumlahHari          = max(1, (int) $request->get('jumlah_hari_persekolahan', 20));

        $schoolQuery = School::query()
            ->when($user->hasRole('Penyelia KAFA'), fn($q) => $q->where('district_id', $user->district_id))
            ->orderBy('name');

        $schools = $schoolQuery->get();

        foreach ($schools as $school) {
            // Senarai Guru KAFA dalam sekolah ini
            $guruList = User::where('school_id', $school->id)
                ->whereHas('roles', fn($q) => $q->where('name', 'Guru KAFA'))
                ->get(['id', 'name']);

            $guruIds  = $guruList->pluck('id');
            $bilGuru  = $guruList->count();
            $targetRph = $bilGuru * $jumlahHari;

            // RPH dihantar dalam tempoh
            $rphBase = RphRecord::where('school_id', $school->id)
                ->whereIn('user_id', $guruIds);

            if ($jenis === 'Mingguan') {
                $rphBase->whereYear('date', $tahun)
                        ->whereRaw('WEEK(date, 1) = ?', [$minggu]);
            } else {
                $rphBase->whereYear('date', $tahun)
                        ->whereMonth('date', $bulan);
            }

            $rphDihantar = (clone $rphBase)->count();
            $peratus     = $targetRph > 0 ? round(($rphDihantar / $targetRph) * 100, 1) : 0;

            // Pengiraan per-guru (1 query grouped)
            $rphPerGuru = (clone $rphBase)
                ->selectRaw('user_id, COUNT(*) as jumlah')
                ->groupBy('user_id')
                ->pluck('jumlah', 'user_id');

            $guruDetails = $guruList->map(function ($guru) use ($jumlahHari, $rphPerGuru) {
                $hantar  = (int) ($rphPerGuru[$guru->id] ?? 0);
                $pct     = $jumlahHari > 0 ? round(($hantar / $jumlahHari) * 100, 1) : 0;
                $badge   = $pct >= 85 ? 'success' : ($pct >= 50 ? 'warning' : 'danger');
                return [
                    'name'    => $guru->name,
                    'target'  => $jumlahHari,
                    'hantar'  => $hantar,
                    'peratus' => $pct,
                    'badge'   => $badge,
                ];
            })->sortBy('name')->values()->all();

            $school->bil_guru     = $bilGuru;
            $school->target_rph   = $targetRph;
            $school->rph_dihantar = $rphDihantar;
            $school->peratus_kpi  = $peratus;
            $school->badge_kpi    = $peratus >= 85 ? 'success' : ($peratus >= 50 ? 'warning' : 'danger');
            $school->guru_details = $guruDetails;
        }

        return view('reports.rph_kpi', compact(
            'schools', 'jenis', 'bulan', 'tahun', 'minggu', 'jumlahHari'
        ));
    }

    public function bulkExport() { /* Placeholder for existing logic */ }
    public function exportPdf(Student $student) { /* Placeholder for existing logic */ }
    public function exportExcel(Student $student) { /* Placeholder for existing logic */ }
}
