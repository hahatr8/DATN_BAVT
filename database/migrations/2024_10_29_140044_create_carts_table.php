<?php

use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('carts', function (Blueprint $table) {
        $table->id(); // Cột id tự tăng
        $table->foreignIdFor(User::class)->constrained()->onDelete('cascade'); 
        $table->foreignIdFor(ProductSize::class)->constrained()->onDelete('cascade'); 
        $table->integer('quantity'); // Số lượng sản phẩm trong giỏ hàng
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
        Schema::dropIfExists('carts');
    }
}