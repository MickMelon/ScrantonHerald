<?php 
namespace App\Models;

use App\Database;
use App\DateHelper;
use App\Models\UserModel;
use PDO;

class CommentModel 
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Get all the comments for an article.
     */
    public function getAllCommentsForArticle($articleId)
    {
        $comments = $this->getAllTopLevelCommentsForArticle($articleId);
        $comments = json_decode($comments, true);

        // Add all child comments to the comments
        foreach ($comments as &$comment)
        {
            $name = json_decode($this->userModel->getName($comment['UserID']), true);
            $comment['Name'] = $name['Name'];
            $comment['DaysAgo'] = DateHelper::getDaysSince($comment['DateTime']);
            $comment['Children'] = array();                     
            $childComments = $this->getAllCommentsForComment($comment['ID']);
            $childComments = json_decode($childComments, true);

            if (count($childComments) > 0)
            {
                foreach ($childComments as &$cc)
                {
                    $childName = json_decode($this->userModel->getName($cc['UserID']), true);
                    $cc['Name'] = $childName['Name'];
                    $cc['DaysAgo'] = DateHelper::getDaysSince($cc['DateTime']);
                }
                    
                $comment['Children'] = $childComments;
            }
        }

        return json_encode($comments);
    }

    /**
     * Get all the top level comments for an article.
     */
    public function getAllTopLevelCommentsForArticle($articleId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Comment` " .
            "WHERE `ArticleID` = :articleID " .
            "AND `ParentCommentId` IS NULL " .
            "ORDER BY `DateTime` DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':articleID', $articleId, PDO::PARAM_INT);
        $query->execute();

        return json_encode($query->fetchAll());
    }

    /**
     * Get all the comments for a comment.
     */
    public function getAllCommentsForComment($commentId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Comment` " .
            "WHERE `ParentCommentId` = :commentId " .
            "ORDER BY `DateTime` ASC";
        $query = $db->prepare($sql);
        $query->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $query->execute();

        return json_encode($query->fetchAll());
    }

    /**
     * Get a single comment.
     */
    public function getComment($commentId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Comment` " .
            "WHERE `ID` = :commentId";
        $query = $db->prepare($sql);
        $query->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $query->execute();

        return json_encode($query->fetch());
    }

    /**
     * Create a new comment.
     */
    public function createComment($articleId, $commentId, $userId, $content)
    {
        $dateTime = date("Y-m-d H:i:s");

        $db = Database::getInstance();

        $sql = "INSERT INTO `Comment` (`ArticleID`, `ParentCommentID`, `UserID`, `Content`, `DateTime`) " .
            "VALUES (:articleId, :commentId, :userId, :content, :dateTime)";
        $query = $db->prepare($sql);
        $query->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $query->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
        $query->execute();
    }
}