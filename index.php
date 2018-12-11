<?php
/**
* This index page acts as the entry point to the web application.
*
* Composer's autoloader is included which loads up all the classes
* required for the application. 
*
* The router is then started which will result in the desired page
* being displayed.
*/

session_start();

require_once('vendor/autoload.php');

use App\Config;
use App\Router;
use App\Util;

if (Config::DISPLAY_ERRORS)
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

$router = new Router();
$router->start();