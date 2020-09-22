<?php 

namespace Saraceno\JsonRpc\Exceptions;

use Exception;
use Saraceno\JsonRpc\Services\Response;

class InvalidArgumentException extends Exception
{
    protected $message = 'Invalid argument.';

    public function __construct($message = null)
    {
        parent::__construct($message, Response::INVALID_ARGUMENTS);
    }

    public function setMessage($message){
        $this->message = $message;
    }
}