<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Seeder cho bảng Products
public function run()
{
    Product::factory()->count(100)->create(); // Thêm 10 sản phẩm vào bảng products
}

}
