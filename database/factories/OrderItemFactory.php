<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductSize;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(),  // Tạo một đơn hàng liên kết
            'product_size_id' => ProductSize::factory(),  // Tạo một kích thước sản phẩm liên kết
            'quantity' => $this->faker->numberBetween(1, 100),  // Số lượng ngẫu nhiên từ 1 đến 100
            'price' => $this->faker->randomFloat(2, 10, 1000),  // Giá ngẫu nhiên từ 10 đến 1000
        ];
    }
}
