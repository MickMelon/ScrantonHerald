<?php
namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\UserModel;
use App\Models\CommentModel;
use App\Models\WeatherModel;
use App\Util;
use App\View;
use App\FileUpload;
use App\DateHelper;

class ArticleController
{
    private $articleModel;
    private $userModel;
    private $commentModel;
    private $weatherModel;

    const ARTICLES_PER_PAGE = 9;
    const DEFAULT_HEADLINE_IMAGE = 'https://via.placeholder.com/250';

    /**
     * Creates a new ArticlesController object
     * and instantiate dependencies.
     */
    public function __construct()
    {
        $this->articleModel = new ArticleModel();
        $this->userModel = new UserModel();
        $this->commentModel = new CommentModel();
        $this->weatherModel = new WeatherModel();
    }

    /**
     * Displays the articles index page.
     */
    public function index()
    {
        // Get all articles within the dates if the date from and date
        // to have been set.
        if (isset($_GET['datefrom']) && isset($_GET['dateto']))
        {
            $dateFrom = $_GET['datefrom'];
            $dateTo = $_GET['dateto'];

            $articles = $this->articleModel->
                getAllArticlesWithinDates($dateFrom, $dateTo);
        }
        else
            $articles = $this->articleModel->getAllArticles();

        $articles = json_decode($articles, true);
        $totalArticles = sizeof($articles);
        $page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

        // Set the variables used for the pagination. 
        // (showing x to y of z)
        $totalPages = ceil($totalArticles / $this::ARTICLES_PER_PAGE);
        $previousPage = ($page - 1) < 1 ? 1 : ($page - 1);
        $nextPage = ($page + 1) > $totalPages ? $totalPages : ($page + 1);
        $showingTo = ($page * $this::ARTICLES_PER_PAGE);
        $showingFrom = $showingTo - $this::ARTICLES_PER_PAGE + 1;

        // Make sure showingTo is not greater than the number of articles.
        $showingTo = ($showingTo > $totalArticles) ? $totalArticles : $showingTo;

        // Get the subset of articles depending on page and how many to
        // show per page.
        $articles = array_slice($articles, ($page - 1) * $this::ARTICLES_PER_PAGE, $this::ARTICLES_PER_PAGE);

        // Weather
        $weather = json_decode($this->weatherModel->getFormattedWeather(), true);

        // Forecast
        $forecast = json_decode($this->weatherModel->getFormattedForecast(), true);

        // Show the view.
        $view = new View('Articles/index');
        $view->assign('pageTitle', 'Articles');
        $view->assign('weatherData', $weather);
        $view->assign('forecast', $forecast);
        $view->assign('articles', $articles);
        $view->assign('totalPages', $totalPages);
        $view->assign('previousPage', $previousPage);
        $view->assign('page', $page);
        $view->assign('nextPage', $nextPage);
        $view->assign('showingTo', $showingTo);
        $view->assign('showingFrom', $showingFrom);
        $view->assign('totalArticles', $totalArticles);
        $view->render();
    }

    /**
     * Display a single article by the ID specified
     * in the GET parameter.
     */
    public function single()
    {
        // Check if the ID has been set.
        if (isset($_GET['id'])) $id = $_GET['id'];
        else header('Location: index.php?controller=pages&action=error');

        // Get the specified article and reporter from the database.
        $article = $this->articleModel->getArticle($id);
        $article = json_decode($article, true);

        if ($article['FileUrl'] != '')
        {
            $path_info = pathinfo($article['FileUrl']);
            $fileIsAudio = $path_info['extension'] == 'mp3' ? true : false;
        }
        else
            $fileIsAudio = false;

        $reporter = $this->userModel->getUserById($article['ReporterID']);
        $reporter = json_decode($reporter, true);

        // Get all the comments to display... 
        $comments = $this->commentModel->getAllCommentsForArticle($id);
        $comments = json_decode($comments, true);
            
        // Show the view.
        $view = new View('Articles/single');
        $view->assign('pageTitle', $article['Headline']);
        $view->assign('article', $article);
        $view->assign('reporter', $reporter);
        $view->assign('comments', $comments);
        $view->assign('fileIsAudio', $fileIsAudio);
        $view->render();
    }

    /**
     * Shows the create article page to only reporters.
     */
    public function create()
    {
        if (!Util::isLoggedIn() || !Util::isReporter())
            header('Location: index.php');

        $view = new View('Articles/create');
        $view->render();
    }

    /***
     * Called when the create article form has been submitted.
     */
    public function submit_create()
    {
        if (!Util::isLoggedIn() || !Util::isReporter())
            header('Location: index.php');

        if (isset($_POST['headline']) &&
            isset($_POST['content']))
        {
            $content = $_POST['content'];
            $headline = filter_var($_POST['headline'], FILTER_SANITIZE_STRING);
            $reporterId = $_SESSION['id'];

            // Check if there is a headline image to be uploaded.
            if (file_exists($_FILES['headlineImage']['tmp_name']))
            {
                $imageUpload = new FileUpload($_FILES['headlineImage'], true);
                $result = $imageUpload->upload();
                if (!is_array($result)) 
                    $headlineImage = $result;
                else 
                {
                    foreach ($result as $error)
                        echo $result . '<br>';
                    return;
                }

            }
            else
                $headlineImage = ArticleController::DEFAULT_HEADLINE_IMAGE;

            // Check if there is a file to be uploaded.
            if (file_exists($_FILES['fileUpload']['tmp_name']))
            {
                echo "In file upload...<br>";
                $fileUpload = new FileUpload($_FILES['fileUpload']);
                $result = $fileUpload->upload();
                if (!is_array($result))
                    $file = $result;
                else 
                {
                    foreach ($result as $error)
                        echo $result . '<br>';
                    return;
                }
            }
            else
                $file = '';

            // Create the article and display the success page.
            $this->articleModel->createArticle($headline, $headlineImage, $content, $file, $reporterId);
            header('Location: index.php?controller=article&action=create_success');
        }
        else
            header('Location: index.php');
    }

    /**
     * Display the "article created successfully" view.
     */
    public function create_success()
    {
        $view = new View('Articles/createsuccess');
        $view->render();
    }

    public function reply()
    {
        if (!Util::isLoggedIn())
            header('Location: index.php');

        if (isset($_GET['article']))
        {
            $articleId = $_GET['article'];
            $commentId = -1;

            $article = json_decode($this->articleModel->getArticle($articleId), true);

            if ($article != null)
            {
                if (isset($_GET['comment']))
                {
                    $commentId = $_GET['comment'];
                    $comment = json_decode($this->commentModel->getComment($commentId), true);

                    if ($comment != null)
                        $replyingTo = $comment['Content'] . ' by ' . $comment['UserID'];
                    else 
                        header('Location: index.php?controller=page&action=error');
                }
                else 
                    $replyingTo = $article['Headline'] . ' by ' . $article['ReporterID'];

            }
            else 
                header('Location: index.php?controller=page&action=error');
        }
        else 
            header('Location: index.php');

        $view = new View('Articles/reply');
        $view->assign('articleId', $articleId);
        $view->assign('commentId', $commentId);
        $view->assign('replyingTo', $replyingTo);
        $view->render();
    }

    public function submit_reply()
    {
        if (!Util::isLoggedIn())
            header('Location: index.php');

        if (isset($_POST['articleId'])
            && isset($_POST['commentId'])
            && isset($_POST['content']))
        {
            $articleId = $_POST['articleId'];
            $commentId = $_POST['commentId'];
            $content = $_POST['content'];

            // Make sure the article exists
            $article = $this->articleModel->getArticle($articleId);
            if ($article == null) return;
            if ($commentId == -1) $commentId = null;
            $userId = $_SESSION['id'];

            $this->commentModel->createComment($articleId, $commentId, $userId, $content);
        }
        else 
            header('Location: index.php');
    }

    /**
     * Used for the Froala Editor to upload images.
     */
    public function upload_froala_image()
    {
        if (!file_exists($_FILES['file']['tmp_name']))
            return;

        $upload = new FileUpload($_FILES['file'], 'image');
        $result = $upload->upload();

        if (!is_array($result))
        {
            $response = new \StdClass;
            $response->link = 'http://localhost:8080/uni/' . $result;
            $json = json_encode($response, JSON_UNESCAPED_SLASHES);

            header('Content-Type: application/json');
            echo stripslashes($json);
        }
    }
}
