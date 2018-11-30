<?php
namespace App\Controllers;

use App\Models\SensorModel;

class SensorController
{
    const DEVICE_ID = '233dce4dead3dbee';

    private $sensorModel;

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
    }

    public function store()
    {
        $this->sensorModel->saveData("here");
        // Get the json data from the electric imp
        $jsonbody = file_get_contents('php://input');
        //file_put_contents("test.txt", "someone tried to send something");
        // Decode the json so we can see if the device id is ours
        $json = json_decode($jsonbody, false);

        //file_put_contents("test.txt", $json['device']);
        if ($json[0]['device'] != SensorController::DEVICE_ID)
        {
            $this->sensorModel->saveData("test");
            return;
        }


        $this->sensorModel->saveData($jsonbody);
    }

    public function store_test()
    {
        $post_data = array('device' => '233dce4dead3dbee',
                           'external' => '27.0',
                           'internal' => '28.0');

        $post_data = json_encode($post_data);

        $url = 'http://localhost:8080/uni/index.php?controller=sensor&action=store';
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data))
        );

        $response = curl_exec( $ch );

        echo 'hey';
    }
}
