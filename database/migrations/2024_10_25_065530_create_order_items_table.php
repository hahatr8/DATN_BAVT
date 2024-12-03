<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->integer('quantity'); // Số lượng sản phẩm trong đơn hàng
            $table->decimal('price', 10, 2); // Giá sản phẩm tại thời điểm đặt hàng
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }
<<<<<<< HEAD
=======
            $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(ProductSize::class)->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->integer('price'); // Số lượng sản phẩm
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }


>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
=======
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
