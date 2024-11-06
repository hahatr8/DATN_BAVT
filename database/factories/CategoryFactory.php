<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Tên ngẫu nhiên cho category
            'display_order' => $this->faker->randomNumber(), // Thứ tự ngẫu nhiên
            'status' => $this->faker->boolean(), // Trạng thái ngẫu nhiên
        ];
    }
}

