<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImg;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImgFactory extends Factory
{
    protected $model = ProductImg::class;

    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id, // Chọn ngẫu nhiên product_id từ bảng products
            'img' => $this->faker->imageUrl(640, 480, 'products', true), // Đường dẫn ngẫu nhiên cho ảnh sản phẩm
        ];
    }
}
