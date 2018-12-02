<?php
namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\UserModel;
use App\Util;
use App\View;
use App\FileUpload;

class ArticleController
{
    private $articleModel;
    private $userModel;

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
        
        // Show the view.
        $view = new View('Articles/index');
        $view->assign('pageTitle', 'Articles');
        $view->assign('articles', $articles);
        $view->assign('totalPages', $totalPages);
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
        $reporter = $this->userModel->getUserById($article['ReporterID']);
        $reporter = json_decode($reporter, true);

        // Get all articles to display in sidebar.
        $today = date_create();
        $dateTo = $today->format('Y-m-d');
        $dateFrom = date_sub($today, date_interval_create_from_date_string('1 month'));
        $dateFrom = $dateFrom->format('Y-m-d');
        $allArticles = $this->articleModel->getAllArticlesWithinDates($dateFrom, $dateTo);
        $allArticles = json_decode($allArticles, true);

        // Show the view.
        $view = new View('Articles/single');
        $view->assign('pageTitle', $article['Headline']);
        $view->assign('article', $article);
        $view->assign('reporter', $reporter);
        $view->assign('allArticles', $allArticles);
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
            if (file_exists($_FILES['file']['tmp_name']))
            {
                $fileUpload = new FileUpload($_FILES['file']);
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
        $view = new View('Articles/success');
        $view->render();
    }

    private function uploadFile($file, $type)
    {
        if ($file)
        {
            $errors = array();

            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];
            $fileType = $file['type'];

            $value = explode('.', $fileName);
            $fileExt = strtolower(end($value));

            switch ($type)
            {
                case 'image':
                    $allowedExtensions = array('png', 'gif', 'jpg');
                    $uploadDirectory = 'public/uploads/images/';
                    break;

                case 'media':
                    $allowedExtensions = array('mp3', 'mp4');
                    $uploadDirectory = 'public/uploads/files/';
                    break;
            }

            if (!in_array($fileExt, $allowedExtensions))
                $errors[] = 'Extension not allowed.';

            if ($fileSize > 20097152)
                $errors[] = 'File size must be no bigger than 20MB.';

            if (empty($errors))
            {
                $targetFile = $uploadDirectory . $fileName;

                if (!file_exists($targetFile))
                    move_uploaded_file($fileTmp, $targetFile);

                return $targetFile;
            }
            else
                print_r($errors);
        }

        return '';
    }

    public function upload_image()
    {
        try
        {
            $response = Image::upload('uni/public/uploads/images/');
            echo "TEST!! " . stripslashes(json_encode($response));
        }
        catch (Exception $e)
        {
            http_response_code(404);
        }
    }
}
