<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
<<<<<<< HEAD
    use HasFactory, SoftDeletes;
=======
    use HasFactory; 
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb

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
