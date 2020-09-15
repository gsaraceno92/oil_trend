<?php

include("controllers/OilTrend.php");

use Saraceno\JsonRpc\Controllers\OilTrend;

echo "Hello from the docker yooooo container";

$oil_trend_list = new OilTrend();

echo json_encode($oil_trend_list);
