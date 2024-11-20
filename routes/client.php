<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\VoucherController;

Route::prefix('client')
    ->as('client.')
    ->group(function () {
        Route::get('/', function () {
            return view('client.index');
        });

        Route::get('/', [HomeController::class, 'home'])->name('home');

    });
// Voucher routes
Route::get('vouchers', [VoucherController::class, 'voucherList'])->name('client.vouchers.list');
Route::get('vouchers/{voucher}', [VoucherController::class, 'voucherDetail'])->name('client.vouchers.detail');
