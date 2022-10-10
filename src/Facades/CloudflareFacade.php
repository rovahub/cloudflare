<?php

namespace Rovahub\Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;
use Rovahub\Cloudflare\Cloudflare;

class CloudflareFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Cloudflare::class;
    }
}
