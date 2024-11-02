<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id(); // Cột id tự tăng
        $table->text('content'); // Nội dung bình luận
        $table->foreignIdFor(User::class)->constrained();
        $table->foreignIdFor(Product::class)->constrained();
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
        Schema::dropIfExists('comments');
    }
}
