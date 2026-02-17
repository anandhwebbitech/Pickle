<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use Illuminate\Support\Facades\View;


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
                return Category::where('status', 1)->get();
            });
    
            $view->with('categories', $categories);
        });
        
    }
}
