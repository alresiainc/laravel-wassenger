<?php
namespace Alresia\LaravelWassenger\Exceptions;

/**
 * Laravel Wassenger Exception Handler.
 *
 */
class LaravelWassengerException extends \Exception
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