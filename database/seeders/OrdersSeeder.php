<?php

namespace Database\Seeders;

use App\Models\Orders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Orders::factory()->count(5)->create();
    }
}
