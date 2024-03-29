<?php
namespace App;

use App\Controllers;

class Router
{
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

        // Check to see if the class and method exist, if they do, call it.
        $className = 'App\Controllers\\' . ucfirst($controller) . 'Controller';

        if (class_exists($className, true))  
        {
            $controllerClass = new $className();
            if (method_exists($controllerClass, $action))
            {
                $controllerClass->{ $action }();
                return;
            }    
        }

        // Call the index of the article controller if the specified 
        // controller or action were not found.
        $pageController = new Controllers\PageController();
        $pageController->error();             
    }
}
