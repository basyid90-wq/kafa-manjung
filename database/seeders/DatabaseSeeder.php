<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Base data for every environment (no demo tenants — start clean).
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SubjectSeeder::class,
            AccountCategorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
