<?php

namespace App\Exceptions;

use Exception;

class UnknownStatusException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string|null  $message
     * @return void
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?? 'Status does not exist.');
    }
}
