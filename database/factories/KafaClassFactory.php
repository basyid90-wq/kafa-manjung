<?php

namespace Database\Factories;

use App\Models\KafaClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KafaClass>
 */
class KafaClassFactory extends Factory
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
            'name' => 'Tahun ' . fake()->numberBetween(1, 6) . ' ' . fake()->word(),
            'teacher_id' => \App\Models\User::factory(),
        ];
    }
}
