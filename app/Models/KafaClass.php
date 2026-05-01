<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KafaClass extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'name', 'tahun', 'teacher_id'];

    protected $casts = ['tahun' => 'integer'];

    // ── Accessor ─────────────────────────────────────────────────────────
    // "Tahun 3 — Siddiq"  |  fallback: name as-is (supports legacy combined names)
    public function getDisplayNameAttribute(): string
    {
        if ($this->tahun) {
            return 'Tahun ' . $this->tahun . ' — ' . $this->name;
        }
        return $this->name ?? '';
    }

    // ── Relationships ─────────────────────────────────────────────────────
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function achievementRecords()
    {
        return $this->hasMany(StudentAchievementRecord::class);
    }
}
