<?php

namespace Saraceno\JsonRpc\Controllers;

use Saraceno\JsonRpc\Services\Request;

interface TrendManager 
{
    public function evaluate(string $method);

    public function invoke(Request $request);

}

?>