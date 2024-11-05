<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_size_id',
        'quantity',
        'price',
    ];

    // Thiết lập quan hệ với model `Order`
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Thiết lập quan hệ với model `ProductSize`
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
