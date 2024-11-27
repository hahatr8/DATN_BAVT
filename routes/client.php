<?php

use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\BrandController as ClientBrandController;
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
       

       
    });
    Route::get('/filter-by-brand', [ProductController::class, 'filterByBrand'])->name('filterByBrand');
    Route::get('/brand/{id}', [HomeController::class, 'brandproduct'])->name('brand');
   
    Route::prefix('orders')->middleware('auth')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('client.orders.index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('client.orders.show');
        Route::put('/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('client.orders.cancel');
        Route::put('/{id}/return', [OrderController::class, 'requestReturn'])->name('client.orders.return');
    });
    
