<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->decimal('total_price', 10, 2); // Tổng giá trị của đơn hàng
            $table->string('status')->default('pending'); // Trạng thái của đơn hàng (pending, shipped, completed, etc.)
            $table->text('shipping_address'); // Địa chỉ giao hàng
            $table->string('payment_method'); // Phương thức thanh toán (ví dụ: credit card, PayPal)
            $table->timestamp('order_date'); // Ngày đặt hàng
            $table->string('price_total'); // Tổng Giá
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
