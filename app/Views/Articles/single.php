<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mt-4"><?= $article['Headline'] ?></h1>
            <p class="lead"> by <?= $reporter['FirstName'] ?> <?= $reporter['LastName'] ?></p>
            <hr />
            <p>Posted on <?= date_format(date_create($article['DateTime']), 'jS \of F Y h:i A') ?></p>
            <hr />
            <img class="img-fluid rounded" src="<?= $article['HeadlineImageUrl'] ?>" alt="">
            <hr />
            <p><?= $article['Content'] ?></p>
            <hr />
        </div>

        <div class="col-md-4">
            <div class="card my-4">
                <h5 class="card-header">Latest Articles</h5>
                <div class="card-body">
                    <p>Displaying all the articles from the last month:</p>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($allArticles as $a) { ?>
                        <hr />
                        <li>
                            <a href="index.php?controller=article&action=single&id=<?= $a['ID'] ?>"><?= $a['Headline'] ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
