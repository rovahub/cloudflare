<?php

namespace Rovahub\Cloudflare\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rovahub\Cloudflare\Http\Middleware\ForceJsonResponseMiddleware;

class CloudflareServiceProvider extends ServiceProvider
{
    protected $app;

    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();

        if (!config('cloudflare.enabled')) {
            return;
        }

        Route::middlewareGroup('cloudflare', config('cloudflare.middleware', []));
        Route::middlewareGroup('cloudflare:api', [
            ForceJsonResponseMiddleware::class
        ]);

        $this->registerRoutes();
        $this->registerMigrations();

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cloudflare');
    }

    public function register()
    {
        File::requireOnce(__DIR__ . '/../../helpers/common.php');
        $this->mergeConfigFrom(__DIR__ . '/../../config/cloudflare.php', 'cloudflare');
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
            Route::group($this->routeConfiguration(true), function () {
                $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
            });
        });
    }

    private function routeConfiguration($api = false)
    {
        $routeConfigs = [
            'namespace' => 'Rovahub\Cloudflare\Http\Controllers',
            'prefix' => $api ?  'api' : config('cloudflare.path'),
            'middleware' => $api ? 'cloudflare:api' : 'cloudflare'
        ];
        if (!$api) {
            return array_merge($routeConfigs, ['domain' => config('cloudflare.domain', null)]);
        }
        return $routeConfigs;
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'migrations');
            $this->publishes([__DIR__ . '/../../config/cloudflare.php' => config_path('cloudflare.php')], 'config');
        }
    }

    private function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }
}
