<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashBoardController::class, 'admin']);

        // route category
        Route::prefix('category')
            ->as('category.')
            ->group(function () {
                Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
                Route::post('/{id}', [CategoryController::class, 'restore'])->name('restore');
                Route::get('/{category}', [CategoryController::class, 'softDestruction'])->name('softDestruction');
            });
        Route::resource('categories', CategoryController::class);


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
        Route::resource('brands', BrandController::class);
    });

