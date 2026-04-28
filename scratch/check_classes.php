
echo "Classes List:" . PHP_EOL;
foreach(\App\Models\KafaClass::all() as $c) {
    echo $c->id . ": " . $c->name . " - Teacher: " . ($c->teacher_id ?? 'NULL') . " - School: " . $c->school_id . PHP_EOL;
}

echo "Guru KAFA User:" . PHP_EOL;
$guru = \App\Models\User::where('email', 'guru@apkm.com')->first();
if ($guru) {
    echo "ID: " . $guru->id . " - Email: " . $guru->email . " - School: " . $guru->school_id . PHP_EOL;
}
