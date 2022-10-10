<?php

Route::group(array_merge(['middleware' => 'cloudflare:api'], cloudflare_route_group('api')),
    function () {
        Route::get('test', function (\Rovahub\Cloudflare\Http\Responses\BaseHttpResponse $response) {
            return $response->setMessage('asjdhaksd');
        });
    });
