<?php
require_once('../vendor/autoload.php');
use App\Models\WeatherModel;

$weatherModel = new WeatherModel();
$forecast = $weatherModel->getFormattedForecast();

$allowedServers = array('mayar.abertay.ac.uk', 'localhost', '192.168.1.17');

if (in_array($_SERVER['SERVER_NAME'], $allowedServers))
{
    header("content-type: application/json");
    echo $forecast;
}
else 
{
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'You are not an authorised host.', 'code' => 500)));
}

