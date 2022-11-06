# LARAVEL WASSENGER DOCUMENTATION

WhatsApp Business Api for Larave Using Wassenger Api
![laravel-wassenger-logo](https://user-images.githubusercontent.com/42520408/197910318-c42baeae-9799-4b43-8bc1-94bf3cdd95cb.png)

> For more info about Wassenger follow [https://www.wassenger.com](https://www.wassenger.com/).

## INTRODUCTION

This API documentation provides detailed information about the LARAVEL WASSENGER and WASSENGER endpoints and request/response API contracts.

You can easily connect, send request and recieving response on most usable and important endpoint in wassenger using php.

This Package has been built with expection to help ease connection and intergrating WhatsApp on our Application.

With the help of Wassenger Api and it well structured to work on Laravel framework.



## INSTALLATION & SETUP
## On Composer
Laravel Wassenger is available on [Packagist](https://packagist.org/packages/alresia/laravel-wassenger) (using semantic versioning), and installation via [Composer](https://getcomposer.org) is the recommended way to install this Package. Just add this line to your `composer.json` file:

```json
"alresia/laravel-wassenger": "^1.2.0"
```

or run

```sh
composer require alresia/laravel-wassenger
```

#### From Laravel Controller

```php
<?php

namespace App\Http\Controllers;

use Alresia\LaravelWassenger\Messages;

class SampleController extends Controller
{
    public function sendMessage()
    {
        $phone = '+1234567890';
        $message = 'Hello world! This is a simple test message';
        Messages::message($phone, $message)->send();

    }

}
```

### Using Composer Directly
using composer directly require composer autoload file

```php
<?php
require_once 'vendor/autoload.php';

use Alresia\LaravelWassenger\Wassenger;

    $phone = '+1234567890';
    $message = 'Hello world! This is a simple test message';
    Messages::message($phone, $message)->send();

```
## Using Without Composer

Alternatively, if you're not using Composer or Laravel Application, you
can [download Laravel-Wassenger as a zip file](https://github.com/alresiainc/laravel-wassenger/archive/master.zip), then copy the contents of the folder into the directory of your php application and load `wassenger-loader.php'`:

```php
<?php

use Alresia\LaravelWassenger\Messages;

require 'PATH_TO_LARAVEL_WASSENGER/laravel-wassenger/src/wassenger-loader.php';

    $phone = '+1234567890';
    $message = 'Hello world! This is a simple test message';
    Messages::message($phone, $message)->send();
```

## CONFIGURATION

### Laravel


Laravel Wassenger was made to work out-of-the-box, you can override the configuration by simply publishing the config file in laravel.

```shell
php artisan vendor:publish --provider="Alresia\LaravelWassenger\WassengerServiceProvider" --tag="config"
```


After that, you will receive the `config/wassenger.php` config file with an array like this:

```php
<?php
return [
    'authorisation' => [
        'api_key' => env('WASSENGER_API_KEY', ''),
        'api_host'   => env('WASSENGER_API_URL', 'https://api.wassenger.com'),
        'api_version' => 1,
        'default_device' => env('DEFAULT_DEVICE', '')
    ],
    'http_client' => [
        'return_json_errors' => false,
    ],
];
```

### Others Application

The Configuration file is Located at `laravel-wassenger/src/Config.php`

```php
<?php

namespace Alresia\LaravelWassenger;

class Config
{
    public const API_KEY = '';
    public const API_HOST = 'https://api.wassenger.com';
    public const API_VERSION = 1;
    public const DEFAULT_DEVICE = null;

    public const RETURN_JSON_ERRORS = false;

```


### Api Keys
The WASSENGER_API_KEY is Required to use this package



>To get Your API KEY go to [Wassanger Console](https://app.wassenger.com/apikeys) add Get a Api Key

if you are using Larevel just head over to your `.env` file to set your Api key and Default device
```php
WASSENGER_API_KEY=<YOUR_KEY_HERE>
DEFAULT_DEVICE=<DEVICE_ID_HERE>
```


if you want the application to return a Json response instead of an Error Exception
<br>
Change the `Return JSON Errors` to `true` from the config file

```php
'http_client' => [
        'return_json_errors' => true,
    ],
```
```php
 public const RETURN_JSON_ERRORS = true;
```
This is usefull if you want to manage error responses

## USAGE
This deals with four endpoint of Wassenger. Doh it only has the most used and important functions

| Class                                   | Description                                                                                           |
| --------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| `Wassenger::class`[*](#main)            | This is the main class of Laravel Wassenger. It contain most usefull methods controlling the packages |
| `Messages::class`[*](#messages-methods) | Send, browse and manage outbound messages                                                             |
| `Devices::class`             [*](#device)                   | Manage Conneted Device and See status.                                                                |
| `Session::class`                 | Manage WhatsApp session status synchronization.                                                       |


## Classes
### Main Wassenger Class
<!-- ### `Wassenger::class` -->

>To use include the `LaravelWassenger\Wassenger` namespace in your file;
```php
use Alresia\LaravelWassenger\Wassenger;
```
The following available methods are:

| Method                                                  | Description                                                                                                                                                         | Parameters                                             |
| ------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| `numberExist()` <br> [see example](#number-exist)       | Check if a given phone number exists in WhatsApp and is able to receive messages. The number format must be in E164 format. <br>You can check one number at a time. | @param [String](#params) `$phone` *required            |
| `sessionSync()` <br>[see example](#sync-device-session) | Force WhatsApp session status synchronization of a device. <br>**Note:** if you do not specify an ID, will use default device id from config                        | @param [String\|Null](#params) `$deviceId` **optional* |
| `syncAll()` <br>[see example](#sync-all-device-session) | Force synchronize all device session status.<br>**Note:** *This method uses a loop in getting all devices then synchronize them. It will skip device that is already synchronized or last synchronize in less than 60 seconds. <br>Avoid running this function if you have too many device in connected to your account.*                     | @param [Null](#params)                                 |

### Examples:

#### Number Exist

```php
Wassenger::numberExist('+234805599570');
```

#### Sync device session

```php
Wassenger::sessionSync('63615bb1db0ssb686cee2fa4a');
```

```php
Wassenger::sync('63615bb1db0ssb686cee2fa4a');
```

#### Sync all device session

```php
Wassenger::syncAll();
```

### Messages
<!-- ### `Messages::class` -->

>To use include the `LaravelWassenger\Messages` namespace in your file;
```php
use Alresia\LaravelWassenger\Messages;
```

The following available methods for sending messages in this package, which you can [See the full details here](https://app.wassenger.com/docs/#tag/Messages):

| Method                                                                                                                                | Description                                                                                                                                                                                                                                                                                               | Parameters                                                                                                                                                                                                                               |
| ------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `message()` <br> [see example](#send-text-message-to-a-phone-number)                                                                  | Use to attached text and user phone number.                                                                                                                                                                                                                                                               | `phone`(string:requires) , `message`  (string:required), `enqueue` (bool:optional)(default:false)                                                                                                                                        |
| `messageGroup()` <br> [see example](#send-text-message-with-high-priority-to-a-group)                                                 | message a group.                                                                                                                                                                                                                                                                                          | `group_id`(string:requires) , `message`  (string:required), `enqueue` (bool:optional)                                                                                                                                                    |
| `agent()`                                                                                                                             | Optional Agent ID to send the message on behalf of. The chat will not be assigned to the agent unless explicitly defined via message actions. The agent must have access permissions to the device. You can retrieve the agents ID [from Here](https://app.wassenger.com/docs/#operation/getDeviceAgents) | `agent_id`(string:optional)                                                                                                                                                                                                              |
| `contacts()`                                                                                                                          | Send one or multiple contact cards to a target phone or group chat. Contact is composed based on an E164 international phone number and contact name. Contact name can have spaces representing a person full name. You can send up to 10 contacts in a single message.                                   | **Array ([ 1 .. 10 ] items)** <br> * `phone` string [ 6 .. 16 ] characters <br> - required. <br> * `name` string [ 1 .. 40 ] characters <br> - required <br>                                                                             |
| `device()`                                                                                                                            | Device ID to be used for message delivery. If not defined, the first created device will be used by default. You can use this to arbitrary send messages across multiple devices connected to your account. You can get the device ID from the Web Console > Devices                                      | `deviceId` (string required)                                                                                                                                                                                                             |
| `location()`                                                                                                                          | Send location details                                                                                                                                                                                                                                                                                     | **Array ([ 1 .. 10 ] items)** <br> * `address` string [ 3 .. 100 ] characters. <br> * `name` string <= 100 characters characters <br>  * `coordinates` <br> Array of numbers <double> = 2 items [ items <double > [ -180 .. 180 ] ] <br> |
| `expiration()`                                                                                                                        | Define a message time-to-live (ttl) expiration time. Use this if you want to automatically do not send a message if the delivery was not possible after a while. E.g: 1h.                                                                                                                                 | **Object** <br> * `seconds` number <float> [ 5 .. 8035200 ] <br> * `duration` 	string [ 2 .. 5 ] characters  <br>  * `date` <br> string \<date-time> <br>                                                                                |
| `schedule()`   <br> [see example](#send-a-scheduled-messages-with-a-custom-delay)                                                     | Schedule a Message.                                                                                                                                                                                                                                                                                       | `delay`(string required)                                                                                                                                                                                                                 |
| `deliverAt()`  <br> [see example](#send-a-scheduled-messages-at-a-concrete-date-with-a-valid-iso-8601-date)                           | Schedule to a given time.                                                                                                                                                                                                                                                                                 | `ISO_Date` (required)                                                                                                                                                                                                                    |
| `media()`     <br> [see example](#send-media-message-to-user-note-the-file-must-be-updated-first-see-api-endpoint-files--upload-file) | Attach a file.                                                                                                                                                                                                                                                                                            | `file_array`(arrays)      `['file'=>'24 characters length file ID']`                                                                                                                                                                     |
| `buttons()` <br> [see example](#if-you-want-to-attach-action-buttons-to-your-message)                                                 | Add action Buttons.                                                                                                                                                                                                                                                                                       | `butttons_array()` Check documentation                                                                                                                                                                                                   |
| `findById()`   <br> [see example](#getting-a-message)                                                                                 | Get a specific message by ID.                                                                                                                                                                                                                                                                             | `string`                                                                                                                                                                                                                                 |
| `header()`                                                                                                                            | **Experimental**: optional message header text, restricted to messages with reply buttons. **Important**: feature not yet available in Multi-Device enabled WhatsApp sessions. The API will return an error if message type is not supported in your linked WhatsApp number.                              | `string` <= 60 characters <br>                                                                                                                                                                                                           |
| `footer()`                                                                                                                            | **Experimental:** optional message footer text, restricted to messages with reply buttons. **Important:** feature not yet available in Multi-Device enabled WhatsApp sessions. The API will return an error if message type is not supported in your linked WhatsApp number.                              | `string` <= 60 characters <br>                                                                                                                                                                                                           |
| `raw()`                                                                                                                               | Direct use wassenger Api. if you are not satisfy with laraval-wassenger or you can't find what you want here. you can send request directly using this method  **Use**     add desires params     `Messages::raw($paramsArray)->send();`                                                                  | `objects` (required)                                                                                                                                                                                                                     |
| `search()`      <br> [see example]()                                                                                                  | Searching from message list.                                                                                                                                                                                                                                                                              | `arrays` (required)                                                                                                                                                                                                                      |
| `find()`                                                                                                                              | Alternatives for `search()`.                                                                                                                                                                                                                                                                              | `arrays` (required)                                                                                                                                                                                                                      |
| `get()`                                                                                                                               | Get the Specified Resource.                                                                                                                                                                                                                                                                               | `null`                                                                                                                                                                                                                                   |
| `delete()`                                                                                                                            | Delete the specific resource.                                                                                                                                                                                                                                                                             | `string`  `null`                                                                                                                                                                                                                         |
| `send()`                                                                                                                              | This method initailizes and connect to the message to Wassenger endpoint.                                                                                                                                                                                                                                 | `none`                                                                                                                                                                                                                                   |

### Example Usage

#### Send text message to a phone number

```php
Messages::message('+1234567890', 'Hello world! This is a simple test message')
    ->send();
```

#### Send text message with high priority to a group

```php
Messages::messageGroup('123456789000000000@g.us', 'Hello world! This is a simple test message', 'high')
    ->send();
```

#### Send media message to user. Note the file must be updated first, see API endpoint: Files > Upload file

```php
Messages::messageGroup('+1234567890', 'Hello world! This is a test media message.', 'high')
    ->media(['file', '<24 characters length file ID>'])
    ->send();
```
#### Send text message that should be delivered now

```php
Messages::message('+1234567890', 'Hello world! This is a simple test message', false)
    ->send();
```

#### Send a scheduled messages with a custom delay. 
>See "schedule.delayTo" datetime notation shortcuts: https://i.ibb.co/g3DJLSH/datetime-shortcuts.png

```php
Messages::message('+1234567890', 'Hello world! This is a simple test message')
    ->schedule('1h')
    ->send();
```

#### Send a scheduled messages at a concrete date with a valid ISO 8601 date

```php
Messages::message('+1234567890', 'Hello world! This is a simple test message')
    ->deliverAt('2000-01-01T01:00:00+1200')
    ->send();
```

#### If You want to attach action buttons to your message

```php
$buttons = [
    [
         "id" => "id1",
         "kind" => "call",
         "text" => "Call us",
         "value" => "+2348055995704"
    ],
    [
        "id" => "id2",
        "kind" => "url",
        "text" => "Open me",
        "value" => "https://company.com/shop"\
    ],
    [
        "id" => "id3",
        "text" => "Get help"
    ]
];
Messages::message('+1234567890', 'Hello world! This is a simple test message')
    ->buttons($buttons)
    ->send();
```

#### Getting a Message

```php
Messages::findById('635889e9133a76fddfdfy65r5')
    ->get();
```

#### Updating a Message

```php
Messages::findById('635889e9133a76fddfdfy65r5')
    ->message('+1234567890', 'Hello world! This is a simple test message')
    ->update();
```

#### Deleting a Message

```php
Messages::findById('635889e9133a76fddfdfy65r5')
    ->delete();
```
>Alternatively you can delete a message passing the message ID inside the `delete()` mothod with using the `findById()` method
```php
Messages::delete('635889e9133a76fddfdfy65r5');
```


### Device


>To use include the `LaravelWassenger\Device` namespace in your file;
```php
use Alresia\LaravelWassenger\Device;
```
The following available methods are:

| Method                             | Description                                                                                                                                       | Parameters                                                                                                                                                                                        |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `findById()` <br> [see example](#get-device-by-id) | Retrieve device details by ID.                                                                                                                    | @param [String](#params) `$deviceId` *required                                                                                                                                                    |
| `search()` <br>[see example](#search-devices-by-phone-number-alias-or-ids)    | Search devices by phone number, alias or ID. For multiple value searches use comma-separeted values. E.g: +2348113536471,61b37a069cba0c15d6c81000 | @param [String](#params) `$values`                                                                                                                                                                |
| `status()` <br>[see example](#get-only-pending-devices)    | Search devices by status. E.g: operative, pending, disabled, removed                                                                              | @param [String](#params) Default: `"any"` Enum: `"any"` `"invalid"` `"banned"` `"removed"` `"disabled"` `"unpaid`" `"preload"` `"pending"` `"authorized"` `"verified"` `"operative"`              |
| `session()` <br>[see example](#get-device-by-session-online)   | Search devices by session status. E.g: authorize, online, timeout, offline, error                                                                 | @param [String](#params) Enum: `"any"` `"online"` `"offline"` `"timeout"` `"timeout_sync"` `"conflict"` `"blocked"` `"error"` `"authorize"` `"authorizing"` `"new"` `"loading"` `"offline_panel"` |
| `limit()` <br>[see example](#sorting-result)     | Limiting the size of the result and get result by pages. This method helps when working with paginations                                          | @param [String](#params) `$size` <br> <integer\> `[ 0 .. 50 ]` <br> Default: 0 <br>@param [String](#params)  `$page`   <br> \<integer> `[ 1 .. 100 ]` <br> Default: 0                             |
| `get()` <br>[see example](#also-you-can-select-or-use-all-params-incase-not-listed-here-using-the-get)       | Get the Specified Resource.                                                                                                                       | @param [Arrays\|Objects                                                                                                                                                                           | Null](#params) `$data` |

## Examples:

#### Get account devices

```php
Devices::get();
```

#### Get device by ID

```php
Devices::findById('63615bb1db0b686cee2fa4af')->get();
```

#### Search devices by phone number, alias or IDs

```php
Devices::search('+2348113536471,61b37a069cba0c15d6c81000')->get();
```

#### Get only verified devices

```php
Devices::status('verified')->get();
```

#### Get only pending devices
```php
Devices::status('pending')->get();
```

#### Get device by session online

```php
Devices::session('online')->get();
```

#### Get device session

```php
Devices::session('any')->get();
```
#### Search devices by phone number, alias or IDs that is verified

```php
Devices::search('+2348113536471,61b37a069cba0c15d6c81000')->status('verified')->get();
```
#### Search devices by phone number, alias or IDs that is online
```php
Devices::search('+2348113536471,61b37a069cba0c15d6c81000')->session('online')->get();
```
#### Search devices by phone number, alias or IDs that is online
```php
Devices::search('+2348113536471,61b37a069cba0c15d6c81000')->session('online')->get();
```
#### Sorting Result

```php
Devices::limit(20, 2)->get(); // size 20 page 2
```

```php
Devices::search('+2348113536471,61b37a069cba0c15d6c81000')->session('online')->limit(20, 3)->get(); // size 20 page 3
```

>#### All method can be used after another
```php
Devices::session('any')->status('any')->limit(20, 0)->get(); // get() should always be the last
```

#### Also You can select or use all params incase not listed here using the get
```php
Devices::get([
    'search' => '+2348113536471,61b37a069cba0c15d6c81000',
    'status' => 'any',
    'sessionStatus' => 'online',
    'size' => '20',
    'page' => '3',
]); 
```

## Sessions
This function is already exist in other class methods
```php
use Alresia\LaravelWassenger\Session;

Session::sync('63615bb1db0b686cee2fa4af');
```
>see [https://app.wassenger.com/docs/#tag/Devices/operation/searchDevices](https://app.wassenger.com/docs/#tag/Devices/operation/searchDevices) to use this method properly


## Contributing
All Contribution are welcome here. feel free to email me [Fidelis E Peter](mailto:fidelisepeter@gmail.com).

Also you can drop an issue if you observe any

Thank you for considering contributing to the Laravel Wassenger! 

## Package
This package doesn't require any extra packages

You can also use these package for **None Laravel App**


>**NOTE:** Changing host and version either from the Config.php or the wassenger.php is not neccessary unless if you know what you are doing
