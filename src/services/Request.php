<?php

namespace Saraceno\JsonRpc\Services;
include("exceptions/InvalidArgumentException.php");

use Saraceno\JsonRpc\Exceptions\MethodException;
use Saraceno\JsonRpc\Exceptions\InvalidArgumentException;

class Request
{
    /** @var string */
    private $method;
    /** @var array */
    private $params = [];
    /** @var string|int|null */
    private $id;

    /**
     * @param string $method
     */
    public function __construct($method)
    {
        if (!is_string($method)) {
            throw new MethodException('Method member should be a string');
        }
        $this->method = $method;
    }

    /**
     * @param array $data
     * @return Request
     */
    public static function getRequest(array $data)
    {

        $Request = new self($data['method']);
        if (array_key_exists('params', $data)) {
            $Request->setParams($data['params']);
        }
        if (array_key_exists('id', $data)) {
            $Request->setId($data['id']);
        }
        return $Request;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * @param array $params
     * @return Request
     */
    public function withParams($params)
    {
        $Clone = clone $this;
        $Clone->setParams($params);

        return $Clone;
    }

    /**
     * @param array $params
     */
    private function setParams($params)
    {
        if (!is_array($params)) {
            throw new InvalidArgumentException('Member params should be either an object or an array');
        }
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string|int|null $id
     * @return Request
     */
    public function withId($id)
    {
        $Clone = clone $this;
        $Clone->setId($id);

        return $Clone;
    }

    /**
     * @param string|int|null $id
     */
    private function setId($id)
    {
        if (!is_scalar($id) && !is_null($id)) {
            throw new InvalidArgumentException('Member id should be either a string, number or Null');
        }
        $this->id = $id;
    }

    /**
     * @return string|int|null
     */
    public function getId()
    {
        return $this->id;
    }
}