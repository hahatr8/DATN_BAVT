<?php

namespace Database\Seeders;

use App\Models\ProductImg;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductImg::factory()->count(5)->create();
    }
}
