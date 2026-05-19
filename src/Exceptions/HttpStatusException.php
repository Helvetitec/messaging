<?php

namespace Helvetitec\Messaging\Exceptions;

use Exception;
use Throwable;

class HttpStatusException extends Exception
{   
    public function __construct(public int $statusCode, string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}