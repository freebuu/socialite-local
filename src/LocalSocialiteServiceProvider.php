<?php

namespace Kirbykot\LocalSocialite;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kirbykot\LocalSocialite\Socialite\LocalSocialiteManager;
use Laravel\Socialite\Contracts\Factory;

class LocalSocialiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local_socialite');
        //routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    public function register()
    {
        //TODO конфиг
        $this->app->extend(Factory::class, function ($factory, $app) {
            return new LocalSocialiteManager($app, $factory, true);
        });
    }

    private function routeConfiguration(): array
    {
        return [
            'prefix' => 'local_socialite',
            'as' => 'local_socialite.',
            'namespace' => 'Kirbykot\LocalSocialite\Controllers'
        ];
    }
}