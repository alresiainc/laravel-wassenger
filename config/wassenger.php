<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authorisation
    |--------------------------------------------------------------------------
    |
    | User API key token needs to be used on every API request that requires
    | authentication. Get or create your API key from the Web Console.
    | Note: chat agents and supervisors have no access to the API.
    |
    */

    'authorisation' => [
        'api_key' => env('WASSENGER_API_KEY', 'sampleToken'),
        'api_host'   => env('WASSENGER_API_URL', 'https://api.wassenger.com'),
        'api_version' => 1,
        'device_id' => env('WASSENGER_DEVICE_ID'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP CLIENT CONFIGURATION
    |--------------------------------------------------------------------------
    |
    |
    */

    'http_client' => [
        'timeout' => 60,
    ],
];
