<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'view',
        'price',
        'status',
        'content',
        'brand_id',
    ];
    // Thiết lập quan hệ với model `Brand`
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Thiết lập quan hệ với model `ProductImg`
    public function productImgs()
    {
        return $this->hasMany(ProductImg::class, 'product_id');
    }

    public function latestImg()
    {
        return $this->hasOne(ProductImg::class, 'product_id')->latestOfMany(); // Ảnh mới nhất
    }

    public function firstImage()
    {
        return $this->productImgs()->orderBy('created_at', 'asc')->first();
    }

    // Thiết lập quan hệ với model `ProductSize`
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    // Thiết lập quan hệ với model `Category`
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
