<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // Lấy ngẫu nhiên một brand hoặc sử dụng một giá trị mặc định
        $brand = Brand::inRandomOrder()->first();
        $brand_id = $brand ? $brand->id : Brand::factory()->create()->id;

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'view' => $this->faker->numberBetween(0, 1000), // Tạo giá trị view ngẫu nhiên
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->boolean(),
            'content' => $this->faker->paragraph,
            'brand_id' => $brand_id, // Đảm bảo luôn có giá trị brand_id hợp lệ
        ];
    }
}
