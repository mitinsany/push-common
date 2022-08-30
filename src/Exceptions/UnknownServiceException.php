<?php

namespace MitinSany\PushCommon\Exceptions;

use Exception;
use Throwable;

class UnknownServiceException extends Exception
{
    public function __construct($transport, $code = 0, Throwable $previous = null)
    {
        $message = "Unknown transport: $transport";
        parent::__construct($message, $code, $previous);
    }
}