<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        });

        // route category
        Route::prefix('category')
            ->as('category.')
            ->group(function () {
                Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
                Route::post('/{id}', [CategoryController::class, 'restore'])->name('restore');
                Route::get('/{category}', [CategoryController::class, 'softDestruction'])->name('softDestruction');
            });
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
                Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
                Route::get('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
            });


        // route blog
        Route::prefix('blog')
            ->as('blog.')
            ->group(function () {
                Route::get('/trash', [BlogController::class, 'trash'])->name('trash');
                Route::post('/{id}', [BlogController::class, 'restore'])->name('restore');
                Route::get('/{blog}', [BlogController::class, 'softDestruction'])->name('softDestruction');
            });
        Route::resource('blogs', BlogController::class);


        Route::prefix('products')
            ->as('products.')
            ->group(function () {
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
                Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/store', [ProductController::class, 'store'])->name('store');
                Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
                Route::put('/{product}', [ProductController::class, 'update'])->name('update');
                Route::get('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            });
        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

        Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');

        // Cập nhật trạng thái đơn hàng
        Route::put('/orders/{order}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

