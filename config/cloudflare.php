<?php

return [
    'name' => env('CLOUDFLARE_NAME', 'CloudFlare DNS'),

    'api' => env('CLOUDFLARE_API', null),

    'domain' => env('CLOUDFLARE_DOMAIN', null),

    'email' => env('CLOUDFLARE_EMAIL', null),

    'path' => env('CLOUDFLARE_PATH', 'cloudflare'),

    'key' => env('CLOUDFLARE_KEY', null),

    'enabled' => env('CLOUDFLARE_ENABLED', true),

    'timeout' => env('CLOUDFLARE_TIMEOUT', 10),

    'hook' => env('CLOUDFLARE_HOOK', null),

    'middleware' => [

    ],
];
