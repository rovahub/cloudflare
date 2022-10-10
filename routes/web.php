<?php

use Rovahub\Cloudflare\Http\Controllers\AuthController;

Route::group(cloudflare_route_group(), function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('signin', [AuthController::class, 'signin'])->name('cloudflare:signin');
    });
});
