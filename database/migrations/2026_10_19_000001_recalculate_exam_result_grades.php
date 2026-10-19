<?php

use App\Services\ExamService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Recalculate stored grades from marks so every result follows config/grading.php. */
return new class extends Migration
{
    public function up(): void
    {
        $service = app(ExamService::class);
        $absent  = config('grading.absent_grade');

        DB::table('exam_results')->where('is_absent', true)->update(['grade' => $absent]);

        DB::table('exam_results')
            ->where('is_absent', false)
            ->whereNotNull('marks')
            ->orderBy('id')
            ->chunkById(500, function ($rows) use ($service) {
                foreach ($rows as $row) {
                    $grade = $service->calculateGrade($row->marks);
                    if ($row->grade !== $grade) {
                        DB::table('exam_results')->where('id', $row->id)->update(['grade' => $grade]);
                    }
                }
            });
    }

    public function down(): void
    {
        // Data-only migration: previous grades are not kept.
    }
};
