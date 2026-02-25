<?php
Route::group([
    'as'     => 'webhook.',
    'domain' => config('app.wehbook_domain'),
], function () {
    Route::group(['prefix' => 'wasabi', 'as' => 'wasabi.'], __DIR__ . '/wasabi.php');
});
