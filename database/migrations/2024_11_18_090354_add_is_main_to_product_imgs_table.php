<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_imgs', function (Blueprint $table) {
              // Thêm trường is_main, kiểu boolean
              $table->boolean('is_main')->default(false); // Mặc định là ảnh phụ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_imgs', function (Blueprint $table) {
              // Thêm trường is_main, kiểu boolean
              $table->boolean('is_main')->default(false); // Mặc định là ảnh phụ
        });
    }
};
