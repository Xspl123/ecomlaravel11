<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function getSubtotalAttribute($value)
    {
        return '₹' . number_format($value, 2);
    }
    public function getPriceAttribute($value)
    {
        return '₹' . number_format($value, 2);
    }

    public function getTaxAttribute($value)
    {
        return '₹' . number_format($value, 2);
    }

    public function getTotalAttribute($value)
    {
        return '₹' . number_format($value, 2);
    }
}
