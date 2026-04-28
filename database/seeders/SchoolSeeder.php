<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // Cipta Daerah Manjung
        $districtId = DB::table('districts')->insertGetId([
            'name' => 'Manjung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cipta Sekolah KAFA Daerah Manjung
        $schoolId = DB::table('schools')->insertGetId([
            'district_id' => $districtId,
            'name' => 'KAFA Daerah Manjung',
            'code' => 'KAFA-MJG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign school_id kepada semua user yang ada
        DB::table('users')->update(['school_id' => $schoolId]);
    }
}
