<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAchievementRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'school_id', 'kafa_class_id', 'academic_year',
        'midyear_exam_id', 'endyear_exam_id',
        'phci_midyear', 'phci_endyear',
        'kelakuan', 'kebersihan',
        'class_rank', 'grade_rank', 'total_in_class', 'total_in_grade',
        'teacher_comments', 'generated_by', 'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }

    public function midyearExam()
    {
        return $this->belongsTo(Exam::class, 'midyear_exam_id');
    }

    public function endyearExam()
    {
        return $this->belongsTo(Exam::class, 'endyear_exam_id');
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
