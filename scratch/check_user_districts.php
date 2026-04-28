
foreach(\App\Models\User::all() as $u) {
    echo $u->id . ": " . $u->name . " - District: " . ($u->district_id ?? 'NULL') . " - School: " . ($u->school_id ?? 'NULL') . PHP_EOL;
}
