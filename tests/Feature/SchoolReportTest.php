<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\KafaClass;
use App\Models\RphRecord;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Services\ExamService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function school(string $name, string $plan = 'sekolah'): School
    {
        $school = School::factory()->create(['name' => $name]);
        $school->forceFill(['plan' => $plan, 'plan_expires_at' => now()->addMonth()])->save();

        return $school;
    }

    private function user(School $school, string $role, string $name = null): User
    {
        $user = User::factory()->create(array_filter(['school_id' => $school->id, 'name' => $name]));
        $user->assignRole($role);

        return $user;
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create(['school_id' => null]);
        $user->assignRole('Super Admin');

        return $user;
    }

    private function attendance(Student $student, string $date, string $status): void
    {
        Attendance::factory()->create([
            'school_id'     => $student->school_id,
            'kafa_class_id' => $student->kafa_class_id,
            'student_id'    => $student->id,
            'date'          => $date,
            'status'        => $status,
        ]);
    }

    public function test_attendance_report_lists_own_classes_without_district_columns(): void
    {
        $school = $this->school('SK Contoh');
        $gb     = $this->user($school, 'Guru Besar');
        $class  = KafaClass::factory()->create(['school_id' => $school->id, 'name' => 'Siddiq', 'tahun' => 3]);
        $a = Student::factory()->create(['school_id' => $school->id, 'kafa_class_id' => $class->id, 'name' => 'Ali Rajin']);
        $b = Student::factory()->create(['school_id' => $school->id, 'kafa_class_id' => $class->id, 'name' => 'Abu Ponteng']);

        foreach (['2026-03-02', '2026-03-03', '2026-03-04', '2026-03-05'] as $d) {
            $this->attendance($a, $d, 'Hadir');
        }
        $this->attendance($b, '2026-03-02', 'Hadir');
        foreach (['2026-03-03', '2026-03-04', '2026-03-05'] as $d) {
            $this->attendance($b, $d, 'Tidak Hadir');
        }

        $other      = $this->school('SK Jiran');
        $otherClass = KafaClass::factory()->create(['school_id' => $other->id, 'name' => 'Kelas Jiran']);

        $this->actingAs($gb)->get(route('reports.attendance', ['month' => 3, 'year' => 2026, 'school_id' => $other->id]))
            ->assertOk()
            ->assertSee('SK Contoh')
            ->assertSee('Tahun 3 — Siddiq')
            ->assertSee('62.5%')                 // 5 present of 8 records
            ->assertSee('Abu Ponteng')           // 25% → needs attention
            ->assertDontSee('Ali Rajin')
            ->assertDontSee('Kelas Jiran')
            ->assertDontSee('SK Jiran')
            ->assertDontSee('Nama Sekolah')
            ->assertDontSee('Sekolah Cemerlang');
    }

    public function test_super_admin_must_pick_a_school(): void
    {
        $school = $this->school('SK Pilihan');
        KafaClass::factory()->create(['school_id' => $school->id, 'name' => 'Amanah', 'tahun' => 1]);
        $admin = $this->superAdmin();

        $this->actingAs($admin)->get(route('reports.attendance'))
            ->assertOk()
            ->assertSee('Sila pilih sekolah')
            ->assertDontSee('Tahun 1 — Amanah');

        $this->actingAs($admin)->get(route('reports.attendance', ['school_id' => $school->id]))
            ->assertOk()
            ->assertSee('Tahun 1 — Amanah');

        $this->actingAs($admin)->get(route('reports.rph_kpi'))->assertOk()->assertSee('Sila pilih sekolah');
        $this->actingAs($admin)->get(route('reports.exams'))->assertOk()->assertSee('Sila pilih sekolah');
    }

    public function test_exam_report_breaks_down_by_class_and_subject_with_one_grade_scale(): void
    {
        $school  = $this->school('SK Contoh');
        $gb      = $this->user($school, 'Guru Besar');
        $class1  = KafaClass::factory()->create(['school_id' => $school->id, 'name' => 'Amanah', 'tahun' => 1]);
        $class2  = KafaClass::factory()->create(['school_id' => $school->id, 'name' => 'Bestari', 'tahun' => 2]);
        $s1      = Student::factory()->create(['school_id' => $school->id, 'kafa_class_id' => $class1->id]);
        $s2      = Student::factory()->create(['school_id' => $school->id, 'kafa_class_id' => $class2->id]);
        $tauhid  = Subject::factory()->create(['school_id' => null, 'name' => 'Tauhid']);
        $feqah   = Subject::factory()->create(['school_id' => null, 'name' => 'Feqah']);
        $exam    = Exam::factory()->create(['school_id' => $school->id, 'name' => 'Ujian Pertengahan Tahun']);

        // s1 passes both; s2 gets D (39) in Feqah → fails
        foreach ([[$s1, $tauhid, 85], [$s1, $feqah, 45], [$s2, $tauhid, 62], [$s2, $feqah, 39]] as [$st, $sub, $m]) {
            ExamResult::factory()->create(['student_id' => $st->id, 'exam_id' => $exam->id, 'subject_id' => $sub->id, 'marks' => $m, 'grade' => app(ExamService::class)->calculateGrade($m)]);
        }

        $this->actingAs($gb)->get(route('reports.exams', ['exam_id' => $exam->id]))
            ->assertOk()
            ->assertSee('Prestasi Mengikut Kelas')
            ->assertSee('Prestasi Mengikut Subjek')
            ->assertSee('Tahun 1 — Amanah')
            ->assertSee('Tahun 2 — Bestari')
            ->assertSee('Tauhid')
            ->assertSee('50.0%')                  // 1 of 2 candidates passed
            ->assertSee('C 40–59 (Memuaskan)')
            ->assertDontSee('Ranking')
            ->assertDontSee('GPS')
            ->assertDontSee('Nama Sekolah');
    }

    public function test_exam_report_ignores_exams_of_another_school(): void
    {
        $school = $this->school('SK Contoh');
        $gb     = $this->user($school, 'Guru Besar');
        $other  = $this->school('SK Jiran');
        $exam   = Exam::factory()->create(['school_id' => $other->id, 'name' => 'Ujian Sekolah Jiran']);

        $this->actingAs($gb)->get(route('reports.exams', ['exam_id' => $exam->id]))
            ->assertOk()
            ->assertDontSee('Ujian Sekolah Jiran')
            ->assertDontSee('Prestasi Mengikut Kelas');
    }

    public function test_old_exam_detail_url_redirects_and_stays_tenant_scoped(): void
    {
        $school = $this->school('SK Contoh');
        $gb     = $this->user($school, 'Guru Besar');
        $other  = $this->school('SK Jiran');

        $this->actingAs($gb)->get(route('reports.exams.detail', ['school' => $school->id, 'exam_id' => 5]))
            ->assertRedirect(route('reports.exams', ['exam_id' => 5]));

        $this->actingAs($gb)->get(route('reports.exams.detail', ['school' => $other->id, 'exam_id' => 5]))
            ->assertForbidden();
    }

    public function test_rph_kpi_report_lists_teachers_of_own_school(): void
    {
        $school  = $this->school('SK Contoh');
        $gb      = $this->user($school, 'Guru Besar');
        $teacher = $this->user($school, 'Guru KAFA', 'Ustazah Aminah');
        $class   = KafaClass::factory()->create(['school_id' => $school->id, 'name' => 'Siddiq', 'tahun' => 4, 'teacher_id' => $teacher->id]);
        $other   = $this->school('SK Jiran');
        $this->user($other, 'Guru KAFA', 'Ustaz Jiran');

        foreach (['2026-03-02' => 'approved', '2026-03-03' => 'pending', '2026-04-01' => 'approved'] as $date => $status) {
            RphRecord::create([
                'school_id' => $school->id, 'kafa_class_id' => $class->id, 'user_id' => $teacher->id,
                'date' => $date, 'week' => 10, 'topic' => 'Wuduk', 'objective' => 'Murid boleh berwuduk', 'status' => $status,
            ]);
        }

        $this->actingAs($gb)->get(route('reports.rph_kpi', ['bulan' => 3, 'tahun' => 2026, 'jumlah_hari_persekolahan' => 4]))
            ->assertOk()
            ->assertSee('KPI RPH Mengikut Guru')
            ->assertSee('Ustazah Aminah')
            ->assertSee('Tahun 4 — Siddiq')
            ->assertSee('50.0%')                  // 2 of 4 in March
            ->assertDontSee('Ustaz Jiran')
            ->assertDontSee('Nama Sekolah');

        // Weekly: ISO week 10 of 2026 = 2–8 March
        $this->actingAs($gb)->get(route('reports.rph_kpi', ['jenis_laporan' => 'Mingguan', 'minggu' => 10, 'tahun' => 2026, 'jumlah_hari_persekolahan' => 2]))
            ->assertOk()
            ->assertSee('100.0%');
    }

    public function test_school_reports_need_sekolah_plan(): void
    {
        $school = $this->school('SK Percuma', 'free');
        $gb     = $this->user($school, 'Guru Besar');

        foreach (['reports.attendance', 'reports.exams', 'reports.rph_kpi'] as $route) {
            $this->actingAs($gb)->get(route($route))
                ->assertRedirect(route('subscription.index', ['modul' => 'laporan_sekolah']));
        }
    }

    public function test_parent_slip_legend_follows_grade_scale(): void
    {
        $school  = $this->school('SK Contoh');
        $parent  = User::factory()->create(['school_id' => null]);
        $parent->assignRole('Ibu Bapa');
        $student = Student::factory()->create(['school_id' => $school->id, 'parent_id' => $parent->id]);
        $subject = Subject::factory()->create(['school_id' => null, 'name' => 'Akhlak']);
        $exam    = Exam::factory()->create(['school_id' => $school->id]);
        ExamResult::factory()->create(['student_id' => $student->id, 'exam_id' => $exam->id, 'subject_id' => $subject->id, 'marks' => 55, 'grade' => 'C']);

        $this->actingAs($parent)->get(route('parent.results.detail', [$student, $exam]))
            ->assertOk()
            ->assertSeeInOrder(['Akhlak', '55', 'C'])
            ->assertSee('40 – 59 (Memuaskan)')
            ->assertSee('0 – 39 (Lemah)')
            ->assertDontSee('50 – 59');
    }
}
