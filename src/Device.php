<?php

namespace Alresia\LaravelWassenger;

use stdClass;
use Alresia\LaravelWassenger\Traits\WassengerRequest;

/**
 * @internal
 */
class Device
{

    private static $divice_ids;

    private static $id;

    private static $status;

    private static $session;

    private static $size;

    private static $page;

    private static $data;

    private static $search;

    /*
    |--------------------------------------------------------------------------
    | divices
    |--------------------------------------------------------------------------
    |
    | Send, browse and manage outbound divices
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


    // public static function collection($divice_ids)
    // {
    //     if (isset($divice_ids)) self::$divice_ids = $divice_ids;
    //     $instance = new self;
    //     return $instance;
    // }

    public static function status($status = null)
    {

        if ($status != null) self::$status = $status;
        $instance = new self;
        return $instance;
    }

    public static function session($session = null)
    {

        if ($session != null) self::$session = $session;
        $instance = new self;
        return $instance;
    }

    public static function findById(string $divice_id)
    {

        if (isset($divice_id)) self::$id = $divice_id;
        $instance = new self;
        return $instance;
    }

    public static function search(string $search)
    {

        if (isset($search)) self::$search = $search;
        $instance = new self;
        return $instance;
    }


    public static function get($data = null)
    {

        
        if (isset($data) && !empty($data)) {
            $data = $data;
            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::DEVICES, $data);
        }elseif (isset(self::$data) && !empty(self::$data)) {
            $data = self::$data;
            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::DEVICES, $data);
        } elseif (isset(self::$search) && !empty(self::$search)) {
            $data[] = self::$search;
            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::DEVICES, $data);
        } elseif (isset(self::$id) && !empty(self::$id)) {
            $id = self::$id;
            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::GET_DEVICE_BY_ID, null, ['deviceId' => $id]);
        } else {

            $data = new stdClass();
            if (isset(self::$divice_ids) && !empty(self::$divice_ids)) $data->ids = self::$divice_ids;
            if (isset(self::$status) && !empty(self::$status)) $data->status = self::$status;
            if (isset(self::$session) && !empty(self::$session)) $data->sessionStatus = self::$session;
            if (isset(self::$size) && !empty(self::$size)) $data->size = self::$size;
            if (isset(self::$page) && !empty(self::$page)) $data->page = self::$page;

            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::DEVICES, $data);
        }
    }

    public static function limit($size = 20, $page = 0)
    {
        $data = new stdClass();
        if (isset($size) && !empty($size)) self::$size = $size;
        if (isset($page) && !empty($page)) self::$page = $page;

        $instance = new self;
        return $instance;
    }

    public static function raw($data)
    {

       
        if (is_array($data)) {

            self::$data = $data;
        }

        $instance = new self;
        return $instance;
    }
}
