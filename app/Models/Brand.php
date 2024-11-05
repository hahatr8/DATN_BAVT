<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'description',
        'status',
        'logo',
    ];

    // Thiết lập quan hệ với model `Product`
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
