<?php

namespace Saraceno\JsonRpc\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Saraceno\JsonRpc\Services\Validator;
use Saraceno\JsonRpc\Controllers\OilTrend;
use Saraceno\JsonRpc\Services\JsonRpcServer;
use Saraceno\JsonRpc\Services\Response;

class OilTrendTest extends TestCase
{
    private $request;
    public function setup(): void
    {
        parent::setup();
        $data = [
            "jsonrpc" => "2.0",
            "id" => 1,
            "method" => "GetOilPriceTrend",
            "params" => []
        ];

        $validator = new Validator($data);
        $validator->handleRequest();

        $this->request = $validator->getRequest();
    }

    /**
     * @test
     */
    public function validationKeyTest()
    {
        $controller = new OilTrend();
        $server = new JsonRpcServer($controller);
        $response = $server->handleRequest($this->request);

        $this->assertEquals(Response::INVALID_ARGUMENTS, $response->getCode());
        $this->assertEquals("Invalid param(s), the required param are: 'startDateISO8601' and 'endDateISO8601'", $response->getMessage());
    }

    /**
     * @test
     */
    public function validationDateTest()
    {
        $controller = new OilTrend();
        $server = new JsonRpcServer($controller);
        $request = $this->request->withParams([
            "startDateISO8601" => "2020-21-01",
            "endDateISO8601" => "2020-01-15"
        ]);
        $response = $server->handleRequest($request);

        $this->assertEquals(Response::INVALID_ARGUMENTS, $response->getCode());
        $this->assertEquals("Invalid param format, it should be a valid date 'Y-m-d'", $response->getMessage());
    }

    /**
     * @test
     */
    public function notificationTest()
    {
        $controller = new OilTrend();
        $server = new JsonRpcServer($controller);

        $request = $this->request->withId(null);
        $response = $server->handleRequest($request);

        $this->assertEquals("", $response->asString());
    }
}