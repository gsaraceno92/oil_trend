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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Method Not Allowed', true, 405);
  echo "GET method requests are not accepted for this resource";
  exit;
}

$requestData = json_decode(file_get_contents('php://input'), true);


$validator = new Validator($requestData);
$validation = $validator->handleRequest();

if (!empty($validation)) {
    echo $validation->asString();
    die();
}

$request = $validator->getRequest();
$oil_trend = new OilTrend();

$server = new Server($oil_trend);
$response = $server->handleRequest($request);

die($response->asString());
