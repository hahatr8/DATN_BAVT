<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $categories = Category::query()->where('status', 1)->orderBy('display_order', 'asc')->paginate(5);
        view()->share('globalCategories', $categories);

        // Sử dụng view composer để chia sẻ biến với tất cả các view
        View::composer('*', function ($view) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            
            $totalAmount = $cartItems->sum(function($item) {
                $productPrice = $item->productSize->product->price + $item->productSize->price;
                return $productPrice * $item->quantity;
            });

            $discount = 0;
            $finalAmount = $totalAmount;

            $view->with('cartItems', $cartItems)
                 ->with('totalAmount', $totalAmount)
                 ->with('finalAmount', $finalAmount)
                 ->with('discount', $discount);
        });

        Paginator::useBootstrapFive();
    }
}

