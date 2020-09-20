<?php

namespace Saraceno\JsonRpc\Controllers;
include("TrendManager.php");

use GuzzleHttp\Client as GuzzleClient;
use Saraceno\JsonRpc\Services\Request;
use Saraceno\JsonRpc\Exceptions\MethodException;

class OilTrend implements TrendManager
{
    public function GetOilPriceTrend()
    {
        $client = new GuzzleClient();
        $res = $client->request('GET', $_ENV['ENDPOINT_URL']);

        return (string) $res->getBody();
    }

    public function evaluate($method)
    {
        if ($method !== 'GetOilPriceTrend') 
            throw new MethodException();
        return;
    }

    public function invoke(Request $request)
    {
        $method = $request->getMethod();
        try {
            $this->evaluate($method);
        } catch (MethodException $exception) {
            throw new MethodException();
        }

        return $this->$method();
    }
}