1.0.0 (2022-10-26)
------------------

* Official Release.

1.1.0 (2022-11-01)
------------------

* Added Extra Wassenger Endpoint.
* Added New Messages Class `Alresia\LaravelWassenger`
  <br>
  Messaging functions can also be called with
```php

Messages::message()->send();

```
* Added function to Check if number exist
```php
Wassenger::numberExist('+1234567890');

```

* Added Auto Checking Number before executing `send()`