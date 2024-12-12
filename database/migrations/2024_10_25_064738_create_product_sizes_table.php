<?php

use App\Models\Product;
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
            $table->id(); // ID tự động tăng
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade');
            $table->string('variant'); // Kích thước sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->string('img');
            $table->double('quantity');
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps(); // Cột created_at và updated_at
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
}
