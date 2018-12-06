<?php
require_once('../vendor/autoload.php');

use App\Models\SensorModel;

/**
* Displays all the sensor data in a viewable json format in the browser.
*/
header('Content-Type: application/json');
$sensorModel = new SensorModel();
echo $sensorModel->getAllData();
?>
