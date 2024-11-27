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
            $table->string('name')->unique(); // Tên hãng nước hoa
            $table->string('founded_year')->unique(); // Năm thành lập của hãng
            $table->string('country')->unique(); // Tên quốc gia nào đó
            $table->text('description')->nullable(); // Mô tả thương hiệu (có thể để trống)
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
