<?php

<<<<<<< HEAD
use App\Models\Product;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id(); // ID tự động tăng
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade'); 
            $table->string('variant'); // Kích thước sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->string('img'); 
            $table->double('quantity');
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps(); // Cột created_at và updated_at
=======
            $table->id(); // Cột id tự tăng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->string('size'); // Kích thước của sản phẩm (ví dụ: S, M, L hoặc 50ml, 100ml, ...)
            $table->decimal('price', 10, 2); // Giá của sản phẩm tương ứng với kích thước
            $table->timestamps(); // Tạo cột created_at và updated_at
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sizes');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
