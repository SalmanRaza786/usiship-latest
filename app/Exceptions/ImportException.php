<?php

namespace App\Exceptions;

use Exception;

class ImportException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
