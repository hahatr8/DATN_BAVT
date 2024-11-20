<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('address'); // Tên người nhận
            $table->string('city'); // Tên người nhận
            $table->string('District'); // Số điện thoại người nhận
            $table->string('country'); // Địa chỉ đường
            $table->boolean('is_default')->default(false);
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