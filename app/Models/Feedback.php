<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'module',
        'description',
        'image_path',
        'status',
        'admin_reply',
    ];

    public const MODULES = [
        'Log Masuk / Akaun',
        'Modul Murid',
        'Modul Kehadiran',
        'Modul Peperiksaan & Markah',
        'Modul Rekod Pencapaian',
        'Modul RPH',
        'Modul Jadual Waktu',
        'Modul Buku & Tempahan',
        'Modul Laporan / PDF',
        'Lain-lain',
    ];

    public const STATUSES = [
        'baru'           => ['label' => 'Baru',          'class' => 'bg-danger'],
        'dalam_semakan'  => ['label' => 'Dalam Semakan', 'class' => 'bg-warning text-dark'],
        'selesai'        => ['label' => 'Selesai',       'class' => 'bg-success'],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? $this->status;
    }

    public function getStatusClassAttribute(): string
    {
        return self::STATUSES[$this->status]['class'] ?? 'bg-secondary';
    }
}
