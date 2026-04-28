<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => \App\Models\District::factory(),
            'name' => 'SK ' . fake()->city(),
            'code' => 'ABC' . fake()->unique()->numberBetween(1000, 9999),
        ];
    }
}
