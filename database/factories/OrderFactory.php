<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Tạo người dùng ngẫu nhiên từ factory của User
            'address_id' => Address::factory(),  // Tạo địa chỉ ngẫu nhiên từ factory của Address
            'status_order' => $this->faker->randomElement([Order::STATUS_ORDER_PENDING, Order::STATUS_ORDER_COMPLETED]),  // Trạng thái đơn hàng ngẫu nhiên
            'status_payment' => $this->faker->randomElement([Order::STATUS_PAYMENT_MOMO, Order::STATUS_PAYMENT_CASH]),  // Trạng thái thanh toán ngẫu nhiên
            'total_price' => $this->faker->randomFloat(2, 100, 10000),  // Tổng giá trị đơn hàng ngẫu nhiên từ 100 đến 10000
        ];
    }
}
