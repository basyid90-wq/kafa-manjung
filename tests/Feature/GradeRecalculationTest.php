<?php

namespace Tests\Feature;

use App\Models\ExamResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeRecalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_recalculates_stored_grades_from_marks(): void
    {
        $wrong  = ExamResult::factory()->create(['marks' => 45, 'grade' => 'D', 'is_absent' => false]);
        $five   = ExamResult::factory()->create(['marks' => 20, 'grade' => 'E', 'is_absent' => false]);
        $absent = ExamResult::factory()->create(['marks' => 0, 'grade' => 'E', 'is_absent' => true]);

        (require database_path('migrations/2026_10_19_000001_recalculate_exam_result_grades.php'))->up();

        $this->assertSame('C', $wrong->fresh()->grade);
        $this->assertSame('D', $five->fresh()->grade);
        $this->assertSame('TH', $absent->fresh()->grade);
    }
}
