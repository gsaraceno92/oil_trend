<?php

require_once 'vendor/autoload.php';
include("controllers/OilTrend.php");
include("services/Request.php");
include("services/jsonRpcServer.php");
include("services/Validator.php");


use Saraceno\JsonRpc\Controllers\OilTrend;
use Saraceno\JsonRpc\Services\JsonRpcServer as Server;
use Saraceno\JsonRpc\Services\Validator;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$requestData = json_decode(file_get_contents('php://input'), true);


$validator = new Validator($requestData);
$validation = $validator->handleRequest();

if (!empty($validation)) 
    die($validation->asString());

$request = $validator->getRequest();
$oil_trend = new OilTrend();

$server = new Server($oil_trend);
$response = $server->handleRequest($request);

// die($response->asString());
print_r($response->asArray());
// var_dump( $response->asArray());