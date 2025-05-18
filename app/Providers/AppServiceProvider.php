<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Category;

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
        // Share brands and categories with all views
        View::composer('*', function ($view) {
            $view->with([
                'brands' => Brand::orderBy('name')->get(),
                'categories' => Category::orderBy('name')->get(),
                'cartCount' => auth()->check() ? auth()->user()->cart?->items()->sum('quantity') : 0
            ]);
        });
    }
}
