<?php
namespace App\Models;

use App\Database;
use App\StringHelper;
use PDO;
use DOMDocument;
use DOMXPath;
use DOMNode;

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

    /**
     * Create a new article.
     */
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

        $articleId = $db->lastInsertId();
        $this->addArticleToRss($articleId, $headline, $content);
    }

    private function addArticleToRss($id, $title, $desc)
    {
        // Add to the XML file for the RSS feed
        $rssFile = 'public/rss/newsfeed.xml';
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load($rssFile);

        $xpath = new DOMXPath($dom);
        $channel = $xpath->query('/rss/channel')->item(0);
        
        if ($channel instanceof DOMNode)
        {
            $desc = StringHelper::substrWithoutCuttingWords($desc, 200);
            $item = $channel->insertBefore($dom->createElement('item'), $channel->firstChild);
            $item->appendChild($dom->createElement('title', strip_tags($title)));
            $item->appendChild($dom->createElement('link', 'index.php?controller=article&amp;action=single&amp;id=' . $id));
            $item->appendChild($dom->createElement('description', strip_tags($desc)));  

            $dom->save($rssFile);
        }
    }

    /**
     * Updates an article.
     */
    public function updateArticle($articleId, $headline, $content)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Article` SET " .
            "`Headline` = :headline, " .
            "`Content` = :content " .
            "WHERE `ID` = :articleId";
        $query = $db->prepare($sql);
        $query->bindParam(':headline', $headline, PDO::PARAM_STR);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        $query->execute();
    }

    /**
     * Deletes an article.
     */
    public function deleteArticle($articleId)
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM `Article` WHERE `ID` = :articleId";
        $query = $db->prepare($sql);
        $query->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        $query->execute();
    }
}
