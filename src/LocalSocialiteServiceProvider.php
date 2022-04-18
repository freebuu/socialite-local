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
        //config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/local-socialite.php' => $this->app->configPath('local-socialite.php'),
            ], 'config');
            // publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('local_socialite'),
              ], 'assets');
        }
        //views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local_socialite');
        //routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/local-socialite.php', 'local-socialite');
        $this->app->alias(SubjectRepository::class, 'local_socialite.subject_repository');
        $this->app->singleton(Interceptor::class, function ($app){
            return new Interceptor(
                $app->make('local_socialite.subject_repository'),
                $app['config']['local-socialite']
            );
        });
        $this->app->extend(Factory::class, function ($factory, $app) {
            $interceptor = $app->make(Interceptor::class);
            $factory = $app->make(LocalSocialiteManager::class);
            $factory->setInterceptor($interceptor);
            return $factory;
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
