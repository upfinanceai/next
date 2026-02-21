<?php

use Kra8\Snowflake\Snowflake;

if (!function_exists('snowflake_id')) {
    function snowflake_id()
    {
        return app(Snowflake::class)->next();
    }
}
