<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\ForgetpasswordController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // Giỏ hàng
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'showCart'])->name('show');
        Route::post('/add', [CartController::class, 'addToCart'])->name('add');
        Route::post('/apply-voucher', [CartController::class, 'applyVoucher'])->name('applyVoucher');
        Route::put('/update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

        Route::post('/add-address', [CartController::class, 'addAddress'])->name('addAddress');

        // Route để xử lý đặt hàng
        Route::post('/store-order', [CartController::class, 'storeOrder'])->name('storeOrder');

        Route::get('/payment', [CartController::class, 'payment'])->name('payment');

        Route::get('/order-success', [CartController::class, 'orderSuccess'])->name('order.success');
    });
});
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::prefix('client')
    ->as('client.')
    ->group(function () {
        Route::delete('/remove/{id}', [HomeController::class, 'remove'])->name('remove');
        Route::get('myaccount/{id}', [HomeController::class, 'myAccount'])->name('myaccount');
        Route::get('myaccountEdit/{id}', [ClientUserController::class, 'edit'])->name('myaccountEdit');
        Route::put('myaccountUpdate/{id}', [ClientUserController::class, 'update'])->name('myaccountUpdate');

        Route::get('/list-product', [ProductController::class, 'list'])->name('list-product');
        Route::get('/product/{id}', [ProductController::class, 'productDetail'])->name('product_detail');
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');


        Route::prefix('address')
            ->as('address.')
            ->group(function () {

                Route::get('createadd/{id}', [AddressController::class, 'createadd'])->name('createadd');
                Route::post('storeadd/{id}', [AddressController::class, 'storeadd'])->name('storeadd');
                Route::get('edit/{id}', [AddressController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [AddressController::class, 'update'])->name('update');
            });


        //link den trang blog
        Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
        Route::get('/blogDetail/{blog}', [BlogController::class, 'blogDetail'])->name('blogDetail');

        //gửi bình luận
        Route::post('blog/comment/{blogID}', [BlogController::class, 'post_comment'])->name('comment.store');

        // Product routes
        Route::get('/product', [ProductController::class, 'product'])->name('product.index');

        // Product comments
        Route::post('/product/comment/{id}', [ProductController::class, 'post_comments'])->name('product.comment');
    });

Route::get('login', [AuthController::class, 'showFormLogin']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('forgetpassword', [ForgetpasswordController::class, 'forgetpassword'])->name('forgetpassword');
Route::post('forgetpasswordPost', [ForgetpasswordController::class, 'forgetpasswordPost'])->name('forgetpasswordPost');

Route::get('restpassword/{token}', [ForgetpasswordController::class, 'restpassword'])->name('restpassword');
Route::post('restpasswordPost', [ForgetpasswordController::class, 'restpasswordPost'])->name('restpasswordPost');


Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/brand/{id}', [ProductController::class, 'showProducts'])->name('brand.products');


// Quản lý đơn hàng
Route::middleware(['auth'])->prefix('orders')->name('client.orders.')->group(function () {
    // Danh sách đơn hàng
    Route::get('/', [OrderController::class, 'index'])
        ->name('index');

    // Chi tiết đơn hàng
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('show');

    // Hủy đơn hàng
    Route::put('/{id}/cancel', [OrderController::class, 'cancelOrder'])
        ->whereNumber('id') // Ràng buộc chỉ cho phép số
        ->name('cancel');

    // Yêu cầu trả hàng (Route bạn cần thêm vào)
    Route::put('/{id}/return', [OrderController::class, 'requestReturn'])
        ->whereNumber('id') // Ràng buộc chỉ cho phép số
        ->name('return'); // Đảm bảo route này có tên là 'client.orders.return'

    // Phê duyệt yêu cầu trả hàng
    Route::put('/{id}/approve-return', [OrderController::class, 'approveReturn'])
        ->whereNumber('id')
        ->name('approveReturn');

    // Từ chối yêu cầu trả hàng
    Route::put('/{id}/reject-return', [OrderController::class, 'rejectReturn'])
        ->whereNumber('id')
        ->name('rejectReturn');

    // Chấp nhận yêu cầu trả hàng
    Route::put('/{id}/accept-return', [OrderController::class, 'acceptReturn'])
        ->whereNumber('id')
        ->name('acceptReturn');

    // Lịch sử trả hàng (Tùy chọn, nếu cần)
    Route::get('/returns', [OrderController::class, 'returnHistory'])
        ->name('returns');
});
