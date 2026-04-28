
$dummyIds = \App\Models\User::where('id', '>', 6)->pluck('id');
echo "Dummy Users Count: " . count($dummyIds) . PHP_EOL;

if (count($dummyIds) > 0) {
    // List tables that might have user_id referencing dummy users
    $tables = [
        'attendances' => 'user_id',
        'rph_records' => 'user_id',
        'financial_records' => 'user_id',
        'book_orders' => 'user_id',
        'announcements' => 'user_id',
        'disciplinary_records' => 'user_id',
        'activities' => 'user_id',
        'kafa_classes' => 'user_id',
        'model_has_roles' => 'model_id',
        'model_has_permissions' => 'model_id',
    ];

    foreach ($tables as $table => $column) {
        if (\Illuminate\Support\Facades\Schema::hasTable($table) && \Illuminate\Support\Facades\Schema::hasColumn($table, $column)) {
            $query = \Illuminate\Support\Facades\DB::table($table)->whereIn($column, $dummyIds);
            if ($table == 'model_has_roles' || $table == 'model_has_permissions') {
                $query = $query->where('model_type', 'App\Models\User');
            }
            $num = $query->count();
            if ($num > 0) {
                echo "Table $table has $num records linked to dummy users. Deleting..." . PHP_EOL;
                $query->delete();
            }
        }
    }

    echo "Deleting dummy users..." . PHP_EOL;
    \App\Models\User::whereIn('id', $dummyIds)->delete();
    echo "Cleanup complete." . PHP_EOL;
} else {
    echo "No dummy users found (ID > 6)." . PHP_EOL;
}

echo "Final User Count: " . \App\Models\User::count() . PHP_EOL;
echo "Users IDs remaining: " . \App\Models\User::pluck('id')->implode(', ') . PHP_EOL;
