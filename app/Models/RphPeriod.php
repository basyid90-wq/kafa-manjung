<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RphPeriod extends Model
{
    protected $fillable = [
        'rph_id', 'period_no', 'kafa_class_id', 'masa',
        'mata_pelajaran_jawi', 'topic_jawi', 'kemahiran_jawi',
        'isi_pelajaran_jawi', 'objective_jawi', 'aktiviti_jawi',
        'reflection_jawi',
        // Cantum (gabungan) fields
        'tajuk_by_year', 'isi_pelajaran_by_year', 'objective_by_year', 'aktiviti_by_year',
        'kemahiran_selected', 'strategi_pdc', 'impak',
    ];

    protected $casts = [
        'tajuk_by_year'        => 'array',
        'isi_pelajaran_by_year' => 'array',
        'objective_by_year'    => 'array',
        'aktiviti_by_year'     => 'array',
        'kemahiran_selected'   => 'array',
        'strategi_pdc'         => 'array',
        'impak'                => 'array',
    ];

    public function rphRecord()
    {
        return $this->belongsTo(RphRecord::class, 'rph_id');
    }

    public function kafaClass()
    {
        return $this->belongsTo(KafaClass::class);
    }
}
