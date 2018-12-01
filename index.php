<?php
/**
* This index page acts as the entry point to the web application.
*
* Include the config and db files as these will be required for most
* requests. Then include the router file to effectively start the app.
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
