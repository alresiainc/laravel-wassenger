<?php
namespace Alresia\LaravelWassenger;

use stdClass;
use BadMethodCallException;
use InvalidArgumentException;

/**
 * @internal
 */
class Wassenger
{
    
     
    // /**
    //  * URL EndPoint. 
    //  */
    const ENPOINT_URL = 'https://api.wassenger.com/v1';

    private static $scheduleTo;


    private static $_Token = '056d3c454802e7b616c3161a0ced072e6e51c0645293f0e146e42ec9dac2f9d35f76e6ffeef73edd)))';


    private static $data;

    private static $buttons;

    private static $file;

    private static $isBulk = false;
    /**
     * 
     * @param string $method
     * @param string $path
     * @param object|array $param
     * 
     */
    private static function Request($method, $path, $params = array())
    {

        if (!is_callable('curl_init')) {
            return array("Error" => "cURL extension is disabled on your server");
        }

        $url = static::ENPOINT_URL . "/" . $path;

        $data = http_build_query($params);

        $header = [
            "Content-Type: application/json",
            "token: " . self::$_Token
        ];

        // dd($params);

        if (strtolower($method) == "get") $url = $url . '?' . $data;
        $curl = curl_init($url);
        if (strtolower($method) == "post") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // if ($httpCode == 404) {
        //     return array("Error" => "instance not found or pending please check you instance id");
        // }


        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($curl);

        if (strpos($contentType, 'application/json') !== false) {
            return json_decode($body);
        }

        return $body;
    }



    public function send()
    {

        $data = self::$data;
        if ($data == null) {
            throw new BadMethodCallException('Your Request is a Missing A Required Method', 100);
            trigger_error("Value must be 1 or below");
        }
        // $schduleTo = Self::$scheduleTo;

        if (is_array(Self::$scheduleTo) || is_object(Self::$scheduleTo))
            if (array_keys(Self::$scheduleTo)[0] == 'delayTo') $data->schedule = Self::$scheduleTo;
            elseif (array_keys(Self::$scheduleTo)[0] == 'deliverAt') $data->deliverAt = array_values(Self::$scheduleTo)[0];

        if (self::$file)
            if (count(self::$file) == 2)

                $data->media = (object) [self::$file[0] => self::$file[1]];
        
        if (Self::$buttons) $data->buttons = Self::$buttons;

        if (Self::$isBulk === true)
        return $this->Request('post', 'messages', $data);
        // return $this;
    }


    public static function message($phone, $message, $enqueue = false)
    {

        $data = new stdClass();
        $data->phone = $phone;
        $data->message = $message;
        if ($enqueue === false) $data->enqueue = 'never';
        self::$data = $data;

        $instance = new self;

        return $instance;
        // return $this;
    }

    public static function bulkMessage(array|object $phone, string $message, $enqueue = false)
    {

        self::$isBulk = true;
        $data = new stdClass();
        $data->phone = $phone;
        $data->message = $message;
        if ($enqueue === false) $data->enqueue = 'never';
        self::$data = $data;

        $instance = new self;

        return $instance;
        // return $this;
    }

    public function messageGroup(string $group, string $message, $priority = null)
    {

        $data = new stdClass();
        $data->group = $group;
        $data->message = $message;
        if ($priority == 'high') $data->priority = $priority;
        self::$data = $data;

        return $this;
    }


    public function schedule($delay = null)
    {

        if ($delay != null) self::$scheduleTo = ['delayTo' => $delay];
        return $this;
    }

    public function deliverAt($ISO_Date)
    {
        if ($ISO_Date != null) $dateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $ISO_Date);

        if ($dateTime) self::$scheduleTo = ['deliverAt' => $dateTime->format(\DateTime::ISO8601)];
        else throw new InvalidArgumentException('Given Date is not a valid ISO 8601 date', 100);

        return $this;
    }


    public function media($file)
    {
        self::$file = $file;
        return $this;
    }


    public function buttons(array|object $buttons_array)
    {

        if (is_array($buttons_array) || is_object($buttons_array))
            self::$buttons = $buttons_array;

        return $this;
    }
   
    
}