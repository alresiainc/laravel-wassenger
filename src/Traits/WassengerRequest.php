<?php
namespace Alresia\LaravelWassenger\Traits;

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
     * @internal
     */
    public function __construct()
    {
        $this->api_key = config('wassenger.authorisation.api_key');
        $this->device_id = config('wassenger.authorisation.device_id');
        $this->api_url = config('wassenger.authorisation.api_url');
        $this->api_version = config('wassenger.authorisation.api_version');
        
    }

    /**
     * 
     * @param string $method
     * @param string $path
     * @param object|array $param
     * 
     */
    public function Request($method, $path, $params = array())
    {

        if (!is_callable('curl_init')) {
            throw new LaravelWassengerException("cURL extension is disabled on your server");
        }

        if (empty($this->api_key)) {
            throw new LaravelWassengerInvalidApiKey("Missing or Invalid Api Key");
        }

        $url = $this->api_url . "/" . $path;
        $data = http_build_query($params);

        $header = [
            "Content-Type: application/json",
            "token: " . $this->api_key
        ];

        dd($params);

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
}
