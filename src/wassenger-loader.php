<?php

require __DIR__.'/Exceptions/LaravelWassengerException.php';
require __DIR__.'/Exceptions/LaravelWassengerInvalidApiKey.php';
require __DIR__.'/WassengerApiEndpoints.php';
require __DIR__.'/Traits/WassengerRequest.php';
require __DIR__.'/Traits/Messages.php';
require __DIR__.'/Wassenger.php';
require __DIR__.'/Messages.php';
require __DIR__.'/Session.php';
require __DIR__.'/Device.php';
require __DIR__.'/Config.php';

/** To easily access the config file copy Config.php 
 *  at /path-to-laravelWassenger/src/Config.php to 
 *  your prefered location. Then Call the config File Here 
 */

// require __DIR__.'/../Config.php'; //Example

