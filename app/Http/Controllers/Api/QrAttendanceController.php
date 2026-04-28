<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class QrAttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'mykid' => 'required|string',
            // optionally pass a strict time parameter or determine server-side
        ]);

        $student = Student::where('mykid', $request->mykid)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Sila pastikan kod QR sah.'
            ], 404);
        }

        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        // Lewat condition: for example if past 15:00:00 (3 PM)
        $status = ($time > '15:00:00') ? 'Lewat' : 'Hadir';

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $student->id,
                'date' => $date,
            ],
            [
                'school_id' => $student->school_id,
                'kafa_class_id' => $student->kafa_class_id,
                'status' => $status
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Kehadiran direkodkan.',
            'data' => [
                'name' => $student->name,
                'status' => $status,
                'time' => $time
            ]
        ]);
    }
}
