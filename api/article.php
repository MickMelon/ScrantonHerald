<?php 
require_once('../vendor/autoload.php');
use App\Models\ArticleModel;

$articleModel = new ArticleModel();

if (isset($_GET['id']))
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Content-Length: ' . strlen($articleModel));

    $article = $articleModel->getArticle($_GET['id']);
    http_response_code(200);
    echo $article;
}