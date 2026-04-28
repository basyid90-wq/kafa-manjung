
foreach(\Spatie\Permission\Models\Role::all() as $r) {
    echo $r->name . PHP_EOL;
}
