<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DemoPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_demo(): void
    {
        $this->get('/demo')
            ->assertOk()
            ->assertSee('Mod Demo')
            ->assertSee(route('register'), false)
            ->assertDontSee('{{REGISTER_URL}}', false);
    }

    public function test_logged_in_user_can_open_demo(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $this->actingAs($user)->get('/demo')->assertOk();
    }

    public function test_homepage_links_to_demo(): void
    {
        $this->get('/')->assertOk()->assertSee(route('demo'), false);
    }
}
