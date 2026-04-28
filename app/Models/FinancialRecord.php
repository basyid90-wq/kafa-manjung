<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    protected $fillable = [
        'school_id',
        'user_id',
        'account_category_id',
        'amount',
        'transaction_type',
        'status',
        'transaction_date',
        'description',
        'reference_no'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(AccountCategory::class, 'account_category_id');
    }
}
