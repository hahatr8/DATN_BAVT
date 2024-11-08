<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    protected $model = CategoryProduct::class;

    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id, // Chọn ngẫu nhiên category_id từ bảng categories
            'product_id' => Product::inRandomOrder()->first()->id, // Chọn ngẫu nhiên product_id từ bảng products
        ];
    }
}
