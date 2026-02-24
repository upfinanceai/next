<?php

Route::group([
    'as'         => 'api.',
    'middleware' => 'api',
    'domain'     => config('api.domain'),
], function () {
    require_once __DIR__ . '/customer.php';
});
