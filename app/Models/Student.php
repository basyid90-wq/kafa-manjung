<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id', 'kafa_class_id', 'parent_id', 'name', 'jawi_name', 'mykid', 'gender',
        'profile_picture', 'dob', 'age', 'birth_place', 'race', 'citizenship', 'address', 'oku_status',
        'registration_no', 'session_year', 'entry_date', 'origin_school', 'upkk_number', 'status',
        'father_name', 'father_ic', 'father_phone', 'father_job', 'father_income',
        'mother_name', 'mother_ic', 'mother_phone', 'mother_job', 'mother_income',
        'dependents_count', 'parents_relationship_status',
        'chronic_disease', 'allergies', 'emergency_contact',
        'qr_code_string', 'photo',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function disciplinaryRecords()
    {
        return $this->hasMany(DisciplinaryRecord::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function certificates()
    {
        return $this->hasMany(StudentCertificate::class);
    }

    public function achievementRecords()
    {
        return $this->hasMany(StudentAchievementRecord::class);
    }

    /**
     * Dapatkan umur standard (Tahun Semasa - Tahun Lahir) untuk pendaftaran sekolah.
     */
    public function getStandardAgeAttribute()
    {
        if (!$this->dob) return '-';
        return now()->year - \Carbon\Carbon::parse($this->dob)->year;
    }
}
