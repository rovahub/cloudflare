<?php

namespace Rovahub\Cloudflare\Providers;

use Illuminate\Support\ServiceProvider;
use File;
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
        ]));
        
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
        });
        Route::group($this->routeConfiguration(true), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
    }
    
    private function routeConfiguration($api = false)
    {
        $routeConfig = [
            'domain' => config('cloudflare.domain', null),
            'namespace' => 'Rovahub\Cloudflare\Http\Controllers',
            'prefix' => config('cloudflare.path'),
        ];
        if(!$api){
           return array_merge($routeConfig, ['middleware' => 'cloudflare']);
        }
        return array_merge($routeConfig, ['middleware' => 'cloudflare:api']);
    }
    
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'migrations');
            $this->publishes([__DIR__ . '/../../config/cloudflare.php' => config_path('cloudflare.php')], 'config');
            $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/assets')], 'views');
        }
    }
    
    private function registerMigrations()
    {
        if ($this->app->runningInConsole() {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
    
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
               
            ]);
        }
    }
}
