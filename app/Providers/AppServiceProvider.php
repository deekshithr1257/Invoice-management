<?php

namespace App\Providers;

use App\Store;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $stores = Store::where('status', true)->get(); // Only active stores
            $view->with('stores', $stores);
        });
    }
}
