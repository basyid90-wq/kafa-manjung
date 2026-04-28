<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $fillable = [
        'school_id',
        'district_id',
        'status',
        'order_date',
        'total_price',
        'notes'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function items()
    {
        return $this->hasMany(BookOrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draf',
            'submitted_by_school' => 'Menunggu Admin',
            'approved_by_admin' => 'Menunggu Pembekal',
            'processing_by_supplier' => 'Sedang Diproses',
            'delivered_to_school' => 'Telah Dihantar',
            'completed' => 'Selesai',
            default => $this->status
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => 'bg-color-info-opacity color-info', // secondary often maps to info in this template
            'submitted_by_school' => 'bg-color-warning-opacity color-warning',
            'approved_by_admin' => 'bg-color-info-opacity color-info',
            'processing_by_supplier' => 'bg-color-warning-opacity color-warning',
            'delivered_to_school' => 'bg-color-success-opacity color-success',
            'completed' => 'bg-color-primary-opacity color-primary',
            default => 'bg-color-info-opacity color-info'
        };
    }
}
