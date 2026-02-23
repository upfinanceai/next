<?php

use Kra8\Snowflake\Snowflake;

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
