<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\KafaClass;

class CleanUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Padam SEMUA data murid terlebih dahulu (mengelakkan isu Foreign Key)
        Student::query()->delete();

        // 2. Padam SEMUA data kelas KECUALI kelas yang bernama 'Abu Bakar'
        KafaClass::where('name', '!=', 'Abu Bakar')->delete();
    }
}
