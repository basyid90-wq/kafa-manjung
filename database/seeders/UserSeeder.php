<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pembersihan: Padam semua pengguna kecuali 5 akaun rasmi
        User::whereNotIn('email', [
            'basyid90@gmail.com',
            'admin@apkm.com',
            'pembekal@apkm.com',
            'gurubesar@apkm.com',
            'guru@apkm.com'
        ])->delete();

        // 2. Jana 5 Akaun Rasmi (Update or Create)

        // Super Admin
        $superadmin = User::updateOrCreate(
            ['email' => 'basyid90@gmail.com'],
            [
                'name' => 'Basyid',
                'password' => Hash::make('901022aspura'),
                'email_verified_at' => now(),
            ]
        );
        $superadmin->assignRole('Super Admin');

        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@apkm.com'],
            [
                'name' => 'Admin APKM',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Pentadbir');

        // Pembekal
        $pembekal = User::updateOrCreate(
            ['email' => 'pembekal@apkm.com'],
            [
                'name' => 'Pembekal Buku',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $pembekal->assignRole('Pembekal');

        // Guru Besar
        $gurubesar = User::updateOrCreate(
            ['email' => 'gurubesar@apkm.com'],
            [
                'name' => 'Guru Besar',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $gurubesar->assignRole('Guru Besar');
        
        // Guru KAFA
        $guru = User::updateOrCreate(
            ['email' => 'guru@apkm.com'],
            [
                'name' => 'Guru KAFA',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $guru->assignRole('Guru KAFA');

        // Penyelia KAFA (New)
        $manjung = \App\Models\District::where('name', 'Manjung')->first();
        $penyelia = User::updateOrCreate(
            ['email' => 'penyelia.manjung@apkm.com'],
            [
                'name' => 'Penyelia Manjung',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'district_id' => $manjung ? $manjung->id : null,
            ]
        );
        $penyelia->assignRole('Penyelia KAFA');
    }
}
