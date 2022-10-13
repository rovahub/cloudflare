<?php

use Rovahub\Cloudflare\Http\Controllers\AuthController;
use Rovahub\Cloudflare\Http\Controllers\DashboardController;
use Rovahub\Cloudflare\Http\Controllers\ZoneController;

Route::group(['prefix' => 'auth'], function () {
    Route::get('signin', [AuthController::class, 'signin'])->name('cloudflare:signin');
});

Route::group([], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('cloudflare:dashboard');

    Route::group(['prefix' => 'zones'], function () {
        Route::get('/', [ZoneController::class, 'index'])->name('cloudflare:zone.index');
        Route::get('/{id}', [ZoneController::class, 'show'])->name('cloudflare:zone.detail');
        Route::put('/cache', [ZoneController::class, 'cachePurge'])->name('cloudflare:zone.cache');
        Route::put('/enable', [ZoneController::class, 'enable'])->name('cloudflare:zone.enable');
    });
});
