<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Local demo data — three tenants covering every plan (password for all: password):
 *   KAFA Demo 1  (Sekolah plan) : gurubesar@demo.test, guru@demo.test
 *   KAFA Demo 2  (Percuma)      : gurubesar2@demo.test, guru2@demo.test
 *   Ruang Ustazah Demo (Personal): personal@demo.test
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::whereNull('school_id')->get();

        foreach ([1, 2] as $n) {
            $school = School::firstOrCreate(
                ['code' => "DEMO-{$n}"],
                ['name' => "KAFA Demo {$n}", 'jenis_premis' => 'Surau']
            );
            $school->forceFill(['type' => 'sekolah', 'plan' => $n === 1 ? 'sekolah' : 'free', 'plan_expires_at' => $n === 1 ? now()->addYear() : null])->save();

            $suffix = $n === 1 ? '' : (string) $n;
            $gb = User::firstOrCreate(
                ['email' => "gurubesar{$suffix}@demo.test"],
                ['name' => "Guru Besar Demo {$n}", 'password' => Hash::make('password'), 'email_verified_at' => now(), 'school_id' => $school->id]
            );
            $gb->assignRole('Guru Besar');
            $school->forceFill(['owner_id' => $gb->id])->save();

            $teacher = User::firstOrCreate(
                ['email' => "guru{$suffix}@demo.test"],
                ['name' => "Guru KAFA Demo {$n}", 'password' => Hash::make('password'), 'email_verified_at' => now(), 'school_id' => $school->id]
            );
            $teacher->assignRole('Guru KAFA');

            foreach (['14:30' => '15:00', '15:00' => '15:30', '15:30' => '16:00', '16:00' => '16:30'] as $start => $end) {
                TimeSlot::firstOrCreate(['school_id' => $school->id, 'start_time' => $start], ['end_time' => $end]);
            }

            if (KafaClass::where('school_id', $school->id)->exists()) {
                continue;
            }

            $exam = Exam::factory()->create(['school_id' => $school->id, 'name' => 'Ujian Akhir Tahun', 'year' => date('Y')]);

            foreach ([1, 2, 3] as $tahun) {
                $class = KafaClass::factory()->create([
                    'school_id'  => $school->id,
                    'tahun'      => $tahun,
                    'teacher_id' => $tahun === 1 ? $teacher->id : $gb->id,
                ]);

                Student::factory(10)->create([
                    'school_id'     => $school->id,
                    'kafa_class_id' => $class->id,
                ])->each(function ($student) use ($school, $class, $exam, $subjects) {
                    $day = now()->startOfWeek();
                    for ($i = 0; $i < 5; $i++) {
                        Attendance::factory()->create([
                            'school_id'     => $school->id,
                            'kafa_class_id' => $class->id,
                            'student_id'    => $student->id,
                            'date'          => $day->copy()->addDays($i)->toDateString(),
                            'status'        => 'Hadir',
                        ]);
                    }

                    foreach ($subjects as $subject) {
                        ExamResult::factory()->create([
                            'student_id' => $student->id,
                            'exam_id'    => $exam->id,
                            'subject_id' => $subject->id,
                        ]);
                    }
                });
            }
        }

        // Personal workspace: one teacher, owner role = Guru Besar (shown as "Guru (Personal)")
        $ruang = School::firstOrCreate(['code' => 'DEMO-P'], ['name' => 'Ruang Ustazah Demo']);
        $ustazah = User::firstOrCreate(
            ['email' => 'personal@demo.test'],
            ['name' => 'Ustazah Demo', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'school_id' => $ruang->id]
        );
        $ustazah->assignRole('Guru Besar');
        $ruang->forceFill(['type' => 'personal', 'plan' => 'personal', 'plan_expires_at' => now()->addMonth(), 'owner_id' => $ustazah->id])->save();
        if (!KafaClass::where('school_id', $ruang->id)->exists()) {
            $class = KafaClass::factory()->create(['school_id' => $ruang->id, 'tahun' => 4, 'teacher_id' => $ustazah->id]);
            Student::factory(12)->create(['school_id' => $ruang->id, 'kafa_class_id' => $class->id]);
        }
    }
}
