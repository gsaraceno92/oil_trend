<?php

namespace Saraceno\JsonRpc\Controllers;
include("TrendManager.php");

class OilTrend implements TrendManager
{
    public function index($request)
    {
        return $request;
    }
}