<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_order',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function category_product() {
        return $this->belongsTo(CategoryProduct::class);
    }

}
