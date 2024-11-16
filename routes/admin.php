<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\ForgetpasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('auth.admin')->group(function () {
        Route::prefix('admin')
            ->as('admin.')
            ->group(function () {
                Route::get('/', function () {
                    return view('admin.dashboard');
                });

                // Danh sách đơn hàng
                Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

                Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

                // Cập nhật trạng thái đơn hàng
                Route::put('/orders/{order}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

                Route::prefix('user')
                    ->as('user.')
                    ->group(function () {

                        Route::get('index', [UserController::class, 'index'])->name('index');
                        Route::get('create', [UserController::class, 'create'])->name('create');
                        Route::get('detail/{id}', [UserController::class, 'detail'])->name('detail');
                        Route::get('createadd/{id}', [UserController::class, 'createadd'])->name('createadd');
                        Route::post('store', [UserController::class, 'store'])->name('store');
                        Route::post('storeadd/{id}', [UserController::class, 'storeadd'])->name('storeadd');
                        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
                        Route::put('update/{id}', [UserController::class, 'update'])->name('update');
                        Route::delete('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
                        Route::get('empower/{id}', [UserController::class, 'empower'])->name('empower');
                    });
            });
    });
});


Route::prefix('client')
    ->as('client.')
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
