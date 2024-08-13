<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function getSubtotalAttribute($value)
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
    public function getDiscountAttribute($value)
    {
        return '₹' . number_format($value, 2);
    }
}
