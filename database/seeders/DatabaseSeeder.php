<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GroupSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BlogSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductSizeSeeder::class);
        $this->call(ProductImgSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(CategoryProductSeeder::class);
        $this->call(CommentSeeders::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(ViewSeeder::class);
        $this->call(VoucherSeeder::class);
    }
}
