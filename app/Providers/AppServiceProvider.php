<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CustomAuthService;
use App\Services\AuthentificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomAuthService::class, function () {
            return new AuthentificationService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
