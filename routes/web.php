<?php
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\ProductController;
<<<<<<< HEAD
=======
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
=======
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be
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
    return view('client.home');
});
Route::get('/', [ProductController::class,'index'])->name('home');


Route::get('/list-product',[ProductController::class,'list'])->name('list-product');

Route::get('/product/{id}', [ProductController::class, 'productDetail'])->name('product_detail');

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

<<<<<<< HEAD
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
=======
// Áp dụng voucher
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


   
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be


// Áp dụng voucher
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.applyVoucher');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
<<<<<<< HEAD

Route::get('/brands', [BrandController::class, 'index'])->name('client.brands.index');
   // web.php
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');



// Quản lý đơn hàng
Route::middleware(['auth'])->prefix('orders')->name('client.orders.')->group(function () {
    // Danh sách đơn hàng
    Route::get('/', [OrderController::class, 'index'])
        ->name('index');

    // Chi tiết đơn hàng
    Route::get('/{id}', [OrderController::class, 'show'])
        ->whereNumber('id') // Ràng buộc chỉ cho phép số
        ->name('show');

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






    

=======
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
