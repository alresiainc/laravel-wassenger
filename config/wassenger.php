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
        'token' => env('WASSENGER_TOKEN', 'sampleToken'),
        'host'   => 'https://api.wassenger.com',
        'version' => 1
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
