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
