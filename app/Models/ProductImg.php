<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImg extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'img',
        'is_main',
    ];

    // Thiết lập quan hệ với model `Product`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

