<?php
namespace App\Models;

use App\Base\Database;
use PDO;

class EvaluationModel
{
    /**
    * Get an evaluation by the week number.
    */
    public function getEvaluation($week)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Evaluation` WHERE `Week` = :week";
        $query = $db->prepare($sql);
        $query->bindParam(':week', $week, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
    * Get the the latest evaluation going by the week.
    */
    public function getLatestEvaluation()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Evaluation` ORDER BY `Week` DESC LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    /**
    * Get all the evaluations.
    */
    public function getAllEvaluations()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Evaluation`";
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
    * Get the total number of evaluations.
    */
    public function getTotalEvaluations()
    {
        return sizeof($this->getAllEvaluations());
    }
}
