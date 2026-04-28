<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCertificate extends Model
{
    protected $fillable = [
        'student_id', 'certificate_template_id', 'reference_no',
        'activity_id', 'exam_id', 'issue_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
