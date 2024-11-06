<?php

use App\Models\Order;
use App\Models\ProductSize;
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
        $table->foreignIdFor(Order::class)->constrained();
        $table->foreignIdFor(ProductSize::class)->constrained();
        $table->integer('quantity'); // Số lượng sản phẩm
        $table->integer('price'); // Số lượng sản phẩm
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
        Schema::dropIfExists('order_items');
    }
}