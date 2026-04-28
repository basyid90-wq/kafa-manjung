<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Al-Quran', 'code' => 'AQ'],
            ['name' => 'Lughatul Quran', 'code' => 'LQ'],
            ['name' => 'Ibadat', 'code' => 'IB'],
            ['name' => 'Akidah', 'code' => 'AK'],
            ['name' => 'Sirah', 'code' => 'SI'],
            ['name' => 'Adab', 'code' => 'AD'],
            ['name' => 'Jawi dan Khat', 'code' => 'JK'],
        ];

        foreach ($subjects as $subject) {
            \App\Models\Subject::updateOrCreate(['code' => $subject['code']], $subject);
        }
    }
}
