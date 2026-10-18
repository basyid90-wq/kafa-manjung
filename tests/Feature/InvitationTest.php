<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use App\Notifications\TeacherInvitation;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    private School $school;
    private User $guruBesar;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->school = School::factory()->create();
        $this->school->forceFill(['plan' => 'sekolah', 'type' => 'sekolah'])->save();

        $this->guruBesar = User::factory()->create(['school_id' => $this->school->id]);
        $this->guruBesar->assignRole('Guru Besar');
    }

    private function invite(string $email = 'guru@example.com'): string
    {
        [, $token] = Invitation::issue([
            'school_id' => $this->school->id, 'invited_by' => $this->guruBesar->id,
            'name' => 'Ustazah Aminah', 'email' => $email, 'role' => 'Guru KAFA',
        ]);

        return $token;
    }

    public function test_guru_besar_can_send_invitation(): void
    {
        Notification::fake();

        $this->actingAs($this->guruBesar)
            ->post(route('invitations.store'), ['name' => 'Ustazah Aminah', 'email' => 'aminah@example.com'])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('invitations', ['email' => 'aminah@example.com', 'school_id' => $this->school->id]);
        Notification::assertSentOnDemand(TeacherInvitation::class);
    }

    public function test_free_plan_cannot_invite(): void
    {
        $this->school->forceFill(['plan' => 'free'])->save();

        $this->actingAs($this->guruBesar)
            ->post(route('invitations.store'), ['name' => 'X', 'email' => 'x@example.com'])
            ->assertRedirect(route('subscription.index', ['modul' => 'pengguna']));

        $this->assertDatabaseCount('invitations', 0);
    }

    public function test_new_teacher_accepts_invitation(): void
    {
        $token = $this->invite();

        $this->get(route('invitations.show', $token))->assertOk()->assertSee('Cipta Akaun');

        $this->post(route('invitations.accept', $token), [
            'name' => 'Ustazah Aminah', 'password' => 'password', 'password_confirmation' => 'password', 'terms' => '1',
        ])->assertRedirect(route('dashboard'));

        $teacher = User::where('email', 'guru@example.com')->first();
        $this->assertAuthenticatedAs($teacher);
        $this->assertSame($this->school->id, $teacher->school_id);
        $this->assertTrue($teacher->hasRole('Guru KAFA'));
        $this->assertNotNull($teacher->email_verified_at);

        // Link is single-use
        $this->get(route('invitations.show', $token))->assertSee('tidak sah');
    }

    public function test_expired_invitation_is_rejected(): void
    {
        $token = $this->invite();
        Invitation::withoutGlobalScope('school')->update(['expires_at' => now()->subDay()]);

        $this->get(route('invitations.show', $token))->assertSee('tidak sah');
    }

    public function test_personal_teacher_merges_workspace_into_school(): void
    {
        $personal = School::factory()->create();
        $personal->forceFill(['type' => 'personal', 'plan' => 'personal'])->save();
        $teacher = User::factory()->create(['email' => 'guru@example.com', 'school_id' => $personal->id]);
        $teacher->assignRole('Guru Besar');
        $personal->forceFill(['owner_id' => $teacher->id])->save();

        $class = KafaClass::factory()->create(['school_id' => $personal->id]);
        Student::factory()->count(3)->create(['school_id' => $personal->id, 'kafa_class_id' => $class->id]);

        $token = $this->invite();

        $this->actingAs($teacher)->get(route('invitations.show', $token))->assertOk()->assertSee('Terima &amp; Gabungkan Data', false);
        $this->actingAs($teacher)->post(route('invitations.accept', $token))->assertRedirect(route('dashboard'));

        $teacher->refresh();
        $this->assertSame($this->school->id, $teacher->school_id);
        $this->assertTrue($teacher->hasRole('Guru KAFA'));
        $this->assertFalse($teacher->hasRole('Guru Besar'));
        $this->assertSame($this->school->id, $class->fresh()->school_id);
        $this->assertSame(3, Student::withoutGlobalScopes()->where('school_id', $this->school->id)->count());
        $this->assertNull($personal->fresh()->owner_id);
    }

    public function test_merge_is_blocked_when_mykid_already_exists_in_school(): void
    {
        $personal = School::factory()->create();
        $personal->forceFill(['type' => 'personal', 'plan' => 'personal'])->save();
        $teacher = User::factory()->create(['email' => 'guru@example.com', 'school_id' => $personal->id]);
        $teacher->assignRole('Guru Besar');
        $personal->forceFill(['owner_id' => $teacher->id])->save();

        Student::factory()->create(['school_id' => $personal->id, 'mykid' => '150101081111']);
        Student::factory()->create(['school_id' => $this->school->id, 'mykid' => '150101081111']);

        $token = $this->invite();

        $this->actingAs($teacher)->post(route('invitations.accept', $token))->assertSessionHas('error');
        $this->assertSame($personal->id, $teacher->fresh()->school_id);
    }

    public function test_owner_of_another_school_cannot_be_merged(): void
    {
        $other = School::factory()->create();
        $owner = User::factory()->create(['email' => 'guru@example.com', 'school_id' => $other->id]);
        $owner->assignRole('Guru Besar');
        $other->forceFill(['owner_id' => $owner->id])->save();

        $token = $this->invite();

        $this->actingAs($owner)->post(route('invitations.accept', $token))->assertSee('tidak boleh digabungkan');
        $this->assertSame($other->id, $owner->fresh()->school_id);
    }

    public function test_existing_account_must_log_in_as_invited_email(): void
    {
        $existing = User::factory()->create(['email' => 'guru@example.com', 'school_id' => null]);
        $existing->assignRole('Guru KAFA');
        $token = $this->invite();

        $this->get(route('invitations.show', $token))->assertSee('Log Masuk');
        $this->post(route('invitations.accept', $token))->assertForbidden();
    }
}
