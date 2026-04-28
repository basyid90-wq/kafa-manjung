<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // 1. Create District
        $district = \App\Models\District::firstOrCreate(['name' => 'Manjung']);

        // 2. Create Subjects
        $subjectNames = ['Al-Quran', 'Ibadah', 'Sirah', 'Aqidah', 'Jawi'];
        $subjects = collect($subjectNames)->map(function ($name) {
            return \App\Models\Subject::firstOrCreate(['name' => $name], ['code' => strtoupper(substr($name, 0, 3))]);
        });

        // 3. Create Schools
        $schools = \App\Models\School::factory(10)->create([
            'district_id' => $district->id
        ]);

        foreach ($schools as $school) {
            // Create an Exam for each school
            $exam = \App\Models\Exam::factory()->create([
                'school_id' => $school->id,
                'name' => 'Ujian Akhir Tahun',
                'year' => date('Y')
            ]);

            // 4. Create Classes for each school
            $classes = \App\Models\KafaClass::factory(5)->create([
                'school_id' => $school->id
            ])->each(function ($class) {
                // Assign a teacher for each class
                $teacher = User::factory()->create();
                $teacher->assignRole('Guru KAFA');
                $class->update(['teacher_id' => $teacher->id]);
            });

            foreach ($classes as $class) {
                // 5. Create Students for each class
                \App\Models\Student::factory(30)->create([
                    'school_id' => $school->id,
                    'kafa_class_id' => $class->id
                ])->each(function ($student) use ($school, $class, $exam, $subjects) {
                    // Assign a parent for each student
                    $parent = User::factory()->create();
                    $parent->assignRole('Ibu Bapa');
                    $student->update(['parent_id' => $parent->id]);

                    // 6. Create 1 week of attendance
                    $startDate = now()->startOfWeek();
                    for ($i = 0; $i < 5; $i++) {
                        \App\Models\Attendance::factory()->create([
                            'school_id' => $school->id,
                            'kafa_class_id' => $class->id,
                            'student_id' => $student->id,
                            'date' => $startDate->copy()->addDays($i)->toDateString(),
                            'status' => 'Hadir'
                        ]);
                    }

                    // 7. Create Exam Results for each subject
                    foreach ($subjects as $subject) {
                        \App\Models\ExamResult::factory()->create([
                            'student_id' => $student->id,
                            'exam_id' => $exam->id,
                            'subject_id' => $subject->id
                        ]);
                    }
                });
            }
        }
    }
}
