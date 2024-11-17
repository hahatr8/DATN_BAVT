<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

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
