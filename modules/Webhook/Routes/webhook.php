<?php

Route::group([
    'as'     => 'webhook.',
    'domain' => config('webhook.domain'),
], function () {
    Route::group(['as' => 'wasabi.', 'prefix' => 'wasabi'], __DIR__ . '/wasabi.php');
    Route::group(['as' => 'savo.', 'prefix' => 'savo'], __DIR__ . '/savo.php');
    Route::group(['as' => 'cregis.', 'prefix' => 'cregis'], __DIR__ . '/cregis.php');
    Route::group(['as' => 'sumsub.', 'prefix' => 'sumsub'], __DIR__ . '/sumsub.php');
});
