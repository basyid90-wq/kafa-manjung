<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => \App\Models\School::factory(),
            'kafa_class_id' => \App\Models\KafaClass::factory(),
            'student_id' => \App\Models\Student::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['Hadir', 'Tidak Hadir', 'Lewat']),
        ];
    }
}
