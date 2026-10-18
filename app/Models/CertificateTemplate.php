<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use BelongsToSchool;

    /** school_id NULL = shared with every tenant. */
    protected bool $sharedWhenSchoolIsNull = true;
    protected $fillable = [
        'name', 'level', 'school_id',
        'background_path', 'layout_style', 'include_signature', 'signature_path',
    ];

    protected $casts = [
        'include_signature' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function studentCertificates()
    {
        return $this->hasMany(StudentCertificate::class);
    }
}
