<?php
/**
* This index page acts as the entry point to the web application.
*
* Include the config and db files as these will be required for most
* requests. Then include the router file to effectively start the app.
*/
session_start();

require_once('vendor/autoload.php');

use App\Base\Config;
use App\Base\Router;
use App\Base\Util;

$config = new Config();
$config->init();

$router = new Router();
$router->start();
