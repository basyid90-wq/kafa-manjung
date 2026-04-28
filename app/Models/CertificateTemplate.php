<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name', 'level', 'district_id', 'school_id',
        'background_path', 'layout_style', 'include_signature', 'signature_path',
    ];

    protected $casts = [
        'include_signature' => 'boolean',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function studentCertificates()
    {
        return $this->hasMany(StudentCertificate::class);
    }
}
