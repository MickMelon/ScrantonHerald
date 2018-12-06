<div class="container mx-auto my-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if ($isReporter) { ?>
            <a href="index.php?controller=article&action=update&id=<?= $article['ID'] ?>" class="btn btn-success" role="button">
                Update
            </a>
            <a href="index.php?controller=article&action=delete&id=<?= $article['ID'] ?>" class="btn btn-danger" role="button">
                Delete
            </a>
            <?php } ?>
            <h1 class="mt-4"><?= $article['Headline'] ?></h1>
            <p class="lead">Posted by <b><?= $reporter['FirstName'] ?> <?= $reporter['LastName'] ?></b> on the <b><?= date_format(date_create($article['DateTime']), 'jS \of F, Y') ?></b></p>
            <img class="img-fluid rounded mx-auto" src="<?= $article['HeadlineImageUrl'] ?>" alt="">
            <hr />
            <?php if ($article['FileUrl'] != '') { ?>
            <div class="embed-responsive embed-responsive-16by9" <?= $fileIsAudio ? 'style="height:2em;"' : '' ?>>
                <iframe class="embed-responsive-item" src="<?= $article['FileUrl'] ?>" allowfullscreen></iframe>
            </div>
            <?php } ?>
            <div class="fr-view text-justify"><?= $article['Content'] ?></div>
            <?php foreach ($comments as $comment) { ?>
                <div class="card my-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= $comment['UserID'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $comment['DaysAgo'] ?></h6>
                        <p class="card-text"><?= $comment['Content'] ?></p>
                    </div>
                    <?php foreach ($comment['Children'] as $child) { ?>
                    <div class="card my-1" style="margin-left: 10%;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $child['UserID'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $child['DaysAgo'] ?></h6>
                            <p class="card-text"><?= $child['Content'] ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="card-body">
                        <a href="index.php?controller=article&action=reply&article=<?= $article['ID'] ?>&comment=<?= $comment['ID'] ?>">
                                Reply
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>
<script src="public/vendor/froala/plugins/js/image.min.js"></script>
<script src="public/vendor/froala/plugins/js/font_size.min.js"></script>