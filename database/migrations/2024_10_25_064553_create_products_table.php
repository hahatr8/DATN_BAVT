<?php

<<<<<<< HEAD
use App\Models\Brand;
use App\Models\Category;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->string('name'); // Tên sản phẩm
<<<<<<< HEAD
            $table->string('description')->nullable(); // Mô tả sản phẩm
            $table->integer('view'); // Mô tả sản phẩm
            $table->integer('price'); // Giá sản phẩm 
            $table->boolean('status')->default(false);
            $table->text('content')->nullable(); // Mô tả sản phẩm
            $table->foreignIdFor(Brand::class)->constrained(); 
=======
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm 
            $table->integer('quantity'); // Số lượng sản phẩm 
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng categories
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
        Schema::dropIfExists('products');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
