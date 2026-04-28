<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Models\School;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportController extends Controller
{
    public function import(Request $request)
    {
        $user = auth()->user();

        // ── Validation ──────────────────────────────────────────────────
        // Use 'file' instead of 'mimes:' because finfo can misidentify old .xls files.
        // Extension check is sufficient for trusted internal users.
        $request->validate([
            'file'      => 'required|file|max:10240',
            'school_id' => 'nullable|exists:schools,id',
        ], [
            'file.required' => 'Sila pilih fail Excel untuk diimport.',
            'file.max'      => 'Saiz fail melebihi had 10MB.',
        ]);

        $ext = strtolower($request->file('file')->getClientOriginalExtension());
        if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
            return back()->with('error', 'Format fail tidak disokong. Sila gunakan .xls, .xlsx atau .csv.');
        }

        // ── Resolve school_id ────────────────────────────────────────────
        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $schoolId = (int) $request->school_id;
            if (!$schoolId) {
                return back()->with('error', 'Sila pilih sekolah sebelum import.');
            }
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schoolId = (int) $request->school_id;
            if (!$schoolId) {
                return back()->with('error', 'Sila pilih sekolah sebelum import.');
            }
            // Ensure school belongs to supervisor's district
            $ok = School::where('id', $schoolId)->where('district_id', $user->district_id)->exists();
            if (!$ok) abort(403);
        } else {
            $schoolId = (int) $user->school_id;
            if (!$schoolId) {
                return back()->with('error', 'Akaun anda belum dikaitkan dengan mana-mana sekolah.');
            }
        }

        // ── Run import ───────────────────────────────────────────────────
        try {
            $import = new StudentsImport($schoolId);
            Excel::import($import, $request->file('file'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membaca fail Excel: ' . $e->getMessage());
        }

        if ($import->totalRows === 0) {
            return back()->with('error',
                'Tiada rekod ditemui dalam fail. Pastikan fail menggunakan format SIMPENI yang betul (lajur: Nama Pelajar, Kp Baru, Kelas, dll.).'
            );
        }

        session()->put('import_results', [
            'total'        => $import->totalRows,
            'success'      => $import->successCount,
            'failed_class' => $import->noClassCount,
            'details'      => $import->results,
        ]);

        return redirect()->route('students.import_summary');
    }

    public function summary()
    {
        $summary = session()->pull('import_results');

        if (!$summary) {
            return redirect()->route('students.index')->with('error', 'Tiada data import ditemui.');
        }

        return view('students.import_summary', compact('summary'));
    }
}
