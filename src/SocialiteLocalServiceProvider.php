<?php

namespace FreeBuu\SocialiteLocal;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use FreeBuu\SocialiteLocal\Socialite\SocialiteLocalManager;
use Laravel\Socialite\Contracts\Factory;

class SocialiteLocalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/socialite-local.php' => $this->app->configPath('socialite-local.php'),
            ], 'config');
        }
        //views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'socialite_local');
        //routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/socialite-local.php', 'socialite-local');
        $this->app->alias(SubjectRepository::class, 'socialite_local.subject_repository');
        $this->app->singleton(Interceptor::class, function ($app){
            return new Interceptor(
                $app->make('socialite_local.subject_repository'),
                $app['config']['socialite-local']
            );
        });
        $this->app->extend(Factory::class, function ($factory, $app) {
            $interceptor = $app->make(Interceptor::class);
            $factory = $app->make(SocialiteLocalManager::class);
            $factory->setInterceptor($interceptor);
            return $factory;
        });
    }

    private function routeConfiguration(): array
    {
        return [
            'prefix' => 'socialite-local',
            'as' => 'socialite-local.',
            'namespace' => 'FreeBuu\SocialiteLocal\Controllers'
        ];
    }
}
