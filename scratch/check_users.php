
foreach(\App\Models\User::all() as $u) {
    echo $u->id . ": " . $u->name . " (" . $u->email . ")" . PHP_EOL;
}
echo "Total Users: " . \App\Models\User::count() . PHP_EOL;
