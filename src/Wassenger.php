<?php

namespace Alresia\LaravelWassenger;

use stdClass;
use Alresia\LaravelWassenger\Config;
use Alresia\LaravelWassenger\Devices;
use Alresia\LaravelWassenger\Traits\Messages;
use Alresia\LaravelWassenger\WassengerApiEndpoints;
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

    public static function sessionSync(string $deviceId = null)
    {

        if (isset($deviceId)) {
            $id = $deviceId;
        } else {

            if (\function_exists('config')) {
                $id = config('wassenger.authorisation.default_device');
            } else {
                $id = Config::DEFAULT_DEVICE;
            }
        }

        $instance = new self;
        return $instance->Request(WassengerApiEndpoints::DEVICE_SYNC, null, ['deviceId' => $id]);
    }

    public static function syncAll(string $deviceId = null)
    {



        $allDevice = Devices::get();
        $totalSynd = 0;
        $lastSyncDevice = '';
        $lastSyncAt = '';
        $lastSyncSeconds = '';
        $response = [];
        $result = [];

        foreach ($allDevice as $device) {
            $lastSyn = date('d-m-Y H:i:s', strtotime($device->session->lastSyncAt));
            $now = date('d-m-Y H:i:s');
            $timeUp = date('d-m-Y H:i:s', strtotime($lastSyn.' + 60 seconds'));
            if ($timeUp < $now) {
                $syncDevice = self::sessionSync($device->id);
                if (isset($syncDevice) && !empty($syncDevice)) {
                    $result[$device->id] = $syncDevice;
                    $totalSynd++;
                    $lastSyncDevice = $device->id;
                    $lastSyncAt = $syncDevice->lastSyncAt ?? '';
                    $lastSyncSeconds = $syncDevice->lastSyncSeconds ?? '';
                }
            }
        }

        if(count($result) != 0){
            $response = [
                'lastSyncDevice' => $lastSyncDevice,
                'lastSyncAt' => $lastSyncAt,
                'lastSyncSeconds' => $lastSyncSeconds,
                'syncDevices' => $result,
            ];
        }

        return $response;
    }

    public static function sync(string $deviceId = null)
    {

        if (isset($deviceId)) {
            $id = $deviceId;
        } else {

            if (\function_exists('config')) {
                $id = config('wassenger.authorisation.default_device');
            } else {
                $id = Config::DEFAULT_DEVICE;
            }
        }

        $instance = new self;
        return $instance->Request(WassengerApiEndpoints::DEVICE_SYNC, null, ['deviceId' => $id]);
    }
}
