<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [ 
        'client_id' => env ('GG_CLIENT_ID'),
        'client_secret' => env ('GG_CLIENT_SECRET'),
        'redirect' => env ('GG_REDIRECT'),
    ],

    'facebook' => [ 
        'client_id' => env ('FB_CLIENT_ID'),
        'client_secret' => env ('FB_CLIENT_SECRET'),
        'redirect' => env ('FB_REDIRECT'),
    ],

    'phonepe' => [
        'env' => env('PHONEPE_ENV', 'sandbox'),
        'sandbox' => [
            'base_url' => env('PHONEPE_SANDBOX_BASE_URL', 'https://api-preprod.phonepe.com'),
            'client_id' => env('PHONEPE_SANDBOX_CLIENT_ID'),
            'client_version' => env('PHONEPE_SANDBOX_CLIENT_VERSION'),
            'client_secret' => env('PHONEPE_SANDBOX_CLIENT_SECRET'),
            'grant_type' => env('PHONEPE_SANDBOX_GRANT_TYPE', 'client_credentials'),
        ],
        'production' => [
            'base_url' => env('PHONEPE_PRODUCTION_BASE_URL', 'https://api.phonepe.com'),
            'client_id' => env('PHONEPE_PRODUCTION_CLIENT_ID'),
            'client_version' => env('PHONEPE_PRODUCTION_CLIENT_VERSION'),
            'client_secret' => env('PHONEPE_PRODUCTION_CLIENT_SECRET'),
            'grant_type' => env('PHONEPE_PRODUCTION_GRANT_TYPE', 'client_credentials'),
        ],
    ],
];
