<?php
namespace App\Controllers;

use App\Models\SensorModel;
use App\Config;

class SensorController
{
    const DEVICE_ID = '233dce4dead3dbee';

    private $sensorModel;

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
    }

    /**
     * Receives and stores the data sent from the 
     * electric imp.
     */
    public function store()
    {
        // Get the json data from the electric imp
        $jsonbody = file_get_contents('php://input');

        // Decode the json so we can see if the device id is ours
        $json = json_decode($jsonbody, false);

        if ($json[0]['device'] != SensorController::DEVICE_ID)
            return;

        $this->sensorModel->saveData($jsonbody);
    }

    /**
     * This function simulates sending the data from the 
     * electric imp server.
     */
    public function store_test()
    {
        $post_data = array('device' => '233dce4dead3dbee',
                           'external' => '27.0',
                           'internal' => '28.0');

        $post_data = json_encode($post_data);

        $url = 'http://localhost:8080/uni/index.php?controller=sensor&action=store';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data))
        );

        $response = curl_exec( $ch );
    }

    public function get()
    {
        if (in_array($_SERVER['SERVER_NAME'], Config::ALLOWED_SERVERS))
        {
            $sensorData = $this->sensorModel->getAllData();
            header("content-type: application/json");
            echo $sensorData;
        }
        else 
        {
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'You are not an authorised host.', 'code' => 500)));
        }
    }
}
