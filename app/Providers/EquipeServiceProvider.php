<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EquipeService;

class EquipeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\EquipeService', function ($app) {
            return new EquipeService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
