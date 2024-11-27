<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\VoucherController;

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


    });
// Voucher routes
Route::get('vouchers', [VoucherController::class, 'voucherList'])->name('client.vouchers.list');
Route::get('vouchers/{voucher}', [VoucherController::class, 'voucherDetail'])->name('client.vouchers.detail');

// Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('blogs/{id}', [BlogController::class, 'showBlog'])->name('blogs.show');
Route::post('blogs/{blog}/comments', [CommentController::class, 'store'])->name('comment.store');
