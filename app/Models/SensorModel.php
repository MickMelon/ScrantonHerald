<?php
namespace App\Models;

use App\Database;
use PDO;

class SensorModel
{
    /**
     * Saves the sensor data to the database.
     */
    public function saveData($jsonData)
    {
        $db = Database::getInstance();

        $sql = 'INSERT INTO `SensorData` (`DateTime`, `JsonData`) ' .
               'VALUES (CURRENT_TIMESTAMP, :jsonData)';
        $query = $db->prepare($sql);
        $query->bindParam(':jsonData', $jsonData, PDO::PARAM_STR);

        $query->execute();
    }

    /**
     * Gets all the sensor data from the database.
     */
    public function getAllData()
    {
        $db = Database::getInstance();

        $sql = 'SELECT * FROM `SensorData`';
        $query = $db->prepare($sql);
        $query->execute();

        return json_encode($query->fetchAll());
    }
}
