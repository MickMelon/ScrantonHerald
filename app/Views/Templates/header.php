<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Froala Editor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_style.min.css' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="public/vendor/froala/css/image.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Site -->
    <link rel="stylesheet" type="text/css" href="public/css/site.css" />
    
    <title><?= SITE_NAME ?><?php if (isset($pageTitle)) echo ' - ' . $pageTitle; ?></title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php?controller=article&action=index"><?= SITE_NAME ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item<?php if ($this instanceof ArticleController) echo ' active'; ?>">
                        <a class="nav-link" href="index.php?controller=article&action=index">Articles</a>
                    </li>
                    <li class="nav-item<?php if ($this instanceof EvaluationController) echo ' active'; ?>">
                        <a class="nav-link" href="index.php?controller=evaluation&action=index">Evaluations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jqm/index.html">Electric Imp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $_GET['action'] == 'rss' ? ' active' : ''; ?>" href="index.php?controller=page&action=rss">RSS Feed</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <?php if ($loggedIn) echo 'Welcome back! <a href="index.php?controller=login&action=logout">Logout</a>';
                    else echo '<a href="index.php?controller=login&action=index">Login</a>'
                        . ' - <a href="index.php?controller=register&action=index">Register</a>';
                    ?>
                </span>
            </div>
        </nav>
        <section class="jumbotron">
            <div class="container">
                <h1 class="jumbotron-heading"><?= SITE_NAME ?></h1>
                <p class="lead text-muted"><?= SITE_DESC ?></p>
            </div>
        </section>
    </header>
