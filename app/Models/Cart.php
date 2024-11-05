<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_size_id',
        'quantity',
    ];

    // Quan hệ với model `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với model `ProductSize`
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
