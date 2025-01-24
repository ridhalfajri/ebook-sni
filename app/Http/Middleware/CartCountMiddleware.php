<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\CartItem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart_count = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::user()->id)->first();
            if ($cart) {
                $cart_count = CartItem::where('cart_id', $cart->id)->count();
            }
        }

        // Share the cart count with all views
        view()->share('cart_count', $cart_count);

        return $next($request);
    }
}
