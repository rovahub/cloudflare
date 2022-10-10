<?php

if (!function_exists('cloudflare_prefix')) {
    function cloudflare_prefix($type = null)
    {
        $path = config('cloudflare.path');
        return $path . ($type === 'api' ? '/api' : '');
    }

}

if (!function_exists('cloudflare_route_group')) {
    function cloudflare_route_group($type = null)
    {
        $domain = config('cloudflare.domain');
        $prefix = cloudflare_prefix($type);
        if ($domain) {
            return [
                'domain' => $domain,
                'prefix' => $prefix
            ];
        }
        return ['prefix' => $prefix];
    }
}
