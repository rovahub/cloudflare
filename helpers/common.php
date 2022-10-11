<?php


if (!function_exists('page_title')) {
    function page_title()
    {
        return \Rovahub\Cloudflare\Facades\TitleFacade::getFacadeRoot();
    }
}
