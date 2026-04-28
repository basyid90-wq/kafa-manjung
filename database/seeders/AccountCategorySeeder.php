<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Yuran Bulanan', 'type' => 'in'],
            ['name' => 'Bantuan Kerajaan', 'type' => 'in'],
            ['name' => 'Sumbangan PIBG', 'type' => 'in'],
            ['name' => 'Bil Utiliti', 'type' => 'out'],
            ['name' => 'Penyelenggaraan', 'type' => 'out'],
            ['name' => 'Gaji Guru Tambahan', 'type' => 'out'],
            ['name' => 'Program Sekolah', 'type' => 'out'],
        ];

        foreach ($categories as $cat) {
            \App\Models\AccountCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
