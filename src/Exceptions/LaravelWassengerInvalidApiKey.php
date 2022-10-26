<?php
namespace Alresia\LaravelWassenger\Exceptions;

use Alresia\LaravelWassenger\Exceptions\LaravelWassengerException;

/**
 * Laravel Wassenger Exception Handler.
 *
 */
class LaravelWassengerInvalidApiKey extends LaravelWassengerException
{
    /**
     * Prettify error message output.
     *
     * @return string
     */

    
     
    public function errorMessage()
    {
        return '<strong>' . htmlspecialchars($this->getMessage(), ENT_COMPAT | ENT_HTML401) . "</strong><br />\n";
    }
}
