<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_report_shows_exam_marks_and_grade(): void
    {
        $this->seed(RoleSeeder::class);
        $school = School::factory()->create();
        $school->forceFill(['plan' => 'sekolah', 'plan_expires_at' => now()->addMonth()])->save();
        $gb = User::factory()->create(['school_id' => $school->id]);
        $gb->assignRole('Guru Besar');

        $class   = KafaClass::factory()->create(['school_id' => $school->id, 'teacher_id' => $gb->id]);
        $student = Student::factory()->create(['school_id' => $school->id, 'kafa_class_id' => $class->id]);
        $subject = Subject::factory()->create(['school_id' => null, 'name' => 'Sirah']);
        $exam    = Exam::factory()->create(['school_id' => $school->id, 'term' => 'akhir_tahun']);
        ExamResult::factory()->create(['student_id' => $student->id, 'exam_id' => $exam->id, 'subject_id' => $subject->id, 'marks' => 73, 'grade' => 'B']);

        $this->actingAs($gb)->get(route('reports.show', $student))
            ->assertOk()
            ->assertSee('Sirah')
            ->assertSeeInOrder(['Sirah', '73', 'B']);
    }
}
