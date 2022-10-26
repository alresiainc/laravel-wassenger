<?php

namespace Alresia\LaravelWassenger;


/**
 * @internal
 */
class Config
{
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

    public const API_KEY = '';
    public const API_HOST = 'https://api.wassenger.com';
    public const API_VERSION = 1;


    /*
    |--------------------------------------------------------------------------
    | HTTP CLIENT CONFIGURATION
    |--------------------------------------------------------------------------
    */

    public const RETURN_JSON_ERRORS = false;
}

