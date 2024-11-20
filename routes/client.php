<?php

use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('client')
    ->as('client.')
    ->group(function () {
        Route::get('/', function () {
            return view('client.index');
        });

        Route::get('/', [HomeController::class, 'home'])->name('home');

    });
