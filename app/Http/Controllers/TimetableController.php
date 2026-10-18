<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\TimeSlot;
use App\Models\KafaClass;
use App\Models\Subject;
use App\Models\User;
use App\Events\TimetableUpdated;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $days = ['Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat'];
        
        // 1. Determine School
        $schoolId = null;
        $schools = [];
        if ($user->isSuperAdmin()) {
            $schools = \App\Models\School::orderBy('name')->get();
            $schoolId = $request->get('school_id', $schools->first()?->id);
        } else {
            $schoolId = $user->school_id;
        }

        // 2. Determine Classes (requested class must belong to the selected school)
        $classes = KafaClass::where('school_id', $schoolId)->get();
        $classId = $request->get('kafa_class_id', $classes->first()?->id);
        if ($classId && !$classes->contains('id', (int) $classId)) {
            $classId = $classes->first()?->id;
        }
        
        // 3. Get Slots
        $slots = TimeSlot::where('school_id', $schoolId)
            ->orderBy('start_time')
            ->get();
            
        // 4. Pivot Data
        $timetableData = [];
        if ($classId) {
            $records = Timetable::where('kafa_class_id', $classId)
                ->with(['subject', 'teacher', 'timeSlot'])
                ->get();
                
            foreach ($records as $record) {
                // Key format: [slot_id][day]
                $timetableData[$record->time_slot_id][$record->day_of_week] = $record;
            }
        }

        return view('timetable.index', compact('classes', 'slots', 'days', 'timetableData', 'classId', 'schools', 'schoolId'));
    }

    public function create()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        
        $classes = KafaClass::where('school_id', $schoolId)->get();
        $subjects = Subject::where(function($query) use ($schoolId) {
            $query->where('school_id', $schoolId)->orWhereNull('school_id');
        })->get();
        $teachers = User::where('school_id', $schoolId)->role(['Guru KAFA', 'Guru Besar'])->get();
        $slots = TimeSlot::where('school_id', $schoolId)->get();
        $days = ['Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat'];

        return view('timetable.create', compact('classes', 'subjects', 'teachers', 'slots', 'days'));
    }

    /** Class, subject, teacher and slot must all belong to one school the user may access. */
    private function validateEntry(Request $request): void
    {
        $request->validate([
            'kafa_class_id' => 'required|exists:kafa_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'day_of_week' => 'required|string|in:Isnin,Selasa,Rabu,Khamis,Jumaat',
        ]);

        $class = KafaClass::findOrFail($request->kafa_class_id);
        $this->authorizeSchool($class->school_id);

        $sameSchool = Subject::whereKey($request->subject_id)
                ->where(fn($q) => $q->where('school_id', $class->school_id)->orWhereNull('school_id'))->exists()
            && User::whereKey($request->user_id)->where('school_id', $class->school_id)->exists()
            && TimeSlot::whereKey($request->time_slot_id)->where('school_id', $class->school_id)->exists();

        abort_unless($sameSchool, 403);
    }

    public function store(Request $request)
    {
        $this->validateEntry($request);

        // Clash 1: Teacher Conflict (Guru sedang mengajar di kelas lain pada waktu yang sama)
        $teacherClash = Timetable::where('user_id', $request->user_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('time_slot_id', $request->time_slot_id)
            ->where('kafa_class_id', '!=', $request->kafa_class_id)
            ->first();

        if ($teacherClash) {
            return back()->with('error', "Maaf, guru ini sedang mengajar kelas ({$teacherClash->kafaClass->display_name}) pada waktu ini.");
        }

        // Clash 2 & Logic: updateOrCreate (Replace subject/teacher if already exists for this class/time)
        $timetable = Timetable::updateOrCreate(
            [
                'kafa_class_id' => $request->kafa_class_id,
                'time_slot_id' => $request->time_slot_id,
                'day_of_week' => $request->day_of_week,
            ],
            [
                'subject_id' => $request->subject_id,
                'user_id' => $request->user_id,
            ]
        );

        event(new TimetableUpdated($timetable));

        return redirect()->route('timetable.index', ['kafa_class_id' => $request->kafa_class_id])
            ->with('success', 'Jadual waktu berjaya dikemaskini.');
    }

    public function edit($id)
    {
        $timetable = Timetable::with(['kafaClass', 'subject', 'teacher', 'timeSlot'])->findOrFail($id);
        $this->authorizeSchool($timetable->kafaClass?->school_id);
        $schoolId = $timetable->kafaClass->school_id;

        $classes = KafaClass::where('school_id', $schoolId)->get();
        $subjects = Subject::where(function($query) use ($schoolId) {
            $query->where('school_id', $schoolId)->orWhereNull('school_id');
        })->get();
        $teachers = User::where('school_id', $schoolId)->role(['Guru KAFA', 'Guru Besar'])->get();
        $slots = TimeSlot::where('school_id', $schoolId)->get();
        $days = ['Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat'];

        return view('timetable.edit', compact('timetable', 'classes', 'subjects', 'teachers', 'slots', 'days'));
    }

    public function update(Request $request, $id)
    {
        $timetable = Timetable::findOrFail($id);
        $this->authorizeSchool($timetable->kafaClass?->school_id);

        $this->validateEntry($request);

        // Teacher Conflict Check (exclude current record)
        $teacherClash = Timetable::where('user_id', $request->user_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('time_slot_id', $request->time_slot_id)
            ->where('kafa_class_id', '!=', $request->kafa_class_id)
            ->where('id', '!=', $id)
            ->first();

        if ($teacherClash) {
            return back()->with('error', "Maaf, guru ini sedang mengajar kelas ({$teacherClash->kafaClass->display_name}) pada waktu ini.");
        }

        // Slot Conflict Check (exclude current record)
        $slotClash = Timetable::where('kafa_class_id', $request->kafa_class_id)
            ->where('time_slot_id', $request->time_slot_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('id', '!=', $id)
            ->first();

        if ($slotClash) {
            return back()->with('error', "Maaf, slot masa ini telah digunakan untuk kelas ini pada hari yang sama.");
        }

        $timetable->update([
            'kafa_class_id' => $request->kafa_class_id,
            'subject_id' => $request->subject_id,
            'user_id' => $request->user_id,
            'time_slot_id' => $request->time_slot_id,
            'day_of_week' => $request->day_of_week,
        ]);

        event(new TimetableUpdated($timetable));

        return redirect()->route('timetable.index', ['kafa_class_id' => $request->kafa_class_id])
            ->with('success', 'Jadual waktu berjaya dikemaskini.');
    }

    public function destroy($id)
    {
        $timetable = Timetable::findOrFail($id);
        $this->authorizeSchool($timetable->kafaClass?->school_id);
        $classId = $timetable->kafa_class_id;
        $timetable->delete();

        return redirect()->route('timetable.index', ['kafa_class_id' => $classId])
            ->with('success', 'Jadual waktu berjaya dipadam.');
    }

    public function printPdf($kafa_class_id)
    {
        $kafaClass = KafaClass::with('school')->findOrFail($kafa_class_id);
        $this->authorizeSchool($kafaClass->school_id);
        $school = $kafaClass->school;
        $slots = TimeSlot::where('school_id', $school->id)->orderBy('start_time')->get();
        $days = ['Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat'];
        
        $timetables = Timetable::with(['subject', 'teacher', 'timeSlot'])
            ->where('kafa_class_id', $kafa_class_id)
            ->get();

        $timetableData = [];
        foreach ($timetables as $t) {
            $timetableData[$t->time_slot_id][$t->day_of_week] = $t;
        }

        // Logo Logic
        $logoPath = public_path('template/kafa.png'); // Default fallback
        if ($school->logo && file_exists(storage_path('app/public/' . $school->logo))) {
            $logoPath = storage_path('app/public/' . $school->logo);
        }

        $html = view('timetable.pdf', compact('kafaClass', 'school', 'slots', 'days', 'timetableData', 'logoPath'))->render();

        // mPDF Temp Directory
        $tempDir = storage_path('app/mpdf_temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new Mpdf([
            'tempDir' => $tempDir,
            'mode' => 'utf-8',
            'format' => 'A4',
            'autoArabic' => true,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'default_font' => 'lateef'
        ]);

        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');
        $filename = "Jadual_" . mb_strtoupper($kafaClass->display_name) . ".pdf";

        if (request()->ajax()) {
            return response()->json([
                'data' => base64_encode($pdfContent),
                'filename' => $filename
            ]);
        }
        
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
