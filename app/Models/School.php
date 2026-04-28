<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_id',
        'name',
        'code',
        'jenis_premis',
        'nama_guru_besar',
        'no_telefon',
        'alamat',
        'logo',
        'attendance_cutoff_time',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function kafaClasses()
    {
        return $this->hasMany(KafaClass::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function achievementRecords()
    {
        return $this->hasMany(StudentAchievementRecord::class);
    }
}
