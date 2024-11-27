<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'status',
        'user_id',
        'product_id',
        'blog_id',
    ];

    // Quan hệ với model `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với model `Product`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Quan hệ với Blog
    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
        public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}