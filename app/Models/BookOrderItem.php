<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookOrderItem extends Model
{
    protected $fillable = [
        'book_order_id',
        'book_id',
        'quantity',
        'price_at_order'
    ];

    public function order()
    {
        return $this->belongsTo(BookOrder::class, 'book_order_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
