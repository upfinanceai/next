<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'wasabi' => [
        'base_url' => env('WASABI_BASE_URL'),
        'api_key' => env('WASABI_API_KEY'),
        'wsb_public_key' => env('WASABI_PUBLIC_KEY'),
        'merchant_private_key' => env('WASABI_MERCHANT_PRIVATE_KEY'),
        'merchant_public_key' => env('WASABI_MERCHANT_PUBLIC_KEY'),
    ],

    'save_openapi' => [
        'base_url'          => env("SAVO_OPENAPI_BASE_URL"),
        'api_key'           => env("SAVO_OPENAPI_API_KEY"),
        'system_public_key' => env("SAVO_OPENAPI_SYSTEM_PUBLIC_KEY"),
        'app_public_key'    => env("SAVO_OPENAPI_APP_PUBLIC_KEY"),
        'app_private_key'   => env("SAVO_OPENAPI_APP_SECRET_KEY"),
    ],

];
