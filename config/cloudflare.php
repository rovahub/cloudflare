<?php
return [
    'api_key' => env('CLOUDFLARE_API', null),
    'domain' => env('CLOUDFLARE_DOMAIN', null),
    'path' => env('CLOUDFLARE_PATH', 'cloudflare'),
    'key' => env('CLOUDFLARE_KEY', null)
];
