<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'name', 'slug', 'category_id', 'brand_id', 'short_description', 'description', 'regular_price', 'sale_price', 'SKU', 'quantity', 'stock_status', 'featured', 'image', 'gallery_images'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
