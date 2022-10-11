<?php

namespace Rovahub\Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;
use Rovahub\Cloudflare\Supports\Assets;

class AssetsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
