<?php
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        });

        // Category
        Route::resource('categories', CategoryController::class);

        // Blog
        Route::resource('blogs', BlogController::class);

        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Voucher
        Route::prefix('vouchers')
            ->as('vouchers.')
            ->group(function () {
                Route::get('/create',         [VoucherController::class, 'create'])->name('create');
                Route::post('/store',         [VoucherController::class, 'store'])->name('store');
                Route::get('/show/{voucher}', [VoucherController::class, 'show'])->name('show');
                Route::get('{voucher}/edit',  [VoucherController::class, 'edit'])->name('edit');
                Route::put('{voucher}',       [VoucherController::class, 'update'])->name('update');
                Route::delete('{voucher}',    [VoucherController::class, 'destroy'])->name('destroy');
            });

        // Comment
        Route::prefix('comments')
            ->as('comments.')
            ->group(function () {
                Route::get('/',               [CommentController::class, 'index'])->name('index');
                Route::post('/store',         [CommentController::class, 'store'])->name('store');
                Route::delete('{comment}',    [CommentController::class, 'destroy'])->name('destroy');
            });
    });
