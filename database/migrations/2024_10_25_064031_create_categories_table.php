<?php

<<<<<<< HEAD
use App\Models\Category;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
<<<<<<< HEAD
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_order')->nullable(); // Sửa lỗi từ `display_oder` thành `display_order`
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

=======
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột id tự tăng
            $table->string('name'); // Cột tên của category
            $table->string('Display_oder')->nullable(); // Thứ tự oder
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
