<?php

namespace App\Providers;

use App\Models\RestaurantCallback;
use App\Observers\RestaurantCallbackObserver;
use Illuminate\Support\ServiceProvider;

class ObserverProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        RestaurantCallback::observe(RestaurantCallbackObserver::class);

    }
}
