<?php 
namespace App\Controllers;

use App\Models\WeatherModel;
use App\Config;

class WeatherController 
{
    private $weatherModel;

    public function __construct()
    {
        $this->weatherModel = new WeatherModel();
    }

    /**
     * Gets the latest weather forecast from the open weather api.
     */
    public function get()
    {
        if (in_array($_SERVER['SERVER_NAME'], Config::ALLOWED_SERVERS))
        {
            $forecast = $this->weatherModel->getFormattedForecast();
            header("content-type: application/json");
            echo $forecast;
        }
        else 
        {
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'You are not an authorised host.', 'code' => 500)));
        }
    }
}