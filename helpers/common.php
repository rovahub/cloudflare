<?php

if (!function_exists('cloudflare_prefix')) {
    function cloudflare_prefix($type = null)
    {
        $path = config('cloudflare.cloudflare_panel_path');
        return $path . ($type === 'api' ? '/api' : '');
    }

}

if (!function_exists('cloudflare_route_group')) {
    function cloudflare_route_group($type = null)
    {
        $domain = config('cloudflare.cloudflare_panel_domain');
        $prefix = cloudflare_prefix($type);
        if (config('cloudflare.cloudflare_panel_domain')) {
            return [
                'domain' => $domain,
                'prefix' => $prefix
            ];
        }
        return ['prefix' => $prefix];
    }
}
