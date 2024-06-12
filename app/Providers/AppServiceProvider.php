<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Platform;
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
        View::composer('User.layout.footer', function ($view) {
            $view->with('contact', Contact::first());
        });

        View::composer('User.layout.Nav', function ($view) {
            $categories = Category::with('subcategories')->get();
            $brands = Brand::all();
            $platforms = Platform::all();

            $view->with(compact('categories', 'brands', 'platforms'));
        });
        
    }
}