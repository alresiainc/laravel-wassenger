<?php
namespace Alresia\LaravelWassenger;

use Illuminate\Support\Facades\Facade;

class LaravelWassengerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-wassenger';
    }
}
