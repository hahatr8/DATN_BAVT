<?php

<<<<<<< HEAD


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\BrandController as ClientBrandController;
=======
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


<<<<<<< HEAD

// Giỏ hàng
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

// Áp dụng voucher
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
=======
// Route Categories
Route::resource('categories', CategoryController::class);

// Route Sản Phẩm (Product Routes)
Route::prefix('products')
    ->as('products.')
    ->group(function () {
        Route::get('/',                 [ProductController::class, 'index'])->name('index');
        Route::get('/create',           [ProductController::class, 'create'])->name('create');
        Route::post('/store',           [ProductController::class, 'store'])->name('store');
        Route::get('/show/{id}',        [ProductController::class, 'show'])->name('show');
        Route::get('{id}/edit',         [ProductController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('{id}',           [ProductController::class, 'destroy'])->name('destroy'); // Sửa ở đây
    });
    Route::resource('brands', BrandController::class);

>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb

