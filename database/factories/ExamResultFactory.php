<?php

namespace Database\Factories;

use App\Models\ExamResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamResult>
 */
class ExamResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $marks = fake()->numberBetween(30, 100);
        $grade = $marks >= 80 ? 'A' : ($marks >= 60 ? 'B' : ($marks >= 40 ? 'C' : 'D'));
        
        return [
            'student_id' => \App\Models\Student::factory(),
            'exam_id' => \App\Models\Exam::factory(),
            'subject_id' => \App\Models\Subject::factory(),
            'marks' => $marks,
            'grade' => $grade,
        ];
    }
}
