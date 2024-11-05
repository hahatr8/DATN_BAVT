<?php

namespace Database\Factories;

use App\Models\View;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewFactory extends Factory
{
    protected $model = View::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),  // ID sản phẩm ngẫu nhiên từ factory của Product
            'user_id' => User::factory(),  // ID người dùng ngẫu nhiên từ factory của User
            'last_viewed_at' => $this->faker->dateTimeThisYear(),  // Ngày xem cuối cùng ngẫu nhiên trong năm nay
        ];
    }
}
