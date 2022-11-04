<?php

namespace Alresia\LaravelWassenger\Traits;

use stdClass;
use BadMethodCallException;
use InvalidArgumentException;
use Alresia\LaravelWassenger\WassengerApiEndpoints;
use Alresia\LaravelWassenger\Exceptions\LaravelWassengerException;

trait Messages
{
    use WassengerRequest;

    private static $scheduleTo;

    private static $search_message;

    private static $message_id;

    private static $data;

    private static $buttons;

    private static $file;

    private static $header;

    private static $footer;

    private static $device;

    private static $agent;

    private static $contacts;

    private static $location;

    private static $expiration;

    private static $RawData;

    /** 
     * Send message
     * 
     * Send new text, to a given phone number.
     * 
     * */ 

    public function checkNumber(string $number)
    {

        if (isset($number)){
            
            $data = new stdClass();
            $data->phone = $number;
            return $this->Request(WassengerApiEndpoints::NUMBER_EXIST, $data);
        }
           

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

    }

    public static function raw($data)
    {
        
        if (is_array($data)){
            
            self::$RawData = $data;
        }

        $instance = new self;
        return $instance;
    }

    /** 
     * Message Group
     * 
     * Send new text, to a Group using an ID.
     * 
     * */ 
    public static function messageGroup(string $group, string $message, $priority = null)
    {

        $data = new stdClass();
        $data->group = $group;
        $data->message = $message;
        if ($priority == 'high') $data->priority = $priority;
        self::$data = $data;

        $instance = new self;

        return $instance;
    }

    /** 
     * Message Schedule
     * 
     * Send messages in a predefined date/time
     * 
     * */ 

    public function schedule($delay = null)
    {

        if ($delay != null) self::$scheduleTo = ['delayTo' => $delay];
        return $this;
    }

    public function deliverAt($ISO_Date)
    {
        if ($ISO_Date != null) $dateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $ISO_Date);

        if ($dateTime) self::$scheduleTo = ['deliverAt' => $dateTime->format(\DateTime::ISO8601)];
        else throw new InvalidArgumentException('Given Date is not a valid ISO 8601 date');

        return $this;
    }


    /** 
     * Media Message
     * 
     * Send image, documents or binary archives
     * 
     * */ 
    public function media($file)
    {
        self::$file = $file;
        return $this;
    }


    public function contacts($contacts_array)
    {

        if (is_array($contacts_array) || is_object($contacts_array))
            self::$contacts = $contacts_array;

        return $this;
    }

    public function expiration($expiration_array)
    {

        if (is_array($expiration_array) || is_object($expiration_array))
            self::$expiration = $expiration_array;

        return $this;
    }


    public function location($location_array)
    {

        if (is_array($location_array) || is_object($location_array))
            self::$location = $location_array;

        return $this;
    }

    public function agent(string $agent)
    {

        if (isset($agent))
            self::$agent = $agent;

        return $this;
    }

    public function device(string $device)
    {

        if (isset($device))
            self::$device = $device;

        return $this;
    }

    

    public function buttons($buttons_array)
    {

        if (is_array($buttons_array) || is_object($buttons_array))
            self::$buttons = $buttons_array;

        return $this;
    }

    public function header(string $text)
    {

        if (isset($text))
            self::$header = $text;

        return $this;
    }

    public function footer(string $text)
    {

        if (isset($text))
            self::$footer = $text;

        return $this;
    }

    public function send()
    {

        $data = self::$data;
        $RawData = self::$RawData;

        if ($data == null && $RawData == null) {
            throw new BadMethodCallException('Your Request is a Missing A Required Method');
        }

       

        $checkNumber = $this->checkNumber($data->phone);

        if($checkNumber->exists != true){

            return $checkNumber;
        }


        if (is_array($RawData) || is_object($RawData)) {

            return $this->Request(WassengerApiEndpoints::SEND_MESSAGE, $RawData);
        }
       
        if (is_array(Self::$scheduleTo) || is_object(Self::$scheduleTo))
            if (array_keys(Self::$scheduleTo)[0] == 'delayTo') $data->schedule = Self::$scheduleTo;
            elseif (array_keys(Self::$scheduleTo)[0] == 'deliverAt') $data->deliverAt = array_values(Self::$scheduleTo)[0];

        if (self::$file)
            if (count(self::$file) == 2)

                $data->media = (object) [self::$file[0] => self::$file[1]];

        if (Self::$buttons) $data->buttons = Self::$buttons;
        if (Self::$header) $data->header = Self::$header;
        if (Self::$footer) $data->footer = Self::$footer;
        if (Self::$device) $data->device = Self::$device;
        if (Self::$agent) $data->agent = Self::$agent;
        if (Self::$contacts) $data->contacts = Self::$contacts;
        if (Self::$location) $data->location = Self::$location;
        if (Self::$expiration) $data->expiration = Self::$expiration;
        
        $response = $this->Request(WassengerApiEndpoints::SEND_MESSAGE, $data);

        return $response;
    }

    public function update()
    {

        if (isset(self::$message_id) && !empty(self::$message_id)) {
            $id = self::$message_id;


            $data = self::$data;
            if ($data == null) {
                throw new BadMethodCallException('Your Request is a Missing A Required Method');
                trigger_error("Value must be 1 or below");
            }


            if (is_array(self::$scheduleTo) || is_object(self::$scheduleTo)) {
                if (array_keys(self::$scheduleTo)[0] == 'delayTo') {
                    $data->schedule = self::$scheduleTo;
                } elseif (array_keys(self::$scheduleTo)[0] == 'deliverAt') {
                    $data->deliverAt = array_values(self::$scheduleTo)[0];
                }
            }

            if (self::$file) {
                if (count(self::$file) == 2) {
                    $data->media = (object) [self::$file[0] => self::$file[1]];
                }
            }

            if (self::$buttons) {
                $data->buttons = self::$buttons;
            }


            return $this->Request(WassengerApiEndpoints::UPDATE_MESSAGE, $data, $id);
        } else {
            throw new LaravelWassengerException('Invalid ID: Please Specify an ID using the findById() Method');
        }
    }


    /**
     * Search outbound messages, optionally filtered by customer search params. 
     * 
     * ************************************************************************
     * 
     * @param $request_array
     * 
     */
    public static function search($request_array)
    {

        if (is_array($request_array) || is_object($request_array))
            self::$search_message = $request_array;

        $instance = new self;

        return $instance;
    }

    public static function findById(string $message_id)
    {

        if (isset($message_id))
            self::$message_id = $message_id;
        $instance = new self;
        return $instance;
    }


    public function get()
    {

        $data = self::$data;
        if (isset(self::$search_message) && !empty(self::$search_message)) {

            $data = self::$search_message;
            return $this->Request(WassengerApiEndpoints::SEARCH_MESSAGES, $data);
        } elseif (isset(self::$message_id) && !empty(self::$message_id)) {

            $id = self::$message_id;
            return $this->Request(WassengerApiEndpoints::GET_MESSAGE_BY_ID, null, $id);
        }
    }

    public static function find($request_array)
    {

        if (isset($request_array) && !empty($request_array)) {
            $data = $request_array;
            $instance = new self;
            return $instance->Request(WassengerApiEndpoints::SEARCH_MESSAGES, $data);
        }
    }

    public static function delete(string $message_id = null)
    {
        $instance = new self;
        $id = $message_id ?? self::$message_id;
        if (isset(self::$message_id) && !empty(self::$message_id)) {

            return $instance->Request(WassengerApiEndpoints::DELETE_MESSAGE, null, self::$message_id);
        } elseif (isset($message_id) && !empty($message_id)) {

            return $instance->Request(WassengerApiEndpoints::DELETE_MESSAGE, null, $message_id);
        } else {
            throw new LaravelWassengerException('Invalid ID: Please Specify an ID or use the findById() Method');
        }
    }
}
