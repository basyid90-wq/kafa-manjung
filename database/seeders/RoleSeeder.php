<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // SaaS roles: platform owner, school owner (Sekolah plan), teacher, parent
        $roles = [
            'Super Admin',
            'Guru Besar',
            'Guru KAFA',
            'Ibu Bapa',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
