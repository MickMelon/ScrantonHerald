<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="card my-3">
                <h5 class="card-header">Choose RSS Feed</h5>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><a href="#">Scranton Herald</a></li>
                        <li><a href="#">BBC</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h3><?= $feed->channel[0]->title; ?></h3>
            <h6><?= $feed->channel[0]->description; ?></h6>
            <?php
            foreach ($feed->channel[0]->item as $item)
            {
            ?>
            <div class="card card-outline-secondary my-3">
                <div class="card-header"><?= $item->title; ?></div>
                <div class="card-body">
                    <p class="card-text"><?= $item->description; ?></p>
                    <a href="<?= $item->link; ?>" class="btn btn-success">View article</a>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
