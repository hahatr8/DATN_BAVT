<?php

<<<<<<< HEAD
use App\Models\Blog;
=======
<<<<<<< HEAD
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
use App\Models\Product;
use App\Models\User;
=======
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
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
<<<<<<< HEAD
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id(); // Cột id tự tăng
        $table->text('content'); // Nội dung bình luận
        $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
        $table->foreignIdFor(Product::class)->constrained()->nullable()->onDelete('cascade');
        $table->foreignIdFor(Blog::class)->constrained()->nullable()->onDelete('cascade');
        $table->boolean('status')->default(false);
        $table->softDeletes();
        $table->timestamps(); // Tạo cột created_at và updated_at
    });
}

=======
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Cột id tự tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
            $table->text('comment'); // Nội dung bình luận
            $table->integer('rating')->nullable(); // Đánh giá của người dùng (nếu có)
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 173b31453d82474926536b290e188244a16d9ac1
