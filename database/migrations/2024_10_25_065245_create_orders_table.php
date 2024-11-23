<?php

use App\Models\Address;
use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Address::class)->constrained()->onDelete('cascade');
            $table->string('status_order')->default(\App\Models\Order::STATUS_ORDER_PENDING);
            $table->string('status_payment')->default(\App\Models\Order::STATUS_PAYMENT_MOMO);
            $table->double('total_price', 15, 2);
            $table->softDeletes();
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
