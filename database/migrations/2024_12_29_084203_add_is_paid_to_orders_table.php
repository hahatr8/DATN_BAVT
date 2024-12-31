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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_paid') // Thêm cột trạng thái thanh toán
                ->default(false)      // Giá trị mặc định là `false` (chưa thanh toán)
                ->after('status_payment'); // Đặt cột sau `status_payment`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('is_paid'); // Xóa cột `is_paid`
            });
        });
    }
};
