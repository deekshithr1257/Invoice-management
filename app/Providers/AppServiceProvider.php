<?php

namespace App\Providers;

use App\Store;
use Illuminate\Support\Facades\Auth;
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

            $user = Auth::user(); // Get the authenticated user
            $stores = collect();
            if(isset($user->roles)){
                if ($user->roles->contains(1)) { 
                    // If the user is an admin, fetch all active stores
                    $stores = Store::where('status', true)->get();
                } else { 
                    // If the user is a store manager, fetch only their assigned stores
                    $stores = $user->stores()->where('status', true)->get();
                }
            }
            if($stores->isNotEmpty() && !session()->has('selected_store_id')){
                session(['selected_store_id' => $stores[0]->id]);
            }
            // Share the stores with the view
            $view->with('stores', $stores);
        });
    }
}
