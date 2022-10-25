# Laravel Wassenger

WhatsApp Business Api for Larave Using Wassenger Api

For more info about Wassenger follow https://www.wassenger.com/

## Installation by console

``` bash
composer require alresia/laravel-wassenger
```



## Advanced Configuration

Laravel Wassenger was made to work out-of-the-box, but you can override the configuration by simply publishing the config file.

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
        'device_id' => env('WASSENGER_DEVICE_ID'),
    ],

    'http_client' => [
        'timeout' => 60,
    ],
];
```

### Api Keys
Head over to your .env file and add your Api Key, Device ID 
The WASSENGER_API_KEY is Required

To get Your API KEY go to [Wassanger Console](https://app.wassenger.com/apikeys) add Get a Api Key

```php
WASSENGER_API_KEY=<YOUR_KEY_HERE>
```

if you want to add your device ID you can do so by adding to .env file

```php
WASSENGER_DEVICE_ID=<YOUR_DEVICE_ID_HERE>
```

## Sending Messages

To use include the `LaravelWassenger\Wassenger` class in your controller;
```php
use Alresia\LaravelWassenger\Wassenger;
```

The following available methods for sending messages in this package, which you can [See the full details here](https://app.wassenger.com/docs/#tag/Messages):

| Method           | Description                                               | Parameters                                                                                        |
| ---------------- | --------------------------------------------------------- | ------------------------------------------------------------------------------------------------- |
| `message()`      | Use to attached text and user phone number.               | `phone`(string:requires) , `message`  (string:required), `enqueue` (bool:optional)(default:false) |
| `bulkMessage()`  | Attach a text with multiple numbers.                      |                                                                                                   |
| `messageGroup()` | message a group.                                          |                                                                                                   |
| `schedule`       | Schedule a Message.                                       |                                                                                                   |
| `deliverAt`      | Schedule to a given time.                                 |                                                                                                   |
| `media`          | Attach a file.                                            |                                                                                                   |
| `buttons`        | Add action Buttons.                                       |                                                                                                   |
| `send`           | The Method Use to send the message to Wassenger endpoint. |                                                                                                   |

# Example Usage

### Send text message to a phone number

```php
Wassenger::message('+1234567890', 'Hello world! This is a simple test message')
    ->send();
```

### Send text message with high priority to a group

```php
Wassenger::messageGroup('123456789000000000@g.us', 'Hello world! This is a simple test message', 'high')
    ->send();
```

### Send media message to user. Note the file must be updated first, see API endpoint: Files > Upload file

```php
Wassenger::messageGroup('+1234567890', 'Hello world! This is a test media message.', 'high')
    ->media(['file', '<24 characters length file ID>'])
    ->send();
```
### Send text message that should be delivered now

```php
Wassenger::message('+1234567890', 'Hello world! This is a simple test message', false)
    ->send();
```

### Send a scheduled messages with a custom delay. See "schedule.delayTo" datetime notation shortcuts: https://i.ibb.co/g3DJLSH/datetime-shortcuts.png

```php
Wassenger::message('+1234567890', 'Hello world! This is a simple test message')
    ->schedule('1h')
    ->send();
```

### Send a scheduled messages at a concrete date with a valid ISO 8601 date

```php
Wassenger::message('+1234567890', 'Hello world! This is a simple test message')
    ->deliverAt('2000-01-01T01:00:00+1200')
    ->send();
```

### If You want to attach action buttons to your message

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

Wassenger::message('+1234567890', 'Hello world! This is a simple test message')
    ->buttons($buttons)
    ->send();
```



## Contributing

Thank you for considering contributing to the Laravel Wassenger! 

