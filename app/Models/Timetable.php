<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = ['kafa_class_id', 'subject_id', 'user_id', 'time_slot_id', 'day_of_week'];

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
