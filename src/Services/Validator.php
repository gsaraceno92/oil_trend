<?php

namespace Saraceno\JsonRpc\Services;

use Saraceno\JsonRpc\Exceptions\MethodException;
use Saraceno\JsonRpc\Exceptions\InvalidArgumentException;
use Saraceno\JsonRpc\Services\Request;

class Validator
{
    /** @var array */
    private $data;
    private Request $request;
    
    protected $error;
    
    private const VERSION = '2.0';

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    private static function validateData($data)
    {
        if (!array_key_exists('jsonrpc', $data)) {
            throw new InvalidArgumentException('Missing jsonrpc member');
        }
        if ($data['jsonrpc'] !== self::VERSION) {
            throw new InvalidArgumentException('Member jsonrpc must be exactly "2.0"');
        }

        if (!array_key_exists('method', $data)) {
            throw new InvalidArgumentException('Missing method member');
        }
    }
    
    public function handleRequest()
    {
        try {
            self::validateData($this->data);
            $request = Request::getRequest($this->data);
        } catch (InvalidArgumentException $exception) {
            $this->error = new Response($this->data['id'], Response::INVALID_REQUEST, [], $exception->getMessage());
            return;
        } catch (MethodException $exception) {
            $this->error = new Response($this->data['id'], Response::INVALID_ARGUMENTS, [], $exception->getMessage());
            return;
        }
        
        $this->request = $request;

        return;

    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function error()
    {
        return !!$this->error;
    }

    public function responseError()
    {
        return $this->error;
    }
}