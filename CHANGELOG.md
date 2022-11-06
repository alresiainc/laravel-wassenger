1.2.0 (2022-11-06)
------------------

Added More Features
* Added New Devices Class `Alresia\LaravelWassenger\Devices`
  
  *Allows you view and synchronize device*

1.1.1 (2022-11-05)
------------------


* Fix Minor Bug.
* Added New Session Class `Alresia\LaravelWassenger\Session`
  <br>
  The Session Class Can Be Used to Sync Device Sessions for now
  `More update Coming...`
  Usage
```php

Session::sync('deviceId');

```
it can also be called from Wassenger Main Class `Alresia\LaravelWassenger\Wassenger`
```php
Wassenger::sessionSync('deviceId');

```


1.1.0 (2022-11-01)
------------------

* Added Extra Wassenger Endpoint.
* Added New Messages Class `Alresia\LaravelWassenger\Messages`
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
  



1.0.0 (2022-10-26)
------------------

* Official Release.
