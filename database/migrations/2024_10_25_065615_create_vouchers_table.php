<?php

use App\Models\Product;
use App\Models\User;
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
            $table->string('E_vorcher')->unique(); // Mã voucher (duy nhất)
            $table->double('quantity'); // Mã voucher (duy nhất)
            $table->integer('discount');
            $table->boolean('status')->default(false);
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Product::class)->nullable()->constrained()->onDelete('cascade');
            $table->date('start_date'); // Ngày bắt đầu hiệu lực
            $table->date('end_date'); // Ngày hết hạn
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
        Schema::dropIfExists('vouchers');
    }
}
