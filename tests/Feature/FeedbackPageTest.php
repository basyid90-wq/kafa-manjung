<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_open_feedback_form(): void
    {
        $this->seed(RoleSeeder::class);
        $school = School::factory()->create();
        $gb = User::factory()->create(['school_id' => $school->id]);
        $gb->assignRole('Guru Besar');

        $this->actingAs($gb)->get(route('feedback.create'))
            ->assertOk()
            ->assertSee('ek-input', false);
    }
}
