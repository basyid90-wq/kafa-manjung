<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use BelongsToSchool;
    use HasFactory;
    protected $fillable = ['school_id', 'name', 'year', 'term'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
