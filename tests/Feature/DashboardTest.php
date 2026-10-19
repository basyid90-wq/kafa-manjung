<?php

namespace Tests\Feature;

use App\Models\Attendance;
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

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private School $school;
    private User $guruBesar;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->school = School::factory()->create();
        $this->school->forceFill(['plan' => 'sekolah', 'plan_expires_at' => now()->addMonth()])->save();

        $this->guruBesar = User::factory()->create(['school_id' => $this->school->id]);
        $this->guruBesar->assignRole('Guru Besar');
        $this->school->forceFill(['owner_id' => $this->guruBesar->id])->save();
    }

    private function studentsIn(KafaClass $class, array $statuses): void
    {
        foreach ($statuses as $status) {
            $student = Student::factory()->create(['school_id' => $class->school_id, 'kafa_class_id' => $class->id]);
            Attendance::factory()->create([
                'school_id' => $class->school_id, 'kafa_class_id' => $class->id, 'student_id' => $student->id,
                'date' => today()->toDateString(), 'status' => $status,
            ]);
        }
    }

    public function test_guru_besar_sees_todays_attendance_for_own_school_only(): void
    {
        $class = KafaClass::factory()->create(['school_id' => $this->school->id, 'teacher_id' => $this->guruBesar->id]);
        $this->studentsIn($class, ['Hadir', 'Hadir', 'Lewat', 'Tidak Hadir']);

        // Another school's absences must not affect the figure
        $other = School::factory()->create();
        $otherClass = KafaClass::factory()->create(['school_id' => $other->id]);
        $this->studentsIn($otherClass, ['Tidak Hadir', 'Tidak Hadir']);

        $this->actingAs($this->guruBesar)->get('/dashboard')
            ->assertOk()
            ->assertSee('75%')
            ->assertSee('3 / 4 hadir · 1 tidak hadir');
    }

    public function test_guru_besar_sees_subject_averages_for_latest_exam(): void
    {
        $class   = KafaClass::factory()->create(['school_id' => $this->school->id, 'teacher_id' => $this->guruBesar->id]);
        $student = Student::factory()->create(['school_id' => $this->school->id, 'kafa_class_id' => $class->id]);
        $subject = Subject::factory()->create(['school_id' => null, 'name' => 'Al-Quran']);
        $exam    = Exam::factory()->create(['school_id' => $this->school->id, 'name' => 'Ujian Akhir', 'term' => 'akhir_tahun']);
        ExamResult::factory()->create(['student_id' => $student->id, 'exam_id' => $exam->id, 'subject_id' => $subject->id, 'marks' => 85, 'grade' => 'A']);

        $this->actingAs($this->guruBesar)->get('/dashboard')
            ->assertOk()
            ->assertSee('Purata Markah Ikut Subjek')
            ->assertSee('Ujian Akhir')
            ->assertSee('Al-Quran');
    }

    public function test_guru_kafa_attendance_only_counts_own_classes(): void
    {
        $guru = User::factory()->create(['school_id' => $this->school->id]);
        $guru->assignRole('Guru KAFA');

        $mine   = KafaClass::factory()->create(['school_id' => $this->school->id, 'teacher_id' => $guru->id]);
        $others = KafaClass::factory()->create(['school_id' => $this->school->id, 'teacher_id' => $this->guruBesar->id]);
        $this->studentsIn($mine, ['Hadir', 'Hadir']);
        $this->studentsIn($others, ['Tidak Hadir', 'Tidak Hadir']);

        $this->actingAs($guru)->get('/dashboard')
            ->assertOk()
            ->assertSee('100%')
            ->assertSee('2 / 2 hadir · 0 tidak hadir');
    }

    public function test_dashboard_only_lists_announcements_targeted_at_the_user(): void
    {
        $guru = User::factory()->create(['school_id' => $this->school->id]);
        $guru->assignRole('Guru KAFA');

        $forTeachers = \App\Models\Announcement::create(['title' => 'Mesyuarat Guru', 'content' => 'Untuk guru', 'user_id' => $this->guruBesar->id, 'school_id' => $this->school->id, 'target_scope' => 'school']);
        $forTeachers->targetedUsers()->attach($guru->id);
        \App\Models\Announcement::create(['title' => 'Notis Ibu Bapa Sahaja', 'content' => 'Untuk ibu bapa', 'user_id' => $this->guruBesar->id, 'school_id' => $this->school->id, 'target_scope' => 'school']);

        $this->actingAs($guru)->get('/dashboard')
            ->assertOk()
            ->assertSee('Mesyuarat Guru')
            ->assertDontSee('Notis Ibu Bapa Sahaja');
    }

    public function test_empty_school_dashboard_renders(): void
    {
        $this->actingAs($this->guruBesar)->get('/dashboard')
            ->assertOk()
            ->assertSee('Belum direkod hari ini')
            ->assertSee('Belum ada markah peperiksaan');
    }

    public function test_super_admin_dashboard_renders(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)->get('/dashboard')
            ->assertOk()
            ->assertSee('Kesihatan Sistem');
    }
}
