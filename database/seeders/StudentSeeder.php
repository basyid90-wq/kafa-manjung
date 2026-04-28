<?php

namespace Database\Seeders;

use App\Models\KafaClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulakan pembersihan data secara menyeluruh (Force Truncate)...');
        
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Student::truncate();
        
        // Padam semua user dengan peranan 'Ibu Bapa' untuk memastikan seeder bersih
        $parents = \App\Models\User::role('Ibu Bapa')->get();
        foreach ($parents as $parent) {
            $parent->delete();
        }
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $this->command->info('Data lama telah dipadam. Memulakan penjanaan data contoh spesifik...');

        // Mendapatkan kelas pertama untuk data contoh
        $firstClass = KafaClass::first();
        if (!$firstClass) {
            $this->command->error('Tiada kelas ditemui. Sila jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // --- CONTOH 1 ---
        $p1 = User::factory()->create(['name' => 'Mohd Ridzuan bin Halim', 'email' => 'ridzuan@example.com']);
        $p1->assignRole('Ibu Bapa');
        Student::create([
            'school_id' => $firstClass->school_id, 'kafa_class_id' => $firstClass->id, 'parent_id' => $p1->id,
            'name' => 'Ahmad Zayyad bin Mohd Ridzuan', 'mykid' => '190515082213', 'gender' => 'L', 'dob' => '2019-05-15', 'age' => 7,
            'birth_place' => 'Hospital Manjung, Perak', 'race' => 'Melayu', 'citizenship' => 'Warganegara', 'oku_status' => 'Tiada',
            'address' => 'No 42, Jalan Prima 3, Taman Prima Jaya, 32040 Seri Manjung, Perak.',
            'registration_no' => 'KAFA/MNJ/2026/001', 'session_year' => '2026/2027', 'status' => 'Aktif', 'entry_date' => '2026-01-02', 'origin_school' => 'SK Seri Manjung',
            'father_name' => 'Mohd Ridzuan bin Halim', 'father_ic' => '850120085543', 'father_phone' => '013-4455667', 'father_job' => 'Juruteknik', 'father_income' => 4500,
            'mother_name' => 'Siti Aminah binti Idris', 'mother_ic' => '880412086672', 'mother_phone' => '019-5566778', 'mother_job' => 'Guru', 'mother_income' => 3800,
            'chronic_disease' => 'Tiada', 'allergies' => 'Tiada', 'emergency_contact' => 'Mohd Ridzuan (013-4455667)',
        ]);

        // --- CONTOH 2 ---
        $p2 = User::factory()->create(['name' => 'Abdul Basit bin Ahmad', 'email' => 'basit@example.com']);
        $p2->assignRole('Ibu Bapa');
        Student::create([
            'school_id' => $firstClass->school_id, 'kafa_class_id' => $firstClass->id, 'parent_id' => $p2->id,
            'name' => 'Nur Imanina binti Abdul Basit', 'mykid' => '161022080942', 'gender' => 'P', 'dob' => '2016-10-22', 'age' => 10,
            'birth_place' => 'Seri Manjung, Perak', 'race' => 'Melayu', 'citizenship' => 'Warganegara', 'oku_status' => 'Tiada',
            'address' => 'Lot 112, Kampung Tersusun, 32200 Lumut, Perak.',
            'registration_no' => 'KAFA/MNJ/2026/045', 'session_year' => '2026/2027', 'status' => 'Aktif', 'entry_date' => '2026-01-02', 'origin_school' => 'SK Lumut',
            'father_name' => 'Abdul Basit bin Ahmad', 'father_ic' => '820315085591', 'father_phone' => '012-4433221', 'father_job' => 'Peniaga', 'father_income' => 3000,
            'mother_name' => 'Noraini binti Yusuf', 'mother_ic' => '841102084432', 'mother_phone' => '017-6655443', 'mother_job' => 'Suri Rumah', 'mother_income' => 0,
            'chronic_disease' => 'Asma Ringan', 'allergies' => 'Seafood', 'emergency_contact' => 'Abdul Basit (012-4433221)',
        ]);

        // --- CONTOH 3 ---
        $p3 = User::factory()->create(['name' => 'Khairul Anuar bin Hassan', 'email' => 'khairul@example.com']);
        $p3->assignRole('Ibu Bapa');
        Student::create([
            'school_id' => $firstClass->school_id, 'kafa_class_id' => $firstClass->id, 'parent_id' => $p3->id,
            'name' => 'Muhammad Ammar bin Khairul Anuar', 'mykid' => '140210081123', 'gender' => 'L', 'dob' => '2014-02-10', 'age' => 12,
            'birth_place' => 'Sitiawan, Perak', 'race' => 'Melayu', 'citizenship' => 'Warganegara', 'oku_status' => 'Tiada',
            'address' => 'No 15, Jalan Venice Jaya 5, Desa Venice, 32040 Seri Manjung, Perak.',
            'registration_no' => 'KAFA/MNJ/2026/102', 'session_year' => '2026/2027', 'status' => 'Aktif', 'entry_date' => '2026-01-02', 'origin_school' => 'SK Methodist (ACS) Sitiawan', 'upkk_number' => 'UPKK202608102',
            'father_name' => 'Khairul Anuar bin Hassan', 'father_ic' => '790506085511', 'father_phone' => '014-9988776', 'father_job' => 'Penjawat Awam', 'father_income' => 5200,
            'mother_name' => 'Salmah binti Ismail', 'mother_ic' => '810908085524', 'mother_phone' => '011-2233445', 'mother_job' => 'Kerani', 'mother_income' => 2800,
            'chronic_disease' => 'Tiada', 'allergies' => 'Tiada', 'emergency_contact' => 'Khairul Anuar (014-9988776)',
        ]);

        $this->command->info('Data contoh spesifik telah dimasukkan. Menjana data dummy tambahan...');

        // Mendapatkan semua kelas yang ada
        $classes = KafaClass::all();

        foreach ($classes as $class) {
            // Mencipta murid tambahan untuk memenuhi kuota 3 orang setiap kelas
            $countNeeded = 3;
            if ($class->id === $firstClass->id) {
                $countNeeded = 0; // Sudah ada 3 contoh tadi
            }

            if ($countNeeded > 0) {
                Student::factory($countNeeded)->create([
                    'kafa_class_id' => $class->id,
                    'school_id' => $class->school_id,
                ])->each(function ($student) {
                    $parent = User::factory()->create([
                        'name' => 'Waris ' . $student->name,
                        'email' => 'parent_' . $student->id . '@example.com',
                    ]);
                    if (\Spatie\Permission\Models\Role::where('name', 'Ibu Bapa')->exists()) {
                        $parent->assignRole('Ibu Bapa');
                    }
                    $student->update(['parent_id' => $parent->id]);
                });
            }
        }

        $this->command->info('StudentSeeder berjaya dijalankan. 3 murid dicipta untuk setiap kelas.');
    }
}
