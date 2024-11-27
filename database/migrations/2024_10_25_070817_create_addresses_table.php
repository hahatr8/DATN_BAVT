<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->string('recipient_name'); // Tên người nhận
            $table->string('phone_number'); // Số điện thoại người nhận
            $table->string('street_address'); // Địa chỉ đường
            $table->string('city'); // Thành phố
            $table->string('state'); // Tiểu bang hoặc tỉnh
            $table->string('postal_code'); // Mã bưu điện
            $table->string('country'); // Quốc gia
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
        Schema::dropIfExists('addresses');
    }
}
