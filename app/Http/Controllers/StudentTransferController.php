<?php

namespace App\Http\Controllers;

use App\Models\StudentTransfer;
use App\Models\Student;
use App\Models\KafaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * "Pindah keluar": a student leaving the school is archived (status Pindah) in the
 * origin tenant. Student data is never moved into another tenant's workspace —
 * the receiving school registers the student in its own account.
 */
class StudentTransferController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = StudentTransfer::with(['student', 'fromSchool', 'approver']);

        if (!$user->isSuperAdmin()) {
            $query->where('from_school_id', $user->school_id);
        }

        $transfers = $query->latest()->paginate(10);
        return view('student_transfers.index', compact('transfers'));
    }

    public function getStudentsByClass($class_id)
    {
        $class = KafaClass::findOrFail($class_id);
        $this->authorizeSchool($class->school_id);

        $students = Student::where('kafa_class_id', $class->id)
            ->where('status', '!=', 'Pindah')
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
            $this->authorizeSchool($student->school_id);
        } else {
            $classes = KafaClass::query()
                ->when(!$user->isSuperAdmin(), fn($q) => $q->where('school_id', $user->school_id))
                ->orderBy('tahun')->orderBy('name')
                ->get();
        }

        return view('student_transfers.create', compact('student', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'to_school_name' => 'required|string|max:255',
            'reason'         => 'nullable|string',
        ], [
            'to_school_name.required' => 'Sila nyatakan nama sekolah destinasi.',
        ]);

        $student = Student::findOrFail($request->student_id);
        $this->authorizeSchool($student->school_id);

        DB::transaction(function () use ($request, $student) {
            StudentTransfer::create([
                'student_id'     => $student->id,
                'from_school_id' => $student->school_id,
                'to_school_name' => $request->to_school_name,
                'reason'         => $request->reason,
                'status'         => 'approved',
                'approved_by'    => auth()->id(),
            ]);

            $student->update([
                'status'        => 'Pindah',
                'kafa_class_id' => null,
            ]);
        });

        return redirect()->route('student_transfers.index')->with('success', 'Murid telah direkod sebagai pindah keluar.');
    }

    public function update(Request $request, StudentTransfer $studentTransfer)
    {
        abort(404);
    }

    public function destroy(StudentTransfer $studentTransfer)
    {
        $this->authorizeSchool($studentTransfer->from_school_id);

        // Batal rekod pindah: murid kembali aktif (tanpa kelas)
        DB::transaction(function () use ($studentTransfer) {
            $studentTransfer->student?->update(['status' => 'Aktif']);
            $studentTransfer->delete();
        });

        return redirect()->route('student_transfers.index')->with('success', 'Rekod pindah telah dibatalkan dan murid diaktifkan semula.');
    }
}
