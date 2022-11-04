<?php
namespace Alresia\LaravelWassenger;

use Alresia\LaravelWassenger\Traits\WassengerRequest;

/**
 * @internal
 */
class Session
{

     /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    |
    | Send, browse and manage outbound messages
    |
    */
    use WassengerRequest;

    public static function sync(string $deviceId)
    {

        if (isset($deviceId)) {

            $instance = new self;

            return $instance->Request(WassengerApiEndpoints::DEVICE_SYNC, null, ['deviceId' => $deviceId]);
        }
    }

    
}