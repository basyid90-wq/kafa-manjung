<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaryRecord extends Model
{
    protected $fillable = [
        'student_id',
        'school_id',
        'reported_by',
        'date',
        'offense_details',
        'action_taken'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
