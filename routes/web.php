<?php



use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
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

Route::get('/', function () {
    return view('client.index');
});
Route::get('/', [ProductController::class,'index'])->name('home');


Route::get('/list-product',[ProductController::class,'list'])->name('list-product');

Route::get('/product/{id}', [ProductController::class, 'productDetail'])->name('product_detail');


// Giỏ hàng
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');


// Áp dụng voucher
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');