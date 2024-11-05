<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'district',
        'country',
        'is_default',
    ];

    // Quan hệ với model `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
