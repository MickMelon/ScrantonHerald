<?php
namespace App;

use App\Controllers;

class Router
{
    /**
     * All controllers and their actions are contained in this array.
     */
    private $controllers = array(
        'page' => ['error', 'rss'],
        'article' => ['index', 'single', 'create', 'submit_create', 'upload_froala_image', 'create_success'],
        'evaluation' => ['index'],
        'login' => ['index', 'login', 'logout', 'success'],
        'register' => ['index', 'register', 'success'],
        'sensor' => ['store', 'store_test']);

    /**
     * Gets the specified controller and action and acts on it to 
     * effectively start the app.
     */
    public function start()
    {
        // Set the controller and action depending on the parameters
        // that are set.
        // e.g. index.php?controller=articles&action=index
        // would set $controller to articles and $action to index
        $controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'article';
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';

        // Check if the specified controller and action are valid then call
        // it or the error page.
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
    private function call($controller, $action)
    {
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

            default:
                $controller = new Controllers\PageController();
                $action = 'error';
                break;
        }

        $controller->{ $action }();
    }
}
