<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable =[
        // 'content',
        // 'user_id',
        // 'product_id',
    ];
    public function users(){
        return $this->hasMany(User::class);
    }
}
