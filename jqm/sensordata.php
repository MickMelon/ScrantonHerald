<?php
require_once('../app/Base/Config.php');
require_once('../app/Base/Database.php');
require_once('../app/Models/SensorModel.php');

use App\Base\Config;
use App\Models\SensorModel;

$config = new Config();
$config->init();

/**
* Displays all the sensor data in a viewable json format in the browser.
*/
header('Content-Type: application/json');
$sensorModel = new SensorModel();
echo $sensorModel->getAllData();
?>
