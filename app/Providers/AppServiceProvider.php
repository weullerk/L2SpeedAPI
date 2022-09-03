<?php

namespace App\Providers;

use App\Services\AccountServices;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->scoped(AccountServices::class, function () {
            return new AccountServices();
        });
    }
}
