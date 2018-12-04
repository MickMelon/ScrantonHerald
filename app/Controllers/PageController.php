<?php
namespace App\Controllers;

use App\View;
use App\Config;
use DOMDocument;
use XSLTProcessor;

class PageController
{
    /**
    * Displays the error page.
    */
    public function error()
    {
        $view = new View('Pages/error');
        $view->render();
    }

    /**
     * Displays the RSS feed page.
     */
    public function our_rss()
    {
        $scrantonFeedUrl = "http://localhost:8080/uni/public/rss/newsfeed.xml";
        $feed = simplexml_load_file($scrantonFeedUrl);

        $view = new View('Pages/rss');
        $view->assign('pageTitle', 'RSS Feed');
        $view->assign('feedTitle', $feed->channel[0]->title);
        $view->assign('feedDescription', $feed->channel[0]->description);
        $view->assign('items', $feed->channel[0]->item);
        $view->render();
    }

    public function external_rss()
    {
        $xml = new DOMDocument();
        $xml->load('http://rss.cnn.com/rss/edition_us.rss');

        $xsl = new DOMDocument();
        $xsl->load('public/xsl/cnn.xsl');

        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xsl);
        
        $transformedXml = $proc->transformToXML($xml);

        $view = new View('Pages/external_rss');
        $view->assign('pageTitle', 'External RSS');
        $view->assign('feed', $transformedXml);
        $view->render();
    }

    public function rest()
    {
        $url = "https://samples.openweathermap.org/data/2.5/weather?zip=18503,us&appid=" . Config::OPEN_WEATHER_KEY;
        $response = file_get_contents($url);
        $weatherData = json_decode($response, true);

        $view = new View('Pages/rest');
        $view->assign('pageTitle', 'Rest');
        $view->assign('icon', $weatherData['weather'][0]['icon']);
        $view->assign('weather', $weatherData['weather'][0]['description']);
        $view->assign('temp', $weatherData['main']['temp'] - 273.5); // Convert from K to C
        $view->assign('humidity', $weatherData['main']['humidity']);
        $view->assign('windSpeed', $weatherData['wind']['speed']);
        $view->render();
    }
}
