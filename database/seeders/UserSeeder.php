<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Platform Super Admin. Credentials come from .env (SUPERADMIN_EMAIL / SUPERADMIN_PASSWORD);
     * never hard-code real passwords here.
     */
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL');
        if (!$email) {
            $this->command?->warn('SUPERADMIN_EMAIL tidak ditetapkan dalam .env — Super Admin tidak dicipta.');
            return;
        }

        $password = env('SUPERADMIN_PASSWORD');
        $generated = false;
        if (!$password) {
            $password  = Str::password(16);
            $generated = true;
        }

        $superadmin = User::firstOrCreate(
            ['email' => $email],
            [
                'name'              => env('SUPERADMIN_NAME', 'Super Admin'),
                'password'          => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
        $superadmin->assignRole('Super Admin');

        if ($generated && $superadmin->wasRecentlyCreated) {
            $this->command?->warn("Kata laluan Super Admin dijana: {$password} (tukar selepas log masuk)");
        }
    }
}
