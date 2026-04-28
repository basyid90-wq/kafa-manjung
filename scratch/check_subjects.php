
echo "Subjects in Database:" . PHP_EOL;
foreach(\App\Models\Subject::all() as $s) {
    echo $s->id . ": " . $s->name . " (" . ($s->code ?? 'N/A') . ")" . PHP_EOL;
}
