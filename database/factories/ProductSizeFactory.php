<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSizeFactory extends Factory
{
    protected $model = ProductSize::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),  // Tạo một sản phẩm liên kết
            'variant' => $this->faker->randomElement(['Small', 'Medium', 'Large']),  // Kích thước ngẫu nhiên
            'price' => $this->faker->randomFloat(2, 10, 100),  // Giá ngẫu nhiên từ 10 đến 100
            'img' => $this->faker->imageUrl(640, 480, 'product'),  // URL ảnh giả lập
            'quantity' => $this->faker->numberBetween(1, 50),  // Số lượng ngẫu nhiên
            'status' => $this->faker->boolean(),  // Trạng thái ngẫu nhiên
        ];
    }
}
