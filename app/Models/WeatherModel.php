<?php 
namespace App\Models;

use App\Config;

class WeatherModel
{
    public function getWeather()
    {
        $url = "https://samples.openweathermap.org/data/2.5/weather?zip=18503,us&appid=" . Config::OPEN_WEATHER_KEY;
        return file_get_contents($url);
    }

    public function formatWeather($weather)
    {
        $weather = json_decode($this->getWeather(), true);
        $formatted = array(
            'ID' => $weather['weather'][0]['id'],
            'Icon' => $weather['weather'][0]['icon'],
            'Description' => $weather['weather'][0]['description'],
            'Temp' => ceil($weather['main']['temp'] - 273.5),
            'Humidity' => $weather['main']['humidity'],
            'WindSpeed' => $weather['wind']['speed']);
        return json_encode($formatted);
    }
}