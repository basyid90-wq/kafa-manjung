<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RphRecord extends Model
{
    protected $fillable = [
        'school_id', 'kafa_class_id', 'user_id',
        'date', 'hari', 'week', 'masa',
        'mata_pelajaran', 'mata_pelajaran_jawi',
        'topic', 'topic_jawi',
        'kemahiran', 'kemahiran_jawi',
        'isi_pelajaran', 'isi_pelajaran_jawi',
        'objective', 'objective_jawi',
        'aktiviti', 'aktiviti_jawi',
        'reflection', 'reflection_jawi',
        'learning_standard', 'learning_standard_jawi',
        'status', 'reviewer_id', 'review_comment',
        'class_type', 'combined_years',
        'objectives_by_year', 'standards_by_year', 'activities_by_year', 'assessment_by_year',
    ];

    protected $casts = [
        'combined_years' => 'array',
        'objectives_by_year' => 'array',
        'standards_by_year' => 'array',
        'activities_by_year' => 'array',
        'assessment_by_year' => 'array',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function periods()
    {
        return $this->hasMany(RphPeriod::class, 'rph_id')->orderBy('period_no');
    }

    public function isGabungan()
    {
        return $this->class_type === 'gabungan';
    }

    public function getCombinedYearsLabel()
    {
        if (!$this->isGabungan()) return '';

        $years = collect($this->combined_years)->sort()->values();
        return 'Tahun ' . $years->implode(', ');
    }
}
