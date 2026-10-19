<?php

namespace App\Services;

use Illuminate\Support\Collection;

/** Grade logic for KAFA exams. The scale itself lives in config/grading.php. */
class ExamService
{
    /** Scale from highest to lowest grade: [['grade','min','max','label'], ...] */
    public function gradeScale(): array
    {
        $scale = collect(config('grading.scale'))->sortByDesc('min')->values();
        $max   = (int) config('grading.max_marks', 100);

        return $scale->map(function ($row, $i) use ($scale, $max) {
            $upper = $i === 0 ? $max : $scale[$i - 1]['min'] - 1;
            return $row + ['max' => $upper];
        })->all();
    }

    /** Grade letters from highest to lowest, e.g. ['A', 'B', 'C', 'D']. */
    public function grades(): array
    {
        return array_column($this->gradeScale(), 'grade');
    }

    public function calculateGrade($marks): string
    {
        $scale = $this->gradeScale();
        foreach ($scale as $row) {
            if ($marks >= $row['min']) {
                return $row['grade'];
            }
        }

        return end($scale)['grade'];
    }

    public function getGradeDescription($grade): string
    {
        if ($grade === config('grading.absent_grade')) {
            return config('grading.absent_label');
        }

        foreach ($this->gradeScale() as $row) {
            if ($row['grade'] === $grade) {
                return $row['label'];
            }
        }

        return 'N/A';
    }

    /** Whether a subject grade counts as a pass (absent counts as fail). */
    public function isPass(?string $grade): bool
    {
        return $grade !== null && $grade !== '' && !in_array($grade, config('grading.fail_grades', []), true);
    }

    /** Whether a candidate passed: every subject result has a passing grade. */
    public function isCandidatePass(Collection $results): bool
    {
        return $results->isNotEmpty() && $results->every(fn ($r) => $this->isPass($r->grade));
    }

    /** ek-badge colour class for a grade. */
    public function badgeClass(?string $grade): string
    {
        if (!$this->isPass($grade)) {
            return 'ek-badge-red';
        }

        return match (array_search($grade, $this->grades(), true)) {
            0       => 'ek-badge-green',
            1       => 'ek-badge-blue',
            default => 'ek-badge-yellow',
        };
    }

    // Format: "80/100 (A)" or "TH" when absent
    public function formatMark($marks, $isAbsent = false, $maxMarks = 100)
    {
        if ($isAbsent) return config('grading.absent_grade');
        $grade = $this->calculateGrade($marks);
        return "{$marks}/{$maxMarks} ({$grade})";
    }

    /**
     * Calculate average marks for a set of results.
     */
    public function calculateAverage($results)
    {
        if ($results->isEmpty()) return 0;
        return round($results->avg('marks'), 2);
    }
}
