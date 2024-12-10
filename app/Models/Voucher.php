<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Giảm số lượng voucher
     */
    public function decrementQuantity()
    {
        $this->decrement('quantity');
    }

    protected $fillable = [
        'e_vorcher',
        'quantity',
        'discount',
        'status',
        'user_id',
        'product_id',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
