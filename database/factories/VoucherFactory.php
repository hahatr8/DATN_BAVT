<?php

namespace Database\Factories;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    protected $model = Voucher::class;

    public function definition()
    {
        return [
            'e_vorcher' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),  // Mã voucher ngẫu nhiên gồm 10 ký tự
            'quantity' => $this->faker->numberBetween(1, 100),  // Số lượng ngẫu nhiên
            'discount' => $this->faker->numberBetween(5, 50),  // Giảm giá ngẫu nhiên từ 5 đến 50
            'status' => $this->faker->boolean(),  // Trạng thái ngẫu nhiên
            'user_id' => User::factory(),  // ID người dùng ngẫu nhiên từ factory của User
            'product_id' => $this->faker->optional()->randomElement(Product::all()->pluck('id')->toArray()),  // ID sản phẩm ngẫu nhiên từ bảng Product (có thể null)
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),  // Ngày bắt đầu hiệu lực ngẫu nhiên trong tháng vừa qua
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),  // Ngày hết hạn ngẫu nhiên trong tháng tới
        ];
    }
}
