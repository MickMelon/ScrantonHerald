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

            <div class="fr-view text-justify"><?= $article['Content'] ?></div>
            <?php if ($article['FileUrl'] != '') { 
                if (substr($article['FileUrl'], 0, 4) === "http") { ?>
            <div class="embed-responsive embed-responsive-16by9" <?= $fileIsAudio ? 'style="height:2em;"' : '' ?>>
                <iframe class="embed-responsive-item" src="<?= $article['FileUrl'] ?>" allowfullscreen></iframe>
            </div>
            <?php } else { ?>
            <div>
                <video width="100%" controls muted>
                    <source src="<?= $article['FileUrl'] ?>" type="video/mp4" />
                </video>
            </div>
            <?php } } ?>
            <!-- Comments -->
            <hr />
            <h3>Comments</h3>
            <?php if ($loggedIn) { ?>
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form action="index.php?controller=article&action=submit_reply" method="post">
                        <div class="form-group">
                            <input type="hidden" id="article" name="article" value="<?= $article['ID'] ?>" />
                            <textarea name="content" id="content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <?php } else { ?>
            <p><i>You must be <a href="index.php?controller=login&action=index">logged in</a> to post a comment.</i></p>
            <?php } ?>

            <?php if (sizeof($comments) > 0) foreach ($comments as $comment) { ?>
            <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" style="width: 5%;" src="public/img/user.png" alt="" />
                <div class="media-body">
                    <strong><?= $comment['Name'] ?></strong> <small class="text-muted">commented <?= $comment['DaysAgo'] ?></small><br />              
                    <?= $comment['Content'] ?>
                   
                    
                    <?php foreach ($comment['Children'] as $child) { ?>
                    <div class="media mt-4">
                    <img class="d-flex mr-3 rounded-circle" style="width: 5%;" src="public/img/user.png" alt="" />
                        <div class="media-body">
                        <strong><?= $child['Name'] ?></strong> <small class="text-muted">commented <?= $child['DaysAgo'] ?></small><br />
                            <?= $child['Content'] ?>                          
                        </div>
                    </div>
                    <?php } 
                    if ($loggedIn) { ?>
                    <p class="text-right"><a class="text-right" href="index.php?controller=article&action=reply&article=<?= $article['ID'] ?>&comment=<?= $comment['ID'] ?>">Reply</a></p>
                    <?php } ?>
                    <hr>
                </div>
            </div>
            <?php } else { ?>
            <p>There are no comments to display! :(</p>
            <?php } ?>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function()
    {
        $(function() { $('textarea').froalaEditor() });

        $(function() 
        {
            $('#content').froalaEditor(
            {
                imageUploadMethod: 'POST',
                imageMaxSize: 100 * 1024 * 1024, // 10MB
                imageAllowedTypes: ['jpeg', 'jpg', 'png']
            })
        });
    });
</script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>