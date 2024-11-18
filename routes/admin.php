<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        });

        // Category
        Route::resource('categories', CategoryController::class);
        //voucher
        Route::resource('vouchers', VoucherController::class);
        //comment
        Route::resource('comments', CommentController::class);

        // Blog
        Route::resource('blogs', BlogController::class);

        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

        // Cập nhật trạng thái đơn hàng
        Route::put('/orders/{order}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
