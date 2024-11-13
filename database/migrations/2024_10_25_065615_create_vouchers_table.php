<?php

<<<<<<< HEAD
use App\Models\Product;
use App\Models\User;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
<<<<<<< HEAD
            $table->string('E_vorcher')->unique(); // Mã voucher (duy nhất)
            $table->double('quantity'); // Mã voucher (duy nhất)
            $table->integer('discount');
            $table->boolean('status')->default(false);
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Product::class)->nullable()->constrained();
            $table->date('start_date'); // Ngày bắt đầu hiệu lực
            $table->date('end_date'); // Ngày hết hạn
=======
            $table->string('code')->unique(); // Mã voucher (duy nhất)
            $table->date('start_date'); // Ngày bắt đầu hiệu lực
            $table->date('end_date'); // Ngày hết hạn
            $table->integer('usage_limit')->nullable(); // Giới hạn số lần sử dụng
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
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
        Schema::dropIfExists('vouchers');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
