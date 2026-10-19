<?php

namespace Tests\Unit;

use App\Services\ExamService;
use Tests\TestCase;

class ExamServiceTest extends TestCase
{
    public function test_grade_boundaries_follow_config_scale(): void
    {
        $service = new ExamService();

        $this->assertSame('A', $service->calculateGrade(100));
        $this->assertSame('A', $service->calculateGrade(80));
        $this->assertSame('B', $service->calculateGrade(79));
        $this->assertSame('B', $service->calculateGrade(60));
        $this->assertSame('C', $service->calculateGrade(59));
        $this->assertSame('C', $service->calculateGrade(40));
        $this->assertSame('D', $service->calculateGrade(39));
        $this->assertSame('D', $service->calculateGrade(0));
    }

    public function test_scale_ranges_and_pass_rule(): void
    {
        $service = new ExamService();

        $this->assertSame(['A', 'B', 'C', 'D'], $service->grades());
        $this->assertSame(
            [[80, 100], [60, 79], [40, 59], [0, 39]],
            array_map(fn ($g) => [$g['min'], $g['max']], $service->gradeScale())
        );
        $this->assertSame('Memuaskan', $service->getGradeDescription('C'));
        $this->assertSame('Tidak Hadir', $service->getGradeDescription('TH'));
        $this->assertTrue($service->isPass('C'));
        $this->assertFalse($service->isPass('D'));
        $this->assertFalse($service->isPass('TH'));
    }
}
