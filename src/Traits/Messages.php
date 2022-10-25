<?php
namespace Alresia\LaravelWassenger\Traits;

use stdClass;
use BadMethodCallException;
use InvalidArgumentException;

trait Messages
{

    private static $scheduleTo;
    
    private static $data;

    private static $buttons;

    private static $file;

    private static $isBulk = false;

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

        
        return $this->Request('post', 'messages', $data);
      
    }
   
}