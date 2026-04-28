<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'school_id',
        'district_id',
        'tahap',
        'name',
        'date',
        'description',
        'photo_path',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * Label tahap untuk paparan UI.
     */
    public function getTahapLabelAttribute(): string
    {
        return match ($this->tahap) {
            'daerah' => 'Peringkat Daerah',
            'negeri' => 'Peringkat Negeri',
            default  => 'Peringkat Sekolah',
        };
    }

    /**
     * Warna badge Bootstrap ikut tahap.
     */
    public function getTahapBadgeAttribute(): string
    {
        return match ($this->tahap) {
            'daerah' => 'warning',
            'negeri' => 'danger',
            default  => 'success',
        };
    }
}
