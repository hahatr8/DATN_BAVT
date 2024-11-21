<?php

use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\HomeController;
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
