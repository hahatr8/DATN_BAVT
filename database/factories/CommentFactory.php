<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->text(200), // Nội dung bình luận, sử dụng faker để tạo text ngẫu nhiên
            'status' => $this->faker->boolean(),
            'user_id' => User::inRandomOrder()->first()->id, // Lấy ngẫu nhiên user_id từ bảng users
            'product_id' => Product::inRandomOrder()->first()->id, // Lấy ngẫu nhiên product_id từ bảng products
            'blog_id' => Blog::inRandomOrder()->first()->id,
        ];
    }
}
