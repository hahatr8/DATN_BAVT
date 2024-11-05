<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(), // Tên hãng ngẫu nhiên
            'country' => $this->faker->country(), // Quốc gia ngẫu nhiên
            'description' => $this->faker->paragraph(), // Mô tả ngẫu nhiên
            'status' => $this->faker->boolean(), // Trạng thái ngẫu nhiên
            'logo' => $this->faker->imageUrl(640, 480, 'brands', true, 'Faker'), // URL logo giả lập
        ];
    }
}
