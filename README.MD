# Laravel Wassenger

WhatsApp Business Api for Larave Using Wassenger Api
![laravel-wassenger-logo](https://user-images.githubusercontent.com/42520408/197910318-c42baeae-9799-4b43-8bc1-94bf3cdd95cb.png)
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
        'api_version' => 1
    ],
    'http_client' => [
        'return_json_errors' => false,
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


if you want the application to return a Json response instead of an Error Exception
<br>
Change the `return_json_errors` to true from the config file

```php
'http_client' => [
        'return_json_errors' => true,
    ],
```

## Sending Messages

To use include the `LaravelWassenger\Wassenger` class in your controller;
```php
use Alresia\LaravelWassenger\Wassenger;
```

The following available methods for sending messages in this package, which you can [See the full details here](https://app.wassenger.com/docs/#tag/Messages):

| Method           | Description                                                               | Parameters                                                                                        |
| ---------------- | ------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------- |
| `message()`      | Use to attached text and user phone number.                               | `phone`(string:requires) , `message`  (string:required), `enqueue` (bool:optional)(default:false) |
| `messageGroup()` | message a group.                                                          | `group_id`(string:requires) , `message`  (string:required), `enqueue` (bool:optional)             |
| `schedule()`     | Schedule a Message.                                                       | `delay`(string required)                                                                          |
| `deliverAt()`    | Schedule to a given time.                                                 | `ISO_Date` (required)                                                                             |
| `media()`        | Attach a file.                                                            | `file_array`(arrays)      `['file'=>'24 characters length file ID']`                              |
| `buttons()`      | Add action Buttons.                                                       | `butttons_array()` Check documentation                                                            |
| `findById()`     | Get a specific message by ID.                                             | `string`                                                                                          |
| `search()`       | Searching from message list.                                              | `arrays` (required)                                                                               |
| `find()`         | Alternatives for `search()`.                                              | `arrays` (required)                                                                               |
| `get()`          | Get the Specific Resource.                                                | `null`                                                                                            |
| `delete()`       | Delete the specific resource.                                             | `string`  `null`                                                                                  |
| `send()`         | This method initailizes and connect to the message to Wassenger endpoint. | `none`                                                                                            |

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

### Getting a Message

```php
Wassenger::findById('635889e9133a76fddfdfy65r5')
    ->get();
```

### Updating a Message

```php
Wassenger::findById('635889e9133a76fddfdfy65r5')
    ->message('+1234567890', 'Hello world! This is a simple test message')
    ->update();
```

### Deleting a Message

```php
Wassenger::findById('635889e9133a76fddfdfy65r5')
    ->delete();
```
Alternatively you can delete a message passing the message ID inside the `delete()` mothod with using the `findById()` method
```php
Wassenger::delete('635889e9133a76fddfdfy65r5');
```


## Contributing
All Contribution are welcome here. feel free to email me [Fidelis E Peter](mailto:fidelisepeter@gmail.com).

Also you can drop an issue if you observe any

Thank you for considering contributing to the Laravel Wassenger! 

## Package
This package doesn't require any extra packages

You can also use these package for **None Laravel App**

if you want to use it for non Laravel Application head over to

```
laravel-wassenger\src\Config.php

```
to Setup Config

```php
public const API_KEY = '';
public const API_HOST = 'https://api.wassenger.com';
public const API_VERSION = 1;

public const RETURN_JSON_ERRORS = false;
```

