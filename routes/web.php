<?php

Route::group(['prefix' => 'cloudflare', 'prefix' => 'cloudflare'], function () {
    Route::get('test', function () {
        return 'sadasd';
    });
});
