<?php

namespace Tests\Feature;

use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    private School $schoolA;
    private School $schoolB;
    private User $guruBesarA;
    private Student $studentB;
    private KafaClass $classB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->schoolA = School::factory()->create();
        $this->schoolB = School::factory()->create();

        $this->guruBesarA = User::factory()->create(['school_id' => $this->schoolA->id]);
        $this->guruBesarA->assignRole('Guru Besar');

        $this->classB   = KafaClass::factory()->create(['school_id' => $this->schoolB->id]);
        $this->studentB = Student::factory()->create([
            'school_id'     => $this->schoolB->id,
            'kafa_class_id' => $this->classB->id,
        ]);
    }

    public function test_guru_besar_cannot_open_student_from_another_school(): void
    {
        $this->actingAs($this->guruBesarA)
            ->get(route('students.show', $this->studentB))
            ->assertNotFound();
    }

    public function test_guru_besar_cannot_delete_student_from_another_school(): void
    {
        $this->actingAs($this->guruBesarA)
            ->delete(route('students.destroy', $this->studentB))
            ->assertNotFound();

        $this->assertDatabaseHas('students', ['id' => $this->studentB->id]);
    }

    public function test_student_queries_are_scoped_to_own_school(): void
    {
        Student::factory()->count(2)->create(['school_id' => $this->schoolA->id]);

        $this->actingAs($this->guruBesarA);

        $this->assertSame(2, Student::count());
        $this->assertNull(Student::find($this->studentB->id));
    }

    public function test_new_records_default_to_own_school(): void
    {
        $this->actingAs($this->guruBesarA);

        $class = KafaClass::create(['name' => 'Abu Bakar', 'tahun' => 1]);

        $this->assertSame($this->schoolA->id, $class->school_id);
    }

    public function test_guru_besar_cannot_manage_user_from_another_school(): void
    {
        $teacherB = User::factory()->create(['school_id' => $this->schoolB->id]);
        $teacherB->assignRole('Guru KAFA');

        $this->actingAs($this->guruBesarA)
            ->get(route('users.edit', $teacherB))
            ->assertForbidden();

        $this->actingAs($this->guruBesarA)
            ->delete(route('users.destroy', $teacherB))
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $teacherB->id]);
    }

    public function test_guru_besar_cannot_list_teachers_or_classes_of_another_school(): void
    {
        $this->actingAs($this->guruBesarA)
            ->getJson(route('kafa_classes.get_teachers', $this->schoolB->id))
            ->assertForbidden();

        $this->actingAs($this->guruBesarA)
            ->getJson(route('kafa_classes.get_classes', $this->schoolB->id))
            ->assertForbidden();
    }

    public function test_guru_besar_cannot_edit_another_school_profile(): void
    {
        $this->actingAs($this->guruBesarA)
            ->get(route('schools.edit', $this->schoolB))
            ->assertForbidden();
    }

    public function test_user_without_school_sees_no_tenant_data(): void
    {
        $orphan = User::factory()->create(['school_id' => null]);
        $orphan->assignRole('Guru KAFA');

        $this->actingAs($orphan);

        $this->assertSame(0, Student::count());
    }

    public function test_super_admin_can_access_any_school(): void
    {
        $admin = User::factory()->create(['school_id' => null]);
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)
            ->get(route('students.show', $this->studentB))
            ->assertOk();
    }
}
