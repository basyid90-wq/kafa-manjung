
$password = \Illuminate\Support\Facades\Hash::make('901022aspura');

// 1. Penyelia KAFA
$penyelia = \App\Models\User::updateOrCreate(
    ['email' => 'penyelia.manjung@apkm.com'],
    [
        'name' => 'Penyelia Manjung',
        'password' => $password,
        'district_id' => 1, // Manjung
        'email_verified_at' => now(),
    ]
);
$penyelia->syncRoles(['Penyelia KAFA']);
echo "Updated/Created: Penyelia Manjung (District: 1)" . PHP_EOL;

// 2. Pembekal
$pembekal = \App\Models\User::updateOrCreate(
    ['email' => 'pembekal@apkm.com'],
    [
        'name' => 'Pembekal APKM',
        'password' => $password,
        'email_verified_at' => now(),
    ]
);
$pembekal->syncRoles(['Pembekal']);
echo "Updated/Created: Pembekal APKM" . PHP_EOL;

// 3. Guru Besar
$gurubesar = \App\Models\User::updateOrCreate(
    ['email' => 'gurubesar@apkm.com'],
    [
        'name' => 'Guru Besar',
        'password' => $password,
        'school_id' => 1,
        'district_id' => 1, // Must be 1 to match school 1 and supervisor
        'email_verified_at' => now(),
    ]
);
$gurubesar->syncRoles(['Guru Besar']);
echo "Updated/Created: Guru Besar (School: 1, District: 1)" . PHP_EOL;

// 4. Guru KAFA
$guru = \App\Models\User::updateOrCreate(
    ['email' => 'guru@apkm.com'],
    [
        'name' => 'Guru KAFA',
        'password' => $password,
        'school_id' => 1,
        'district_id' => 1, // Must be 1
        'email_verified_at' => now(),
    ]
);
$guru->syncRoles(['Guru KAFA']);
echo "Updated/Created: Guru KAFA (School: 1, District: 1)" . PHP_EOL;

echo "Final User List Verification:" . PHP_EOL;
foreach(\App\Models\User::all() as $u) {
    echo $u->id . ": " . $u->name . " - District: " . ($u->district_id ?? 'NULL') . " - School: " . ($u->school_id ?? 'NULL') . PHP_EOL;
}
