<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Traits\NavigationTrait;

class ViewComposerServiceProvider extends ServiceProvider
{

    use NavigationTrait;

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with($this->getNavigationData());
        });
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
}
