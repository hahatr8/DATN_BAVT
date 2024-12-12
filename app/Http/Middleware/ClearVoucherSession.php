<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearVoucherSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu URL không phải cart.show hoặc cart.checkout...
        if (
            !$request->routeIs(
                'cart.show',
                'cart.applyVoucher',
                'cart.updateQuantity',
                'cart.checkout',
                'cart.addAddress',
                'cart.storeOrder',
                'cart.payment'
            )
        ) {
            // Xóa session liên quan đến giỏ hàng
            session()->forget(['appliedVoucher']);
        }

        return $next($request);

    }
}
