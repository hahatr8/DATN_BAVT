<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {


    //link den trang hom

    //link den trang blog

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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/blog', [ClientBlogController::class, 'blog'])->name('blog');
Route::get('/blogDetail/{blog}', [ClientBlogController::class, 'blogDetail'])->name('blogDetail');
