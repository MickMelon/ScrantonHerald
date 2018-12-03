<?php 
namespace App\Models;

use App\Database;
use PDO;

class CommentModel 
{
    public function getAllCommentsForArticle($articleId)
    {
        $comments = $this->getAllTopLevelCommentsForArticle($articleId);
        $comments = json_decode($comments, true);

        // Add all child comments to the comments
        foreach ($comments as &$comment)
        {
            array_push($comment, 'children');
            $comment['children'] = array();
            
            $childComments = $this->getAllCommentsForComment($comment['ID']);
            $childComments = json_decode($childComments, true);

            if (count($childComments) > 0)
                $comment['children'] = $childComments;
        }

        return json_encode($comments);
    }

    public function getAllTopLevelCommentsForArticle($articleId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Comment` " .
            "WHERE `ArticleID` = :articleID " .
            "AND `ParentCommentId` IS NULL " .
            "ORDER BY `DateTime` DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':articleID', $articleId);
        $query->execute();

        return json_encode($query->fetchAll());
    }

    public function getAllCommentsForComment($commentId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Comment` " .
            "WHERE `ParentCommentId` = :commentId " .
            "ORDER BY `DateTime` DESC";
        $query = $db->prepare($sql);
        $query->bindParam(':commentId', $commentId);
        $query->execute();

        return json_encode($query->fetchAll());
    }
}