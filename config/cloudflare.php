<?php
return [
    'api_key' => env('CLOUDFLARE_API', null),
    'panel_domain' => env('CLOUDFLARE_PANEL_DOMAIN', null),
    'panel_path' => env('CLOUDFLARE_PANEL_PATH', 'cloudflare'),
    'panel_admin_key' => env('CLOUDFLARE_PANEL_ADMIN_KEY', null)
];
