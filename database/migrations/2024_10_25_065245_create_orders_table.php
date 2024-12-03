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
<<<<<<< HEAD
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
=======
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Address::class)->constrained()->onDelete('cascade');
            $table->string('status_order')->default(\App\Models\Order::STATUS_ORDER_PENDING);
            $table->string('status_payment')->default(\App\Models\Order::STATUS_PAYMENT_MOMO);
            $table->double('total_price', 15, 2);
            $table->softDeletes();
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90


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
