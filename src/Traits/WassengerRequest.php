<?php

namespace Alresia\LaravelWassenger\Traits;

use Alresia\LaravelWassenger\Config;
use Alresia\LaravelWassenger\Exceptions\LaravelWassengerException;
use Alresia\LaravelWassenger\Exceptions\LaravelWassengerInvalidApiKey;

trait WassengerRequest
{

    /**
     * Wassenger API_KEY.
     *
     * @see https://app.wassenger.com/apikeys
     * @see https://github.com/alresiainc/laravel-wassenger#api_keys
     *
     * @var string
     */
    private $api_key;

    /**
     * Wassenger Device ID.
     *
     * @see https://app.wassenger.com/devices
     * @see https://github.com/alresiainc/laravel-wassenger#device_id
     *
     * @var string
     */
    private $device_id;

    /**
     * Set Priority
     *
     * @var string
     */
    public $priority = 'normal';

    /**
     * Url to Wassenger Api
     *
     * @var string
     */
    public $api_url;

    /**
     * Used Wasseger Version in This Package
     *
     * @var int
     */
    public $api_version;

    /**
     * Display Error or Return in Code
     *
     * @var int
     */
    public $return_json_errors;


    /**
     * @internal
     */
    public function __construct()
    {
        if (\function_exists('config')) {
            $this->api_key = config('wassenger.authorisation.api_key');
            $this->api_url = config('wassenger.authorisation.api_host');
            $this->api_version = config('wassenger.authorisation.api_version');
            $this->return_json_errors = config('wassenger.http_client.return_json_errors');
        } else {
            
            $this->api_key = Config::API_KEY;
            $this->api_url = Config::API_HOST;
            $this->api_version = Config::API_VERSION;
            $this->return_json_errors = Config::RETURN_JSON_ERRORS;
        }
    }

    /**
     * 
     * @param Alresia\LaravelWassenger\WassengerMessagesRoute $routeName
     * @param object|array $param
     * @param string $param
     */
    public function Request($routeName, $params = null, $attachment = null)
    {

        $method = $routeName[1];
        $path = $routeName[0];
        if (isset($routeName[2])) {
            $attached = $routeName[2];
        } else {
            $attached = false;
        }


        if (!is_callable('curl_init')) {
            throw new LaravelWassengerException("cURL extension is disabled on your server");
        }

        if (empty($this->api_key)) {
            throw new LaravelWassengerInvalidApiKey("Missing or Invalid Api Key");
        }


        if ($attached == true && $attachment != null) {
            $url = $this->api_url . "/v" . $this->api_version . "/" . $path . "/" . $attachment;
        } else {
            $url = $this->api_url . "/v" . $this->api_version . "/" . $path;
        };

        if (isset($params) && !empty($params)) {
            $data = http_build_query($params);
        } else {
            $data = '';
        }

        $request_header = [
            "Content-Type: application/json",
            "token: " . $this->api_key
        ];


        if (strtolower($method) == "get") $url = $url . '?' . $data;
        $curl = curl_init($url);

        if (strtolower($method) != "get") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            if (isset($params)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
            }
        }

        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_header);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

        curl_close($curl);

        if ($err) {
            throw new LaravelWassengerException('cURL Error #:' . $err);
        } elseif ($this->return_json_errors == false && $httpCode >= 400) {

            $error = json_decode($response);
            $errorCode = $error->errorCode ?? "Error";
            $errorStatus = $error->status ?? "";
            $errorMessage = $error->message ?? "An Unknow Error Has Occured";

            throw new LaravelWassengerException('Wassenger ' . $errorCode . '[' . $errorStatus . ']: ' . $errorMessage);
        }

        if (strpos($contentType, 'application/json') !== false) {
            $body = json_decode($response);
        } else {
            $body = $response;
        }

        return $body;
    }
}
