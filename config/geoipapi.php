<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Base URL to YEB API
    |--------------------------------------------------------------------------
    */
    'base_url' => env('YEB_API_BASE', 'https://api.yeb.to/v1/'),

    /*
    |--------------------------------------------------------------------------
    | API Key (YEB_KEY_ID)
    |--------------------------------------------------------------------------
    */
    'key' => env('YEB_KEY_ID'),

    /*
    |--------------------------------------------------------------------------
    | cURL defaults
    |--------------------------------------------------------------------------
    */
    'curl' => [
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_USERAGENT      => 'yebto-geoip-api-php',
    ],
];
