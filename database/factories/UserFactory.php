<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),  // Tên ngẫu nhiên
            'email' => $this->faker->unique()->safeEmail(),  // Email duy nhất
            'password' => Hash::make('password'),  // Mật khẩu mặc định
            'img' => $this->faker->imageUrl(640, 480, 'user'),  // URL ảnh giả lập
            'phone' => $this->faker->phoneNumber(),  // Số điện thoại ngẫu nhiên
            'xu' => $this->faker->numberBetween(0, 1000),  // Giá trị xu ngẫu nhiên
            'type' => $this->faker->randomElement([User::TYPE_ADMIN, User::TYPE_MEMBER]),  // Loại người dùng ngẫu nhiên
            'status' => $this->faker->boolean(),  // Trạng thái ngẫu nhiên
            'remember_token' => Str::random(10),  // Token ngẫu nhiên
        ];
    }
}
