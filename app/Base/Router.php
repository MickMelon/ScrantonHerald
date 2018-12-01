<?php
namespace App\Base;

use App\Controllers;

class Router
{
    /**
     * All controllers and their actions are contained in this array.
    */
    private $controllers = array(
        'page' => ['error', 'rss'],
        'article' => ['index', 'single', 'create', 'submit_create', 'upload_image'],
        'evaluation' => ['index'],
        'login' => ['index', 'login', 'logout', 'success'],
        'register' => ['index', 'register', 'success'],
        'sensor' => ['store', 'store_test']);

    public function start()
    {
        /**
         * Set the controller and action depending on the parameters
         * that are set.
         * e.g. index.php?controller=articles&action=index
         * would set $controller to articles and $action to index
        */
        if (isset($_GET['controller']) && isset($_GET['action']))
        {
            $controller = $_GET['controller'];
            $action = $_GET['action'];
        }
        else
        {
            $controller = 'article';
            $action = 'index';
        }

        /**
        * Check if the specified controller and action are valid then call
        * it or the error page.
        */
        if (array_key_exists($controller, $this->controllers))
            if (in_array($action, $this->controllers[$controller]))
                $this->call($controller, $action);
            else
                $this->call('page', 'error');
        else
            $this->call('page', 'error');
    }

    /**
    * Call the specified controller and execute the method corresponding
    * with the action name.
    */
    function call($controller, $action)
    {
        //require_once('app/controllers/' . $controller . 'controller.php');

        switch ($controller)
        {
            case 'article':
                $controller = new Controllers\ArticleController();
                break;

            case 'evaluation':
                $controller = new Controllers\EvaluationController();
                break;

            case 'page':
                $controller = new Controllers\PageController();
                break;

            case 'login':
                $controller = new Controllers\LoginController();
                break;

            case 'register':
                $controller = new Controllers\RegisterController();
                break;

            case 'sensor':
                $controller = new Controllers\SensorController();
                break;
        }

        $controller->{ $action }();
    }
}
