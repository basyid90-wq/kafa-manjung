<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\KafaClass;
use App\Models\Student;
use App\Models\StudentTransfer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = KafaClass::query();

        // FASA 5: Tapisan Keselamatan Global
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
            $query->where('school_id', $user->school_id);
            // Guru hanya nampak kelas sendiri
            if ($user->hasRole('Guru KAFA')) {
                $query->where('teacher_id', $user->id);
            }
        }

        $date = $request->date ?? date('Y-m-d');
        
        $classes = $query->with(['students' => function($q) use ($date) {
                // Eager load attendances for the selected date or today
                $q->with(['attendances' => function($q) use ($date) {
                    $q->where('date', $date);
                }]);
            }])
            ->get();
            
        $date = $request->date ?? date('Y-m-d');
        
        return view('attendances.index', compact('classes', 'date'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $date = $request->date ?? date('Y-m-d');
        
        $request->validate([
            'attendances'   => 'required|array',
            'attendances.*' => 'nullable|in:Hadir,Tidak Hadir,Lewat,Cuti Sakit',
        ]);

        foreach ($request->attendances as $student_id => $status) {
            if (empty($status)) continue; // Langkau jika guru belum pilih
            $student = \App\Models\Student::find($student_id);
            if (!$student) continue;
            
            // FASA 5: Tapisan Keselamatan
            if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Pembekal'])) {
                if ($student->school_id !== $user->school_id) continue;
                
                $class = KafaClass::find($student->kafa_class_id);
                if (!$class || $class->teacher_id !== $user->id) continue;
            }
            
            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'date' => $date,
                ],
                [
                    'school_id' => $student->school_id, // Guna ID sekolah murid
                    'kafa_class_id' => $student->kafa_class_id,
                    'status' => $status
                ]
            );
        }

        return redirect()->route('attendances.index', ['date' => $date])
            ->with('success', 'Kehadiran berjaya dikemaskini.');
    }

    public function printPdf(KafaClass $kafaClass, Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($kafaClass->school_id !== $user->school_id) abort(403);
        }

        $month     = (int) ($request->month     ?? date('n'));
        $year      = (int) ($request->year      ?? date('Y'));
        $totalDays = max(1, (int) ($request->total_days ?? 1));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac',      4 => 'April',
            5 => 'Mei',     6 => 'Jun',       7 => 'Julai',    8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
        ];
        $monthNamesJawi = [
            1  => 'جانواري',
            2  => 'فيبرواري',
            3  => 'مچ',
            4  => 'اڤريل',
            5  => 'مي',
            6  => 'جون',
            7  => 'جولاي',
            8  => 'اوڬوس',
            9  => 'سيڤتيمبر',
            10 => 'اوكتوبر',
            11 => 'نوۏيمبر',
            12 => 'ديسيمبر',
        ];

        $monthName     = ($monthNames[$month]     ?? '') . ' ' . $year;
        $monthNameJawi = ($monthNamesJawi[$month] ?? '') . ' ' . $year;

        $students = $kafaClass->students()->orderBy('name')->get();
        $school   = $kafaClass->school;

        // $records[student_id][day_int] = Attendance
        $records = Attendance::where('kafa_class_id', $kafaClass->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->groupBy('student_id')
            ->map(fn($recs) => $recs->keyBy(fn($r) => (int) Carbon::parse($r->date)->format('d')));

        // ── Rumusan Kehadiran ─────────────────────────────────────────────
        $bil_terkini = $students->count();

        $murid_masuk = StudentTransfer::where('to_school_id', $kafaClass->school_id)
            ->where('status', 'Diluluskan')
            ->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)
            ->count();

        $murid_keluar = StudentTransfer::where('from_school_id', $kafaClass->school_id)
            ->where('status', 'Diluluskan')
            ->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)
            ->count();

        $bil_bulan_lepas = max(0, $bil_terkini - $murid_masuk + $murid_keluar);

        $kedatangan_sebenar = Attendance::where('kafa_class_id', $kafaClass->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->whereIn('status', ['Hadir', 'Lewat'])
            ->count();

        $kedatangan_sepatutnya = $bil_terkini * $totalDays;
        $peratus = $kedatangan_sepatutnya > 0
            ? round(($kedatangan_sebenar / $kedatangan_sepatutnya) * 100, 2)
            : 0;
        $purata = $totalDays > 0
            ? round($kedatangan_sebenar / $totalDays, 1)
            : 0;

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4-L',
            'default_font'  => 'lateef',
            'autoArabic'    => true,
            'margin_top'    => 5,
            'margin_bottom' => 5,
            'margin_left'   => 5,
            'margin_right'  => 5,
            'tempDir'       => storage_path('app/mpdf_tmp'),
        ]);

        $html = view('attendances.pdf', compact(
            'kafaClass', 'school', 'students', 'records',
            'daysInMonth', 'month', 'year', 'monthName', 'monthNameJawi', 'totalDays',
            'bil_bulan_lepas', 'murid_masuk', 'murid_keluar', 'bil_terkini',
            'kedatangan_sebenar', 'kedatangan_sepatutnya', 'peratus', 'purata'
        ))->render();

        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');
        $filename   = 'Kehadiran-' . str_replace(' ', '_', $kafaClass->display_name) . '-' . str_replace(' ', '_', $monthName) . '.pdf';

        return response()->json([
            'data'     => base64_encode($pdfContent),
            'filename' => $filename,
        ]);
    }

    public function storeBulkLeave(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|in:Tidak Hadir,Cuti Sakit',
        ]);

        $user    = auth()->user();
        $student = Student::findOrFail($request->student_id);

        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($student->school_id !== $user->school_id) abort(403);
        }

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $count = 0;

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            if ($d->isWeekend()) continue;

            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'date' => $d->toDateString()],
                [
                    'school_id'     => $student->school_id,
                    'kafa_class_id' => $student->kafa_class_id,
                    'status'        => $request->status,
                ]
            );
            $count++;
        }

        return redirect()->route('attendances.index', ['date' => $request->start_date])
            ->with('success', "Cuti berjadual berjaya disimpan untuk {$student->name} ({$count} hari bekerja).");
    }

    public function kiosk()
    {
        return view('attendances.kiosk');
    }

    public function scan(Request $request)
    {
        $request->validate(['qr' => 'required|string']);

        $student = Student::with(['kafaClass', 'school'])->where('qr_code_string', $request->qr)->first();

        if (!$student) {
            return response()->json(['ok' => false, 'message' => 'Kod QR tidak dikenali.'], 404);
        }

        $school  = $student->school;
        $cutoff  = $school?->attendance_cutoff_time;
        $nowTime = now()->format('H:i:s');

        $status = 'Hadir';
        if ($cutoff && $nowTime > $cutoff) {
            $status = 'Lewat';
        }

        Attendance::updateOrCreate(
            ['student_id' => $student->id, 'date' => today()->toDateString()],
            [
                'school_id'     => $student->school_id,
                'kafa_class_id' => $student->kafa_class_id,
                'status'        => $status,
            ]
        );

        return response()->json([
            'ok'      => true,
            'name'    => $student->name,
            'class'   => $student->kafaClass?->name ?? '-',
            'status'  => $status,
            'masa'    => now()->format('H:i:s'),
            'photo'   => $student->photo
                ? asset('storage/' . $student->photo)
                : ($student->profile_picture ? asset('storage/' . $student->profile_picture) : null),
        ]);
    }
}
