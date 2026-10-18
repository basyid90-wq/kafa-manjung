<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'account_type'          => 'sekolah',
            'school_name'           => 'KAFA Al-Hidayah',
            'name'                  => 'Ustaz Ahmad',
            'email'                 => 'ahmad@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'terms'                 => '1',
        ], $overrides);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get(route('register'))->assertStatus(200);
    }

    public function test_school_signup_creates_free_school_workspace_owned_by_guru_besar(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), $this->payload());

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'ahmad@example.com')->first();
        $this->assertTrue($user->hasRole('Guru Besar'));
        $this->assertSame('KAFA Al-Hidayah', $user->school->name);
        $this->assertSame('sekolah', $user->school->type);
        $this->assertSame('free', $user->school->plan);
        $this->assertSame($user->id, $user->school->owner_id);

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_personal_signup_creates_personal_workspace(): void
    {
        $this->post(route('register'), $this->payload(['account_type' => 'personal', 'school_name' => '']));

        $user = User::where('email', 'ahmad@example.com')->first();
        $this->assertSame('personal', $user->school->type);
        $this->assertSame('Guru (Personal)', $user->roleLabel());
        $this->assertSame('Kelas Ustaz Ahmad', $user->school->name);
    }

    public function test_school_name_is_required_for_school_account(): void
    {
        $this->post(route('register'), $this->payload(['school_name' => '']))
            ->assertSessionHasErrors('school_name');

        $this->assertGuest();
    }

    public function test_terms_must_be_accepted(): void
    {
        $this->post(route('register'), $this->payload(['terms' => null]))
            ->assertSessionHasErrors('terms');
    }

    public function test_honeypot_blocks_bots(): void
    {
        $this->post(route('register'), $this->payload(['website' => 'http://spam.example']));

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'ahmad@example.com']);
    }

    public function test_unverified_user_is_sent_to_verification_notice(): void
    {
        $this->post(route('register'), $this->payload());

        $this->get(route('dashboard'))->assertRedirect(route('verification.notice'));
    }
}
