<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = \App\Models\School::first();
        if (!$school) return;

        $slots = [
            ['start_time' => '14:30', 'end_time' => '15:00'],
            ['start_time' => '15:00', 'end_time' => '15:30'],
            ['start_time' => '15:30', 'end_time' => '16:00'],
            ['start_time' => '16:00', 'end_time' => '16:30'],
            ['start_time' => '16:30', 'end_time' => '17:00'],
            ['start_time' => '17:00', 'end_time' => '17:30'],
        ];

        foreach ($slots as $slot) {
            \App\Models\TimeSlot::updateOrCreate(
                ['school_id' => $school->id, 'start_time' => $slot['start_time']],
                ['end_time' => $slot['end_time']]
            );
        }
    }
}
