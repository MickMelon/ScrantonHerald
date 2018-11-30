<?php
namespace App\Models;

use App\Base\Database;
use PDO;

class ArticleModel
{
    /**
    * Get all the articles from the database, ordered
    * from new to old.
    */
    public function getAllArticles()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Article` ORDER BY `DateTime` DESC";
        $query = $db->prepare($sql);
        $query->execute();

        return json_encode($query->fetchAll());
    }

    /**
    * Get all articles between two dates, ordered
    * from new to old.
    */
    public function getAllArticlesWithinDates($dateFrom, $dateTo)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Article` WHERE `DateTime` BETWEEN :dateFrom"
                . " AND :dateTo ORDER BY `DateTime` DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':dateFrom', $dateFrom, PDO::PARAM_STR);
        $query->bindParam(':dateTo', $dateTo, PDO::PARAM_STR);
        $query->execute();

        return json_encode($query->fetchAll());
    }

    /**
    * Get single article by ID.
    */
    public function getArticle($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Article` WHERE `ID` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return json_encode($query->fetch());
    }

    public function createArticle($headline, $headlineImage, $content, $file, $reporterId)
    {
        $dateTime = date("Y-m-d H:i:s");

        $db = Database::getInstance();

        $sql = "INSERT INTO `Article` (`Headline`, `HeadlineImageUrl`, `Content`, `FileUrl`, `DateTime`, `ReporterID`) " .
               "VALUES (:headline, :headlineImage, :content, :file, :dateTime, :reporterId)";
        $query = $db->prepare($sql);
        $query->bindParam(':headline', $headline, PDO::PARAM_STR);
        $query->bindParam(':headlineImage', $headlineImage, PDO::PARAM_STR);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->bindParam(':file', $file, PDO::PARAM_STR);
        $query->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
        $query->bindParam(':reporterId', $reporterId, PDO::PARAM_INT);

        $query->execute();
    }
}
