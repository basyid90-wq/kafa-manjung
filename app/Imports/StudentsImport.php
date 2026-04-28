<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\KafaClass;
use Maatwebsite\Excel\Concerns\ToArray;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StudentsImport implements ToArray
{
    public int   $totalRows    = 0;
    public int   $successCount = 0;
    public int   $noClassCount = 0;
    public array $results      = [];

    private int $schoolId;

    public function __construct(int $schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
     * Keys that identify each SIMPENI column (search by partial match, case-insensitive).
     * First match wins.
     */
    private const COL_PATTERNS = [
        'mykid'        => ['kp baru', 'kp_baru', 'no kp', 'no. kp', 'no.kp', 'mykid', 'ic'],
        'name'         => ['nama pelajar', 'nama murid', 'nama_pelajar', 'nama'],
        'dob'          => ['tarikh lahir', 'tarikh_lahir', 'dob', 'date of birth', 't.lahir'],
        'birth_place'  => ['tempat lahir', 'tempat_lahir', 't. lahir', 'place of birth'],
        'gender'       => ['jantina', 'gender', 'sex'],
        'citizenship'  => ['warganegara', 'warga negara', 'citizenship'],
        'address'      => ['alamat rumah', 'alamat_rumah', 'alamat', 'address'],
        'phone'        => ['no tel', 'no. tel', 'no_tel', 'telefon', 'phone', 'tel'],
        'class'        => ['kelas', 'nama kelas', 'class'],
    ];

    public function array(array $rows): void
    {
        // ── 1. Find the header row (scan first 8 rows) ──────────────────
        $headerRowIdx = null;
        $colIndex     = [];   // ['mykid' => 2, 'name' => 3, ...]

        foreach (array_slice($rows, 0, 8) as $i => $row) {
            $normalized = array_map(fn($c) => strtolower(trim(preg_replace('/\s+/', ' ', (string) $c))), $row);

            // A header row must contain BOTH a name-like and an id-like column
            $hasName = $this->findColumnIndex($normalized, self::COL_PATTERNS['name']);
            $hasId   = $this->findColumnIndex($normalized, self::COL_PATTERNS['mykid']);

            if ($hasName !== null && $hasId !== null) {
                $headerRowIdx = $i;
                // Build column-index map for all fields
                foreach (self::COL_PATTERNS as $field => $patterns) {
                    $idx = $this->findColumnIndex($normalized, $patterns);
                    if ($idx !== null) {
                        $colIndex[$field] = $idx;
                    }
                }
                break;
            }
        }

        // Fallback: treat row 0 as header
        if ($headerRowIdx === null) {
            $headerRowIdx = 0;
            $normalized = array_map(fn($c) => strtolower(trim(preg_replace('/\s+/', ' ', (string) $c))), $rows[0] ?? []);
            foreach (self::COL_PATTERNS as $field => $patterns) {
                $idx = $this->findColumnIndex($normalized, $patterns);
                if ($idx !== null) $colIndex[$field] = $idx;
            }
        }

        // ── 2. Process data rows ─────────────────────────────────────────
        $dataRows = array_slice($rows, $headerRowIdx + 1);

        foreach ($dataRows as $row) {
            // Skip fully-empty rows
            if (empty(array_filter($row, fn($v) => $v !== null && $v !== ''))) continue;

            $raw = fn(string $field) => isset($colIndex[$field]) ? ($row[$colIndex[$field]] ?? null) : null;

            $mykidRaw = $raw('mykid');
            $nameRaw  = $raw('name');

            if (!$mykidRaw || !$nameRaw) continue;  // skip rows missing both key fields

            $this->totalRows++;

            $mykid = preg_replace('/[^0-9]/', '', (string) $mykidRaw);

            // ── Auto-map class ───────────────────────────────────────────
            $classRaw  = trim((string) ($raw('class') ?? ''));
            $kafaClass = $classRaw !== '' ? $this->resolveClass($classRaw) : null;

            // ── Upsert student ───────────────────────────────────────────
            $student = Student::updateOrCreate(
                ['mykid' => $mykid],
                [
                    'school_id'      => $this->schoolId,
                    'kafa_class_id'  => $kafaClass?->id,
                    'name'           => strtoupper(trim((string) $nameRaw)),
                    'dob'            => $this->parseDate($raw('dob')),
                    'birth_place'    => $raw('birth_place') ? strtoupper(trim((string) $raw('birth_place'))) : null,
                    'gender'         => $this->parseGender($raw('gender')),
                    'citizenship'    => $raw('citizenship') ? strtoupper(trim((string) $raw('citizenship'))) : 'WARGANEGARA',
                    'address'        => $raw('address') ? trim((string) $raw('address')) : null,
                    'father_phone'   => $raw('phone') ? trim((string) $raw('phone')) : null,
                    'status'         => 'Aktif',
                ]
            );

            // Generate QR if missing
            if (!$student->qr_code_string) {
                $student->update([
                    'qr_code_string' => 'KAFA-' . $student->school_id . '-' . $student->id . '-' . strtoupper(Str::random(8)),
                ]);
            }

            if ($kafaClass) {
                $this->successCount++;
            } else {
                $this->noClassCount++;
            }

            $this->results[] = [
                'name'  => $student->name,
                'mykid' => $student->mykid,
                'class' => $kafaClass?->display_name,
            ];
        }
    }

    // ── Helpers ──────────────────────────────────────────────────────────

    /**
     * Resolve SIMPENI class string → KafaClass model.
     *
     * Handles these SIMPENI formats (precedence order):
     *   D - "ABU BAKAR AS SIDDIQ 4" / "ABU BAKAR AS SIDDIQ 5 (UPKK)"  <- primary SIMPENI export format
     *   A - "Tahun 1 Abu Bakar"  (year at start)
     *   B - "1 Abu Bakar"        (digit at start)
     *   C - "Abu Bakar - Tahun 1 & 2"  (combined year, no tahun extracted)
     */
    private function resolveClass(string $classRaw): ?KafaClass
    {
        $raw = trim($classRaw);

        $tahun    = null;
        $baseName = $raw;

        // Pattern D (SIMPENI export): strip optional "(SUFFIX)" then trailing single digit
        // "ABU BAKAR AS SIDDIQ 4"       -> tahun=4, baseName="ABU BAKAR AS SIDDIQ"
        // "'OTHMAN AFFAN 5 (UPKK)"      -> tahun=5, baseName="'OTHMAN AFFAN"
        $stripped = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $raw));
        if (preg_match('/^(.+?)\s+(\d)\s*$/u', $stripped, $m)) {
            $tahun    = (int) $m[2];
            $baseName = trim($m[1]);
        }
        // Pattern A: "Tahun 1 Abu Bakar" / "TAHUN 2 SIDDIQ" (year at start)
        elseif (preg_match('/^tahun\s+(\d)\s+(.+)$/iu', $raw, $m)) {
            $tahun    = (int) $m[1];
            $baseName = trim($m[2]);
        }
        // Pattern B: "1 Abu Bakar" (digit at start)
        elseif (preg_match('/^(\d)\s+(.+)$/', $raw, $m)) {
            $tahun    = (int) $m[1];
            $baseName = trim($m[2]);
        }
        // Pattern C: "Abu Bakar - Tahun 1 & 2" (combined year at end after dash)
        elseif (preg_match('/^(.+?)\s*[-–]\s*tahun\s+\d.*/iu', $raw, $m)) {
            $baseName = trim($m[1]);
        }

        $q = KafaClass::where('school_id', $this->schoolId);

        // Primary: tahun + exact name match
        if ($tahun) {
            $found = (clone $q)->where('tahun', $tahun)
                ->whereRaw('UPPER(name) = ?', [strtoupper($baseName)])
                ->first();
            if ($found) return $found;

            // Secondary: tahun + partial name
            $found = (clone $q)->where('tahun', $tahun)
                ->where('name', 'LIKE', '%' . $baseName . '%')
                ->first();
            if ($found) return $found;
        }

        // Fallback 1: base name only (no tahun filter)
        $found = (clone $q)->where('name', 'LIKE', '%' . $baseName . '%')->first();
        if ($found) return $found;

        // Fallback 2: full raw string
        return (clone $q)->where('name', 'LIKE', '%' . $raw . '%')->first();
    }

    private function findColumnIndex(array $normalizedRow, array $patterns): ?int
    {
        foreach ($patterns as $pattern) {
            foreach ($normalizedRow as $idx => $cell) {
                if ($cell === $pattern || str_contains($cell, $pattern)) {
                    return $idx;
                }
            }
        }
        return null;
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || $value === '') return null;
        try {
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value))->format('Y-m-d');
            }
            return Carbon::parse((string) $value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function parseGender(mixed $value): ?string
    {
        if (!$value) return null;
        $v = strtoupper(trim((string) $value));
        if (str_contains($v, 'LELAKI') || $v === 'L') return 'L';
        if (str_contains($v, 'PEREMPUAN') || str_contains($v, 'WANITA') || $v === 'P') return 'P';
        return null;
    }
}
