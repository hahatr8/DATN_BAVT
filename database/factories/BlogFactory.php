<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->company(),
            'content' => $this->faker->paragraph,
            'img' => $this->faker->imageUrl(640, 480, 'brands', true, 'Faker'),
            'status' => $this->faker->boolean(),
        ];
    }
}
