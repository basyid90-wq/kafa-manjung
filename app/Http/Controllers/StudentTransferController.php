<?php

namespace App\Http\Controllers;

use App\Models\StudentTransfer;
use App\Models\Student;
use App\Models\School;
use App\Models\KafaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentTransferController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = StudentTransfer::with(['student', 'fromSchool', 'toSchool', 'approver']);

        if ($user->hasRole('Guru Besar')) {
            $query->where('from_school_id', $user->school_id);
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('fromSchool', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        }
        // Super Admin sees all

        $transfers = $query->latest()->paginate(10);
        return view('student_transfers.index', compact('transfers'));
    }

    public function getStudentsByClass($class_id)
    {
        // Ambil murid berdasarkan kelas. Kita tidak tapis school_id di sini 
        // kerana class_id itu sendiri sudah unik kepada sekolah tersebut.
        $students = Student::where('kafa_class_id', $class_id)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($students);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $student = null;
        $classes = collect();

        if ($request->student_id) {
            $student = Student::with('school')->findOrFail($request->student_id);
        } else {
            // Jika Super Admin/Pentadbir, boleh nampak semua kelas. 
            // Jika Guru Besar, hanya sekolah dia.
            $query = KafaClass::query();
            if ($user->hasRole('Guru Besar')) {
                $query->where('school_id', $user->school_id);
            }
            $classes = $query->get();
        }

        // Bypass isolation for destination schools
        $groupedSchools = School::with('district')
            ->where('id', '!=', $user->school_id)
            ->get()
            ->groupBy(function ($school) {
                return $school->district->name ?? 'Lain-lain';
            });

        return view('student_transfers.create', compact('student', 'classes', 'groupedSchools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'to_school_id' => 'required|exists:schools,id',
            'reason' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        StudentTransfer::create([
            'student_id' => $request->student_id,
            'from_school_id' => $student->school_id,
            'to_school_id' => $request->to_school_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('student_transfers.index')->with('success', 'Permohonan pindah murid telah dihantar.');
    }

    public function update(Request $request, StudentTransfer $studentTransfer)
    {
        $user = auth()->user();
        
        // Security check for Penyelia KAFA
        if ($user->hasRole('Penyelia KAFA')) {
            if ($studentTransfer->fromSchool->district_id !== $user->district_id) {
                abort(403);
            }
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        DB::transaction(function () use ($request, $studentTransfer, $user) {
            $studentTransfer->update([
                'status' => $request->status,
                'approved_by' => $user->id,
            ]);

            if ($request->status === 'approved') {
                $student = $studentTransfer->student;
                $student->update([
                    'school_id' => $studentTransfer->to_school_id,
                    'kafa_class_id' => null, // Reset class on transfer
                ]);
            }
        });

        return redirect()->route('student_transfers.index')->with('success', 'Status permohonan pindah telah dikemaskini.');
    }

    public function destroy(StudentTransfer $studentTransfer)
    {
        $user = auth()->user();
        
        if ($studentTransfer->status !== 'pending') {
            return back()->with('error', 'Hanya permohonan yang masih pending boleh dibatalkan.');
        }

        // Only from the school that requested it
        if ($user->hasRole('Guru Besar') && $studentTransfer->from_school_id !== $user->school_id) {
            abort(403);
        }

        $studentTransfer->delete();
        return redirect()->route('student_transfers.index')->with('success', 'Permohonan pindah telah dibatalkan.');
    }
}
