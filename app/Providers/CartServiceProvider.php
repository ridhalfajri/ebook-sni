<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $cart_count = 0;

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::user()->id)->first();
                if ($cart) {
                    $cart_count = CartItem::where('cart_id', $cart->id)->count();
                }
            }
            $categories_header = Category::select('id','name')->get();
            $view->with('cart_count', $cart_count);
            $view->with('categories_header', $categories_header);
        });
    }
}
