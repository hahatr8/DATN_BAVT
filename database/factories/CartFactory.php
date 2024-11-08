<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Tạo người dùng ngẫu nhiên từ factory của User
            'product_size_id' => ProductSize::factory(),  // Tạo kích thước sản phẩm ngẫu nhiên từ factory của ProductSize
            'quantity' => $this->faker->numberBetween(1, 10),  // Số lượng sản phẩm ngẫu nhiên từ 1 đến 10
        ];
    }
}
