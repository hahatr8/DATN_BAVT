<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\BlogController;
<<<<<<< HEAD
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\ForgetpasswordController;
=======
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\ForgetpasswordController;
use App\Http\Middleware\VerifyCsrfToken;
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // Giỏ hàng
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'showCart'])->name('show');
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


Route::prefix('client')
    ->as('client.')
<<<<<<< HEAD
    ->group(function () {   
        Route::get('/', function () {
            return view('client.index');
        });
=======
    ->group(function () {
        Route::get('/', [HomeController::class, 'home']);
        Route::get('myaccount/{id}', [HomeController::class, 'myAccount'])->name('myaccount');
        Route::get('myaccountEdit/{id}', [ClientUserController::class, 'edit'])->name('myaccountEdit');
        Route::put('myaccountUpdate/{id}', [ClientUserController::class, 'update'])->name('myaccountUpdate');

        Route::prefix('address')
            ->as('address.')
            ->group(function () {

                Route::get('createadd/{id}', [AddressController::class, 'createadd'])->name('createadd');
                Route::post('storeadd/{id}', [AddressController::class, 'storeadd'])->name('storeadd');
                Route::get('edit/{id}', [AddressController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [AddressController::class, 'update'])->name('update');
            });
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90


        //link den trang blog
        Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
        Route::get('/blogDetail/{blog}', [BlogController::class, 'blogDetail'])->name('blogDetail');
<<<<<<< HEAD
        Route::get('myaccount/{id}', [HomeController::class, 'myAccount'])->name('myaccount');
        Route::get('myaccountEdit/{id}', [ClientUserController::class, 'edit'])->name('myaccountEdit');
        Route::put('myaccountUpdate/{id}', [ClientUserController::class, 'update'])->name('myaccountUpdate');

        Route::prefix('address')
            ->as('address.')
            ->group(function () {

                Route::get('createadd/{id}', [AddressController::class, 'createadd'])->name('createadd');
                Route::post('storeadd/{id}', [AddressController::class, 'storeadd'])->name('storeadd');
                Route::get('edit/{id}', [AddressController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [AddressController::class, 'update'])->name('update');
            });

            // Route::prefix('orders')->name('client.orders.')->group(function () {
            //     Route::get('/', [OrderController::class, 'index'])->name('index'); // Danh sách đơn hàng
            //     Route::get('/{id}', [OrderController::class, 'show'])->where('id', '[0-9]+')->name('show'); // Chi tiết đơn hàng
            //     Route::put('/{id}/cancel', [OrderController::class, 'cancelOrder'])->where('id', '[0-9]+')->name('cancel'); // Hủy đơn hàng
            //     Route::put('/{id}/return', [OrderController::class, 'requestReturn'])->where('id', '[0-9]+')->name('return'); // Yêu cầu trả hàng
            // });
            
            
            Route::get('/filter-by-brand', [ProductController::class, 'filterByBrand'])->name('filterByBrand');
            Route::get('/brand/{id}', [HomeController::class, 'brandproduct'])->name('brand');
            Route::get('/brands', [BrandController::class, 'index'])->name('client.brands.index');

    });
//    quản lý đơn hàng
    // Route::middleware(['auth'])->prefix('orders')->name('client.orders.')->group(function () {
    //     // Danh sách đơn hàng
    //     Route::get('/', [OrderController::class, 'index'])->name('index');
    
    //     // Chi tiết đơn hàng
    //     Route::get('/{id}', [OrderController::class, 'show'])
    //         ->where('id', '[0-9]+')
    //         ->name('show');
    
    //     // Hủy đơn hàng
    //     Route::put('/{id}/cancel', [OrderController::class, 'cancelOrder'])
    //         ->where('id', '[0-9]+')
    //         ->name('cancel');
    
    //     // Yêu cầu trả hàng
    //     Route::put('/{id}/return', [OrderController::class, 'requestReturn'])
    //         ->where('id', '[0-9]+')
    //         ->name('return');
    // }); 
    
  
=======


    });

>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
Route::get('login', [AuthController::class, 'showFormLogin']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('forgetpassword', [ForgetpasswordController::class, 'forgetpassword'])->name('forgetpassword');
Route::post('forgetpasswordPost', [ForgetpasswordController::class, 'forgetpasswordPost'])->name('forgetpasswordPost');

Route::get('restpassword/{token}', [ForgetpasswordController::class, 'restpassword'])->name('restpassword');
Route::post('restpasswordPost', [ForgetpasswordController::class, 'restpasswordPost'])->name('restpasswordPost');


Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
<<<<<<< HEAD

    
=======
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
