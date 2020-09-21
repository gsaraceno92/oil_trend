<?php

namespace Saraceno\JsonRpc\Controllers;
include("TrendManager.php");

use DateTime;
use GuzzleHttp\Client as GuzzleClient;
use Saraceno\JsonRpc\Services\Request;
use Saraceno\JsonRpc\Exceptions\MethodException;
use Saraceno\JsonRpc\Exceptions\InvalidArgumentException;
use stdClass;

class OilTrend implements TrendManager
{
    /**
     * Get data from api filtering by date params
     *
     * @param Request $request
     * @return array
     */
    public function GetOilPriceTrend(Request $request)
    {
        $params = $request->getParams();
        
        if (!$this->validateParams($params)) {
            throw new InvalidArgumentException("Invalid param(s), the required param are: 'startDateISO8601' and 'endDateISO8601'");
        }
        $startDate = $params['startDateISO8601'];
        $endDate = $params['endDateISO8601'];
        if (!self::validateDate($startDate) || !self::validateDate($endDate)) {
            throw new InvalidArgumentException("Invalid param format, it should be a valid date");
        }

        $client = new GuzzleClient();
        $res = $client->request('GET', $_ENV['ENDPOINT_URL']);
        $body = json_decode($res->getBody());

        $filtered_data = array_values(array_filter($body, function($detail) use ($startDate, $endDate) {
            $price_date = strtotime($detail->Date);
            return $price_date >= strtotime($startDate) && $price_date <= strtotime($endDate);
        }));

        $data = array_map(function($detail) {
            $ele['dateISO8601'] = $detail->Date;
            $ele['price'] = round($detail->Price, 1);
            return $ele;
        }, $filtered_data);

        return ['prices' => $data];
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

        return $this->$method($request);
    }

    private function validateParams(array $params)
    {

        $keys = ['startDateISO8601', 'endDateISO8601'];
        // echo json_encode(array_diff($keys,  array_keys($params)))  , json_encode(array_diff(array_keys($params), $keys));
        if (!empty(array_diff($keys,  array_keys($params))) || !empty(array_diff(array_keys($params), $keys))) {
            return false;
        }
        return true;
    }

    private static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.

        return $d && $d->format($format) === $date;
    }

}