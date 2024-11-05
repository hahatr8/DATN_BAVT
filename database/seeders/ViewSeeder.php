<?php

namespace Database\Seeders;

use App\Models\View;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        View::factory()->count(5)->create();
    }
}
