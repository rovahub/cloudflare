<?php
return [
    'token' => env('CLOUDFLARE_TOKEN', null),
    'domain' => env('CLOUDFLARE_DOMAIN', null),
    'path' => env('CLOUDFLARE_PATH', 'cloudflare'),
    'key' => env('CLOUDFLARE_KEY', null)
];
