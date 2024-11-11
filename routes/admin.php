<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

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
    });
