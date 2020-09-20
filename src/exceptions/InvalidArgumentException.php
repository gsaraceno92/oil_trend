<?php 

namespace Saraceno\JsonRpc\Exceptions;

use Exception;
use Saraceno\JsonRpc\Services\Response;

class InvalidArgumentException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid argument.', Response::INVALID_ARGUMENTS);
    }

    public function setMessage($message){
        $this->message = $message;
    }
}