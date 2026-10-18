<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use BelongsToSchool;

    /** school_id NULL = shared with every tenant. */
    protected bool $sharedWhenSchoolIsNull = true;
    use HasFactory;
    protected $fillable = ['school_id', 'name', 'code', 'form_slot'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
