<?php

namespace Saraceno\JsonRpc\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Saraceno\JsonRpc\Services\Validator;

class ValidatorTest extends TestCase
{
    protected $data = [
        "jsonrpc" => "2.0",
        "id" => 1,
        "method" => "GetOilPriceTrend",
        "params" => []
    ];
    /**
     * @test
     */
    public function jsonRpcTest()
    {
        unset($this->data['jsonrpc']);
        $validator = new Validator($this->data);
        $validator->handleRequest();
        $res = $validator->responseError();
        $this->assertTrue($validator->error());
        $this->assertEquals("Missing jsonrpc member", $res->getMessage());
    }

    /**
     * @test
     */
    public function jsonRpcVersionTest()
    {
        $this->data['jsonrpc'] = "1.0";
        $validator = new Validator($this->data);
        $validator->handleRequest();
        $res = $validator->responseError();
        $this->assertTrue($validator->error());
        $this->assertEquals('Member jsonrpc must be exactly "2.0"', $res->getMessage());
    }

    /**
     * @test
     */
    public function methodTest()
    {
        unset($this->data['method']);
        $validator = new Validator($this->data);
        $validator->handleRequest();
        $res = $validator->responseError();

        $this->assertTrue($validator->error());
        $this->assertEquals('Missing method member', $res->getMessage());
    }
}