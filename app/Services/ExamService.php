<?php

namespace App\Services;

class ExamService
{
    // A=80-100, B=60-79, C=40-59, D=0-39, TH=absent
    public function calculateGrade($marks)
    {
        if ($marks >= 80) return 'A';
        if ($marks >= 60) return 'B';
        if ($marks >= 40) return 'C';
        return 'D';
    }

    public function getGradeDescription($grade)
    {
        $descriptions = [
            'A'  => 'Cemerlang',
            'B'  => 'Baik',
            'C'  => 'Memuaskan',
            'D'  => 'Lemah',
            'TH' => 'Tidak Hadir',
        ];

        return $descriptions[$grade] ?? 'N/A';
    }

    // Format: "80/100 (A)" or "TH" when absent
    public function formatMark($marks, $isAbsent = false, $maxMarks = 100)
    {
        if ($isAbsent) return 'TH';
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
