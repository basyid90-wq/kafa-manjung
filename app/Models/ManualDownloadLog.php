<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualDownloadLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'role_name', 'school_id', 'downloaded_at'];

    protected $casts = ['downloaded_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
