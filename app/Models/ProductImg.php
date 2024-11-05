<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'img',
    ];

    // Thiết lập quan hệ với model `Product`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

