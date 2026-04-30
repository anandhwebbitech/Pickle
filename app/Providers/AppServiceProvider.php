<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        //
            Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
            $categories = cache()->remember('nav_categories', 60, function () {

                return Category::with('subcategories') // ✅ important
                    ->where('status', 1)
                    ->get();
            });
            $cartCount = 0;
            $wishlistCount = 0;
            // dd($categories);
            if (Auth::check()) {

                $user = Auth::user();

                // Cart Count (DB)
                $cartCount = Cart::where('user_id', $user->id)
                                ->where('status', 1)
                                ->sum('quantity');

                // Wishlist Count (SESSION based like your logic)
                $userKey = 'wishlist_' . $user->id;
                $wishlist = session()->get($userKey, []);
                $wishlistCount = count($wishlist);

            } else {

                // Guest Cart (SESSION)
                $guestCart = session()->get('guest_cart', []);
                $cartCount = collect($guestCart)->sum('quantity');

                // Guest Wishlist
                $guestWishlist = session()->get('guest_wishlist', []);
                $wishlistCount = count($guestWishlist);
            }
            $view->with([
                'categories'     => $categories,
                'cartcount'      => $cartCount,
                'wishlistCount'  => $wishlistCount,
            ]);
            // $view->with('categories', $categories);
        });
        
    }
}
