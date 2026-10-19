<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use App\Support\SidebarMenu;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidebarMenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function owner(string $type, string $plan): User
    {
        $school = School::factory()->create();
        $school->forceFill(['type' => $type, 'plan' => $plan, 'plan_expires_at' => $plan === 'free' ? null : now()->addMonth()])->save();
        $user = User::factory()->create(['school_id' => $school->id]);
        $user->assignRole('Guru Besar');
        $school->forceFill(['owner_id' => $user->id])->save();

        return $user;
    }

    private function items(User $user): array
    {
        $this->actingAs($user);

        return collect(SidebarMenu::for($user))->pluck('items')->flatten(1)->keyBy('label')->all();
    }

    public function test_free_school_sees_paid_modules_locked_with_upgrade_link(): void
    {
        $items = $this->items($this->owner('sekolah', 'free'));

        $this->assertFalse($items['Murid']['locked']);
        $this->assertTrue($items['Rekod RPH']['locked']);
        $this->assertSame('Sekolah', $items['Rekod RPH']['planLabel']);
        $this->assertStringContainsString('/langganan', $items['Rekod RPH']['url']);
        $this->assertTrue($items['Kewangan']['locked']);
    }

    public function test_personal_workspace_hides_school_only_modules(): void
    {
        $items = $this->items($this->owner('personal', 'personal'));

        $this->assertFalse($items['Rekod RPH']['locked']);
        $this->assertArrayNotHasKey('Pindah Murid', $items);
        $this->assertArrayNotHasKey('Urus Guru & Pengguna', $items);
    }

    public function test_guru_kafa_does_not_see_owner_only_items(): void
    {
        $owner = $this->owner('sekolah', 'sekolah');
        $guru  = User::factory()->create(['school_id' => $owner->school_id]);
        $guru->assignRole('Guru KAFA');

        $items = $this->items($guru);

        $this->assertArrayHasKey('Kehadiran Harian', $items);
        $this->assertArrayNotHasKey('Urus Guru & Pengguna', $items);
        $this->assertArrayNotHasKey('Kewangan', $items);
        $this->assertArrayNotHasKey('Langganan', $items);
    }

    public function test_layout_renders_module_menu(): void
    {
        $this->actingAs($this->owner('sekolah', 'free'))->get('/dashboard')
            ->assertOk()
            ->assertSee('Modul Asas')
            ->assertSee('Kehadiran Harian')
            ->assertSee('Tersedia dalam pelan Sekolah');
    }
}
