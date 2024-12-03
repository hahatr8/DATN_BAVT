<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\ForgetpasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')
    ->as('client.')
    ->group(function () {   
        Route::get('/', function () {
            return view('client.index');
        });

        //link den trang home
        Route::get('/', [HomeController::class, 'home'])->name('home');

        //link den trang blog
        Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
        Route::get('/blogDetail/{blog}', [BlogController::class, 'blogDetail'])->name('blogDetail');
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
    
  
Route::get('login', [AuthController::class, 'showFormLogin']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('forgetpassword', [ForgetpasswordController::class, 'forgetpassword'])->name('forgetpassword');
Route::post('forgetpasswordPost', [ForgetpasswordController::class, 'forgetpasswordPost'])->name('forgetpasswordPost');

Route::get('restpassword/{token}', [ForgetpasswordController::class, 'restpassword'])->name('restpassword');
Route::post('restpasswordPost', [ForgetpasswordController::class, 'restpasswordPost'])->name('restpasswordPost');


Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    