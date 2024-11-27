<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->string('size'); // Kích thước của sản phẩm (ví dụ: S, M, L hoặc 50ml, 100ml, ...)
            $table->decimal('price', 10, 2); // Giá của sản phẩm tương ứng với kích thước
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
        Schema::dropIfExists('product_sizes');
    }
}
