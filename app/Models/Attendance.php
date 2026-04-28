<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['school_id', 'kafa_class_id', 'student_id', 'date', 'status'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
