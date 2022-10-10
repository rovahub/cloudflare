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
        $this->mergeConfigFrom(__DIR__ . '/../../config/cloudflare.php', 'cloudflare');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cloudflare');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../../config/cloudflare.php' => config_path('cloudflare.php')], 'config');
            $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/assets')], 'views');
        }
    }

    public function register()
    {
        File::requireOnce(__DIR__ . '/../../helpers/common.php');
        $router = $this->app['router'];
        $router->aliasMiddleware('cloudflare:api', ForceJsonResponseMiddleware::class);
    }
}
