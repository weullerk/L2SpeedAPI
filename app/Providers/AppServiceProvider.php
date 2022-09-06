<?php

namespace App\Providers;

use App\Services\AccountServices;
use App\Services\CastlesServices;
use App\Services\HeroesServices;
use App\Services\RankingsServices;
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

        $this->app->scoped(RankingsServices::class, function () {
            return new RankingsServices();
        });

        $this->app->scoped(HeroesServices::class, function () {
            return new HeroesServices();
        });

        $this->app->scoped(CastlesServices::class, function () {
            return new CastlesServices();
        });
    }
}
