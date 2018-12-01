<?php
namespace App\Controllers;

use App\View;

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
    public function rss()
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
}
