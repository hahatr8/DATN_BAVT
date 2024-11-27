<?php

<<<<<<< HEAD
use App\Models\Order;
use App\Models\ProductSize;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
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
<<<<<<< HEAD
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id(); // Cột id tự tăng
        $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');
        $table->foreignIdFor(ProductSize::class)->constrained()->onDelete('cascade');
        $table->integer('quantity'); // Số lượng sản phẩm
        $table->integer('price'); // Số lượng sản phẩm
        $table->timestamps(); // Tạo cột created_at và updated_at
    });
}


=======
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->integer('quantity'); // Số lượng sản phẩm trong đơn hàng
            $table->decimal('price', 10, 2); // Giá sản phẩm tại thời điểm đặt hàng
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
