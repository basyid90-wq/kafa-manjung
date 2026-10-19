<?php

namespace Tests\Feature;

use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Guru KAFA only works with students of the classes they teach (kafa_classes.teacher_id). */
class GuruKafaStudentScopeTest extends TestCase
{
    use RefreshDatabase;

    private School $school;
    private User $guru;
    private User $otherGuru;
    private KafaClass $ownClass;
    private KafaClass $otherClass;
    private Student $ownStudent;
    private Student $otherStudent;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite(); // pages render the layout; public/build is not committed
        $this->seed(RoleSeeder::class);

        $this->school = School::factory()->create();
        $this->school->forceFill(['plan' => 'sekolah'])->save(); // all modules, so only scope rules apply

        $this->guru = User::factory()->create(['school_id' => $this->school->id]);
        $this->guru->assignRole('Guru KAFA');
        $this->otherGuru = User::factory()->create(['school_id' => $this->school->id]);
        $this->otherGuru->assignRole('Guru KAFA');

        $this->ownClass = KafaClass::factory()->create([
            'school_id' => $this->school->id, 'tahun' => 1, 'teacher_id' => $this->guru->id,
        ]);
        $this->otherClass = KafaClass::factory()->create([
            'school_id' => $this->school->id, 'tahun' => 2, 'teacher_id' => $this->otherGuru->id,
        ]);

        $this->ownStudent = Student::factory()->create([
            'school_id' => $this->school->id, 'kafa_class_id' => $this->ownClass->id, 'name' => 'Murid Kelas Sendiri',
        ]);
        $this->otherStudent = Student::factory()->create([
            'school_id' => $this->school->id, 'kafa_class_id' => $this->otherClass->id, 'name' => 'Murid Kelas Lain',
        ]);
        Student::factory()->create([
            'school_id' => $this->school->id, 'kafa_class_id' => null, 'name' => 'Murid Tiada Kelas',
        ]);
    }

    public function test_index_lists_only_own_class_students(): void
    {
        $this->actingAs($this->guru)
            ->get(route('students.index'))
            ->assertOk()
            ->assertSee('Murid Kelas Sendiri')
            ->assertDontSee('Murid Kelas Lain')
            ->assertDontSee('Murid Tiada Kelas')
            ->assertViewHas('tahunCounts', fn ($c) => $c['semua'] === 1 && $c[1] === 1 && $c[2] === 0)
            ->assertViewHas('classes', fn ($classes) => $classes->pluck('id')->all() === [$this->ownClass->id]);
    }

    public function test_class_filter_cannot_reveal_another_class(): void
    {
        $this->actingAs($this->guru)
            ->get(route('students.index', ['class_id' => $this->otherClass->id]))
            ->assertOk()
            ->assertDontSee('Murid Kelas Lain');
    }

    public function test_guru_kafa_can_open_own_class_student(): void
    {
        $this->actingAs($this->guru)->get(route('students.show', $this->ownStudent))->assertOk();
        $this->actingAs($this->guru)->get(route('students.edit', $this->ownStudent))->assertOk();
    }

    public function test_guru_kafa_cannot_access_another_class_student(): void
    {
        $this->actingAs($this->guru);

        $this->get(route('students.show', $this->otherStudent))->assertForbidden();
        $this->get(route('students.edit', $this->otherStudent))->assertForbidden();
        $this->put(route('students.update', $this->otherStudent), [
            'name' => 'Diubah', 'mykid' => $this->otherStudent->mykid, 'kafa_class_id' => $this->ownClass->id,
        ])->assertForbidden();
        $this->delete(route('students.destroy', $this->otherStudent))->assertForbidden();

        $this->assertDatabaseHas('students', ['id' => $this->otherStudent->id, 'name' => 'Murid Kelas Lain']);
    }

    public function test_bulk_delete_skips_other_class_students(): void
    {
        $this->actingAs($this->guru)
            ->post(route('students.bulk-delete'), ['student_ids' => [$this->ownStudent->id, $this->otherStudent->id]]);

        $this->assertDatabaseMissing('students', ['id' => $this->ownStudent->id]);
        $this->assertDatabaseHas('students', ['id' => $this->otherStudent->id]);
    }

    public function test_guru_kafa_can_only_place_students_in_own_class(): void
    {
        $this->actingAs($this->guru)
            ->post(route('students.store'), ['name' => 'Murid Baru', 'mykid' => '190101080001', 'kafa_class_id' => $this->otherClass->id])
            ->assertSessionHasErrors('kafa_class_id');

        $this->actingAs($this->guru)
            ->post(route('students.store'), ['name' => 'Murid Baru', 'mykid' => '190101080001'])
            ->assertSessionHasErrors('kafa_class_id');

        $this->actingAs($this->guru)
            ->put(route('students.update', $this->ownStudent), [
                'name' => $this->ownStudent->name, 'mykid' => $this->ownStudent->mykid, 'kafa_class_id' => $this->otherClass->id,
            ])
            ->assertSessionHasErrors('kafa_class_id');

        $this->assertDatabaseMissing('students', ['name' => 'Murid Baru']);
        $this->assertDatabaseHas('students', ['id' => $this->ownStudent->id, 'kafa_class_id' => $this->ownClass->id]);
    }

    public function test_guru_kafa_cannot_print_qr_cards_of_another_class(): void
    {
        $this->actingAs($this->guru)->get(route('students.qr_cards', $this->ownClass))->assertOk();
        $this->actingAs($this->guru)->get(route('students.qr_cards', $this->otherClass))->assertForbidden();
    }

    public function test_guru_besar_still_sees_every_class_in_school(): void
    {
        $guruBesar = User::factory()->create(['school_id' => $this->school->id]);
        $guruBesar->assignRole('Guru Besar');

        $this->actingAs($guruBesar)
            ->get(route('students.index'))
            ->assertOk()
            ->assertSee('Murid Kelas Sendiri')
            ->assertSee('Murid Kelas Lain')
            ->assertSee('Murid Tiada Kelas');

        $this->actingAs($guruBesar)->get(route('students.show', $this->otherStudent))->assertOk();
    }
}
