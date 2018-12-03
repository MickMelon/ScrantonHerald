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
            <?php 
            foreach ($comments as $comment)
            {
            ?>
                <ol>
                    <li><b><?= $comment['ID'] ?></b></li>
                    <li><?= $comment['Content'] ?></li>
                    <li><?= $comment['DateTime'] ?></li>
                    <li><?= $comment['UserID'] ?></li>
                    <li><?= $comment['ArticleID'] ?></li>
                    <li><?= $comment['ParentCommentID'] ?></li>
                

                <?php
                foreach ($comment['children'] as $child)
                {
                ?>
                    <ul>
                        <li><?= $child['ID'] ?></li>
                        <li><?= $child['Content'] ?></li>
                        <li><?= $child['DateTime'] ?></li>
                        <li><?= $child['UserID'] ?></li>
                        <li><?= $child['ArticleID'] ?></li>
                        <li><?= $child['ParentCommentID'] ?></li>
                    </ul>
                    <hr />
                <?php 
                } ?>
                </ol>
                <hr />
            <?php 
            } ?>
        </div>

        </div>
    </div>
</div>
