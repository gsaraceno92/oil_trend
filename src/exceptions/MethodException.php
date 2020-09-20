<?php 

namespace Saraceno\JsonRpc\Exceptions;

use Exception;
use Saraceno\JsonRpc\Services\Response;

class MethodException extends Exception
{
    public function __construct()
    {
        parent::__construct('Method not found', Response::METHOD_NOT_FOUND);
    }

    public function setMessage($message){
        $this->message = $message;
    }
}