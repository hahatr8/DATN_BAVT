<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Tạo người dùng ngẫu nhiên từ factory của User
            'address' => $this->faker->address(),  // Địa chỉ ngẫu nhiên
            'city' => $this->faker->city(),  // Thành phố ngẫu nhiên
            'district' => $this->faker->word(),  // Quận ngẫu nhiên
            'country' => $this->faker->country(),  // Quốc gia ngẫu nhiên
            'is_default' => $this->faker->boolean(),  // Trạng thái mặc định ngẫu nhiên
        ];
    }
}

