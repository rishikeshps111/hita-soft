<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\WebsiteLock;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \URL::forceScheme('https');
         view()->composer('*', function ($view) {
             $lock = WebsiteLock::first();
            $isEnabled = $lock && $lock->is_enabled;
            $allowedPasscode = $lock->passcode; // your passcode
            $exceptRoutes = ['verify-passcode'];
            
    
            if (!Session::has('website_unlocked') && $isEnabled && !in_array(Route::currentRouteName(), $exceptRoutes)) {
                View::share('requirePasscode', true);
            } else {
                View::share('requirePasscode', false);
            }
        });
        
       
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
