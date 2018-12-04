<?php 
namespace App\Models;

use App\Config;
use DateTime;

class WeatherModel
{
    public function getWeather()
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?zip=18503,us&appid=" . Config::OPEN_WEATHER_KEY;
        return file_get_contents($url);
    }

    public function getFormattedWeather()
    {
        return $this->formatWeather($this->getWeather());
    }

    public function formatWeather($weather)
    {
        $weather = json_decode($weather, true);
        
        $formatted = array(
            'ID' => $weather['weather'][0]['id'],
            'Icon' => $weather['weather'][0]['icon'],
            'Description' => $weather['weather'][0]['description'],
            'Temp' => ceil($weather['main']['temp'] - 273.5),
            'Humidity' => $weather['main']['humidity'],
            'WindSpeed' => $weather['wind']['speed'],
            'DateTime' => date("Y-m-d H:i:s", substr($weather['dt'], 0, 10))
        );

        return json_encode($formatted);
    }

    public function getForecast()
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?zip=18503,us&appid=" . Config::OPEN_WEATHER_KEY;
        return file_get_contents($url);
    }

    public function getFormattedForecast()
    {
        $forecast = json_decode($this->getForecast(), true);
        $formatted = array();

        for ($i = 0; $i < 5; $i++)
        {
            $formatted[$i] = $this->formatWeather(json_encode($forecast['list'][$i]));
            $formatted[$i] = json_decode($formatted[$i], true);
        }

        return json_encode($formatted);
    }

    public function formatForecast($forecast)
    {

    }
}