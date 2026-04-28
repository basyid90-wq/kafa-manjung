<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'price', 'description', 'tahun_darjah'];

    public function orderItems()
    {
        return $this->hasMany(BookOrderItem::class);
    }
}
