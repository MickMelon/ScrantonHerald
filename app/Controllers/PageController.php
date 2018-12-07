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
        $view->assign('feedTitle', $feed->channel->title);
        $view->assign('feedDescription', $feed->channel->description);
        $view->assign('items', $feed->channel->item);
        $view->render();
    }

    /**
     * Displays the external RSS feed page. 
     * (CNN US News)
     */
    public function external_rss()
    {
        $xml = new DOMDocument();
        $xml->load('http://rss.cnn.com/rss/edition_us.rss');

        $xsl = new DOMDocument();
        $xsl->load('public/xsl/cnn.xsl');

        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xsl);
        
        echo $proc->transformToXML($xml);
        return;

        $view = new View('Pages/external_rss');
        $view->assign('pageTitle', 'External RSS');
        $view->assign('feed', $transformedXml);
        $view->render();
    }
}
