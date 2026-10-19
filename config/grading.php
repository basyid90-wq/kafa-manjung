<?php

/*
|--------------------------------------------------------------------------
| KAFA grade scale — the single source of truth
|--------------------------------------------------------------------------
| Read through App\Services\ExamService (calculateGrade, gradeScale,
| isPass, ...). Do not hard-code thresholds in controllers or views.
| Ordered from highest to lowest; `min` is the lowest mark for the grade.
| Changing this scale? Recalculate stored exam_results.grade as well.
*/

return [

    'scale' => [
        ['grade' => 'A', 'min' => 80, 'label' => 'Cemerlang'],
        ['grade' => 'B', 'min' => 60, 'label' => 'Baik'],
        ['grade' => 'C', 'min' => 40, 'label' => 'Memuaskan'],
        ['grade' => 'D', 'min' => 0,  'label' => 'Lemah'],
    ],

    'max_marks' => 100,

    // Grade stored for an absent candidate.
    'absent_grade' => 'TH',
    'absent_label' => 'Tidak Hadir',

    // A subject is passed unless its grade is listed here; a candidate passes when every subject is passed.
    'fail_grades' => ['D', 'TH'],

];
