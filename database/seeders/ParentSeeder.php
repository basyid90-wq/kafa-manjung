<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Menjana akaun ujian Ibu Bapa dengan ic_number yang sepadan
 * dengan father_ic dalam rekod murid sedia ada.
 *
 * Cara uji:
 *   Log masuk: 850120085543 / Password: password123
 *   Log masuk: 820315085591 / Password: password123
 *   Log masuk: 790506085511 / Password: password123
 */
class ParentSeeder extends Seeder
{
    public function run(): void
    {
        // Pasangan IC → maklumat akaun (berdasarkan data dalam StudentSeeder)
        $testParents = [
            [
                'ic_number' => '850120085543', // father_ic murid: Ahmad Zayyad
                'name'      => 'Mohd Ridzuan bin Halim',
                'email'     => 'ridzuan.ibubapa@apkm.com',
            ],
            [
                'ic_number' => '820315085591', // father_ic murid: Nur Imanina
                'name'      => 'Abdul Basit bin Ahmad',
                'email'     => 'basit.ibubapa@apkm.com',
            ],
            [
                'ic_number' => '790506085511', // father_ic murid: Muhammad Ammar
                'name'      => 'Khairul Anuar bin Hassan',
                'email'     => 'khairul.ibubapa@apkm.com',
            ],
        ];

        foreach ($testParents as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'               => $data['name'],
                    'ic_number'          => $data['ic_number'],
                    'password'           => Hash::make('password123'),
                    'email_verified_at'  => now(),
                ]
            );

            $user->syncRoles(['Ibu Bapa']);

            $this->command->info(
                "Akaun dibina: {$data['name']} (IC: {$data['ic_number']})"
            );
        }

        $this->command->info('ParentSeeder selesai. Log masuk dengan IC sebagai username, password: password123');
    }
}
