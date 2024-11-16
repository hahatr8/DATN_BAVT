<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant',
        'price',
        'img',
        'quantity',
        'status',
    ];

    // Mối quan hệ từ ProductSize đến Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

