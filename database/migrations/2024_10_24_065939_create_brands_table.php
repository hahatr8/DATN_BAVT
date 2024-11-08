<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->string('name')->unique(); // Tên hãng nước hoa (duy nhất)
            $table->string('country'); // Tên quốc gia (không duy nhất)
            $table->text('description')->nullable(); // Mô tả thương hiệu (có thể để trống)
            $table->boolean('status')->default(false);
            $table->string('logo')->nullable(); // Đường dẫn đến logo của thương hiệu (có thể để trống)
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
        Schema::dropIfExists('brands');
    }
}