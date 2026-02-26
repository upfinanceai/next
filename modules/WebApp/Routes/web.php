<?php

Route::group([
    'middleware' => 'web',
    'domain'     => config('webapp.domain'),
], function () {
    Route::view('/', 'webapp::home');
    Route::view('/login', 'webapp::login');
});
