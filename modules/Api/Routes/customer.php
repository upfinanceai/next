<?php

Route::get('customers', function () {
    return \Modules\Customer\Models\Customer::all();
});
