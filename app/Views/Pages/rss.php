<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3><?= $feedTitle; ?></h3>
            <h6><?= $feedDescription; ?></h6>
            <?php foreach ($items as $item) { ?>
            <div class="card card-outline-secondary my-3">
                <div class="card-header"><?= $item->title; ?></div>
                <div class="card-body">
                    <p class="card-text"><?= $item->description; ?></p>
                    <a href="<?= $item->link; ?>" class="btn btn-success">View article</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
