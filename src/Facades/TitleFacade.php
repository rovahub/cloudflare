<?php

namespace Rovahub\Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;
use Rovahub\Cloudflare\Supports\Title;

class TitleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Title::class;
    }
}
