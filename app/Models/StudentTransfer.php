<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTransfer extends Model
{
    protected $fillable = [
        'student_id',
        'from_school_id',
        'to_school_id',
        'reason',
        'status',
        'approved_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fromSchool()
    {
        return $this->belongsTo(School::class, 'from_school_id');
    }

    public function toSchool()
    {
        return $this->belongsTo(School::class, 'to_school_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
