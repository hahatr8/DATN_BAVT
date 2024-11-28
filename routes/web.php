<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\CartController;
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
        Route::resource('brands', BrandController::class);
    });
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

// Áp dụng voucher
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


   


