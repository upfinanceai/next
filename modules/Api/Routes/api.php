<?php

Route::group([
    'as'         => 'api.',
    'middleware' => 'api',
    'domain'     => config('api.domain'),
], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], __DIR__ . '/auth.php');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group([], __DIR__ . '/customer.php');
    });
});
