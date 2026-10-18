<?php

namespace Tests\Feature;

use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanGatingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function school(string $plan, string $type = 'sekolah', $expiresAt = null): School
    {
        $school = School::factory()->create();
        $school->forceFill(['plan' => $plan, 'type' => $type, 'plan_expires_at' => $expiresAt])->save();

        return $school;
    }

    private function guruBesar(School $school): User
    {
        $user = User::factory()->create(['school_id' => $school->id]);
        $user->assignRole('Guru Besar');

        return $user;
    }

    public function test_free_plan_redirects_locked_module_to_subscription_page(): void
    {
        $user = $this->guruBesar($this->school('free'));

        $this->actingAs($user)->get(route('rph.index'))
            ->assertRedirect(route('subscription.index', ['modul' => 'rph']));

        $this->actingAs($user)->get(route('users.index'))
            ->assertRedirect(route('subscription.index', ['modul' => 'pengguna']));
    }

    public function test_free_plan_can_use_basic_modules(): void
    {
        $user = $this->guruBesar($this->school('free'));

        $this->actingAs($user)->get(route('kafa_classes.index'))->assertOk();
        $this->actingAs($user)->get(route('students.index'))->assertOk();
        $this->actingAs($user)->get(route('subscription.index'))->assertOk();
    }

    public function test_personal_plan_unlocks_teacher_modules_but_not_school_modules(): void
    {
        $user = $this->guruBesar($this->school('personal', 'personal', now()->addMonth()));

        $this->actingAs($user)->get(route('rph.index'))->assertOk();
        $this->actingAs($user)->get(route('users.index'))->assertRedirect();
        $this->assertSame('Guru (Personal)', $user->roleLabel());
    }

    public function test_sekolah_plan_unlocks_everything(): void
    {
        $user = $this->guruBesar($this->school('sekolah', 'sekolah', now()->addYear()));

        $this->actingAs($user)->get(route('rph.index'))->assertOk();
        $this->actingAs($user)->get(route('users.index'))->assertOk();
        $this->actingAs($user)->get(route('financial.index'))->assertOk();
    }

    public function test_expired_plan_falls_back_to_free_after_grace_period(): void
    {
        $inGrace = $this->school('sekolah', 'sekolah', now()->subDay());
        $expired = $this->school('sekolah', 'sekolah', now()->subDays(config('plans.grace_days') + 1));

        $this->assertSame('sekolah', $inGrace->effectivePlan());
        $this->assertSame('free', $expired->effectivePlan());
        $this->assertTrue($expired->isPlanExpired());

        $this->actingAs($this->guruBesar($expired))->get(route('users.index'))->assertRedirect();
    }

    public function test_free_plan_class_limit(): void
    {
        $school = $this->school('free');
        $user = $this->guruBesar($school);
        KafaClass::factory()->count(3)->create(['school_id' => $school->id]);

        $this->actingAs($user)
            ->post(route('kafa_classes.store'), ['name' => 'Umar', 'tahun' => 2])
            ->assertRedirect(route('subscription.index'));

        $this->assertSame(3, $school->classCount());
    }

    public function test_free_plan_students_per_class_limit(): void
    {
        $school = $this->school('free');
        $user = $this->guruBesar($school);
        $class = KafaClass::factory()->create(['school_id' => $school->id]);
        Student::factory()->count(40)->create(['school_id' => $school->id, 'kafa_class_id' => $class->id, 'status' => 'Aktif']);

        $this->actingAs($user)
            ->post(route('students.store'), ['name' => 'Murid Ke-41', 'mykid' => '150101081234', 'kafa_class_id' => $class->id])
            ->assertSessionHasErrors('kafa_class_id');
    }

    public function test_guru_besar_cannot_change_own_plan(): void
    {
        $school = $this->school('free');
        $user = $this->guruBesar($school);

        $this->actingAs($user)->put(route('schools.update', $school), [
            'name' => $school->name,
            'plan' => 'sekolah',
            'plan_expires_at' => now()->addYears(5)->toDateString(),
        ]);

        $this->assertSame('free', $school->fresh()->plan);
    }

    public function test_super_admin_can_activate_plan(): void
    {
        $school = $this->school('free');
        $admin = User::factory()->create(['school_id' => null]);
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)->put(route('schools.update', $school), [
            'name' => $school->name,
            'type' => 'sekolah',
            'plan' => 'sekolah',
            'plan_expires_at' => now()->addYear()->toDateString(),
        ])->assertRedirect(route('schools.index'));

        $this->assertSame('sekolah', $school->fresh()->effectivePlan());
    }

    public function test_personal_workspace_cannot_get_sekolah_plan(): void
    {
        $school = $this->school('free', 'personal');
        $admin = User::factory()->create(['school_id' => null]);
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)->put(route('schools.update', $school), [
            'name' => $school->name,
            'type' => 'personal',
            'plan' => 'sekolah',
        ])->assertSessionHasErrors('plan');

        $this->assertSame('free', $school->fresh()->plan);
    }

    public function test_parent_portal_requires_sekolah_plan(): void
    {
        $parent = User::factory()->create(['school_id' => null, 'ic_number' => '800101085555']);
        $parent->assignRole('Ibu Bapa');

        $free = $this->school('free');
        Student::factory()->create(['school_id' => $free->id, 'father_ic' => '800101085555', 'parent_id' => $parent->id]);

        $this->actingAs($parent)->get(route('parent.dashboard'))->assertRedirect(route('dashboard'));

        $paid = $this->school('sekolah', 'sekolah', now()->addYear());
        Student::factory()->create(['school_id' => $paid->id, 'father_ic' => '800101085555', 'parent_id' => $parent->id]);

        $this->actingAs($parent)->get(route('parent.dashboard'))->assertOk();
    }
}
