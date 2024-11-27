<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->string('variant_type'); // Loại biến thể (ví dụ: kích thước, màu sắc)
            $table->string('image'); // ảnh sp
            $table->string('variant_value'); // Giá trị của biến thể (ví dụ: đỏ, xanh, 50ml)
            $table->decimal('price', 10, 2)->nullable(); // Giá sản phẩm cho biến thể (nếu có)
            $table->integer('quantity')->default(0); // Số lượng tồn kho cho biến thể này
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
        Schema::dropIfExists('product_variants');
    }
}
