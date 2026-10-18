<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use BelongsToSchool;
    protected $fillable = ['school_id', 'name', 'start_time', 'end_time'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
