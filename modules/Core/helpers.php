<?php

use Kra8\Snowflake\Snowflake;
use Modules\Core\Models\Setting;

if (!function_exists('snowflake_id')) {
    function snowflake_id()
    {
        return app(Snowflake::class)->next();
    }
}

if (!function_exists('snowflake_short_id')) {
    function snowflake_short_id()
    {
        return app(Snowflake::class)->short();
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_array($key)) {
            foreach ($key as $_key => $_value) {
                Setting::updateOrCreate([
                    'key' => $_key,
                ], [
                    'value' => $_value,
                ]);
            }
            return null;
        }
        return Setting::firstWhere(['key' => $key])?->value ?? $default;
    }
}
