<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->integer('quantity'); // Số lượng sản phẩm trong giỏ hàng
            $table->decimal('price', 10, 2); // Giá sản phẩm tại thời điểm thêm vào giỏ
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
        Schema::dropIfExists('cart');
    }
}
