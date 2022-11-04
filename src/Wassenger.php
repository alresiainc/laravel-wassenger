<?php

namespace Alresia\LaravelWassenger;

use stdClass;
use Alresia\LaravelWassenger\Traits\Messages;
use Alresia\LaravelWassenger\Traits\WassengerRequest;


/**
 * @internal
 */
class Wassenger
{

    /*
    |--------------------------------------------------------------------------
    | Laravel Wassenger
    |--------------------------------------------------------------------------
    |
    | Main Laravel Wassenger Class
    |
    */

    use WassengerRequest, Messages;

    /**
     * Search outbound messages, optionally filtered by customer search params. 
     * 
     * ************************************************************************
     * 
     * @param array|object $request_array
     * 
     */

   

    public static function numberExist(string $number)
    {

        if (isset($number)) {

            $data = new stdClass();
            $data->phone = $number;
            $instance = new self;

            return $instance->Request(WassengerApiEndpoints::NUMBER_EXIST, $data);
        }
    }

    public static function sessionSync(string $deviceId)
    {

        if (isset($deviceId)) {

            $instance = new self;

            return $instance->Request(WassengerApiEndpoints::DEVICE_SYNC, null, ['deviceId' => $deviceId]);
        }
    }
}
