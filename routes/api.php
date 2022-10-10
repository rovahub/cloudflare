<?php

use Rovahub\Cloudflare\Http\Responses\BaseHttpResponse;

Route::get('test', function (BaseHttpResponse $response) {
    return $response->setMessage('asjdhaksd');
});
