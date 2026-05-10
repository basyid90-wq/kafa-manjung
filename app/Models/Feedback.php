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
        'baru'           => ['label' => 'Baru',          'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
        'dalam_semakan'  => ['label' => 'Dalam Semakan', 'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'],
        'selesai'        => ['label' => 'Selesai',       'class' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
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
