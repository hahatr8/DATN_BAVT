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
        Route::prefix('vouchers')
            ->as('vouchers.')
            ->group(function () {
                Route::get('/', [VoucherController::class, 'index'])->name('index');
                Route::get('/trash', [VoucherController::class, 'trash'])->name('trash');
                Route::post('/restore/{id}', [VoucherController::class, 'restore'])->name('restore');
                Route::get('/create', [VoucherController::class, 'create'])->name('create');
                Route::post('/store', [VoucherController::class, 'store'])->name('store');
                Route::get('/{voucher}/edit', [VoucherController::class, 'edit'])->name('edit');
                Route::put('/{voucher}', [VoucherController::class, 'update'])->name('update');
                Route::get('/{voucher}', [VoucherController::class, 'destroy'])->name('destroy');
            });
        //comment
        Route::prefix('comments')
            ->as('comments.')
            ->group(function () {
                Route::get('/', [CommentController::class, 'index'])->name('index');
                Route::get('/trash', [CommentController::class, 'trash'])->name('trash');
                Route::post('/restore/{id}', [CommentController::class, 'restore'])->name('restore');
                Route::get('/create', [CommentController::class, 'create'])->name('create');
                Route::post('/store', [CommentController::class, 'store'])->name('store');
                Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
                Route::get('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
            });

        // Blog
        Route::resource('blogs', BlogController::class);

        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

        // Cập nhật trạng thái đơn hàng
        Route::put('/orders/{order}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
