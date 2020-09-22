<?php 

namespace Saraceno\JsonRpc\Exceptions;

use Exception;
use Saraceno\JsonRpc\Services\Response;

class MethodException extends Exception
{
    protected $message = 'Method not found';

    public function __construct($message = null)
    {
        $message = is_null($message) ? $this->message : $message;
        parent::__construct($message, Response::METHOD_NOT_FOUND);
    }

    public function setMessage($message){
        $this->message = $message;
    }
}