    <main role="main">
            <div class="container">
                <h1 class="my-4">Articles</h1>
                <?php if ($loggedIn) { ?>
                    <p>It looks like you are a reporter! You can use the button below to create an article.</p>
                    <a class="btn btn-success" href="index.php?controller=article&action=create" role="button">Create Article</a>
                <?php } ?>
                <p>Click for RSS: <a href="public/rss/newsfeed.xml"><img src="public/img/pic_rss.gif" /></a></p>

                <div class="row my-4">
                    <div class="col">
                        <div id="forecast-text" class="card-header">
                            The weather forecast in Scranton from <a href="https://openweathermap.org">OpenWeatherMap.</a>
                        </div>

                        <div id="forecast" class="card-group"></div>            
                    </div>
                </div>

                <div class="row my-4">
                    <?php
                    if (sizeof($articles) < 1)
                        echo '<div class="col"><div class="alert alert-warning">Could not find any articles.</div></div>';
                    else foreach ($articles as $article)
                    { ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="<?= $article['HeadlineImageUrl'] ?>" />
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="index.php?controller=article&action=single&id=<?= $article['ID'] ?>">
                                        <?= $article['Headline'] ?>
                                    </a>
                                </h4>
                                <p class="card-text"><?= $article['Content'] ?></p>
                                <a href="index.php?controller=article&action=single&id=<?= $article['ID'] ?>" class="btn btn-primary">
                                    Read more
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($previousPage == $page) echo 'disabled' ?>">
                            <a class="page-link" href="index.php?controller=article&action=index&page=<?= $previousPage ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i < $totalPages + 1; $i++)
                        { ?>
                        <li class="page-item <?php if ($page == $i) echo 'disabled'; ?>">
                            <a class="page-link" href="index.php?controller=article&action=index&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php } ?>
                        <li class="page-item <?php if ($nextPage == $page) echo 'disabled' ?>">
                            <a class="page-link" href="index.php?controller=article&action=index&page=<?= $nextPage ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                    <p class="text-center">Showing <?= $showingFrom ?> to <?= $showingTo ?> of <?= $totalArticles ?></p>
                </nav>

                <div class="row my-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">Filter Articles</div>
                            <div class="card-body">
                                <form method="get" action="index.php?controller=article&action=index">
                                    <div class="form-group">
                                        <label for="datefrom">Date From:</label>
                                        <input class="form-control" type="date" name="datefrom" /><br />
                                        <label for="dateto">Date To:</label>
                                        <input class="form-control" type="date" name="dateto" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

<script>
$(document).ready(function(){
    getWeatherData();
    
});

function getWeatherData() {
    $("#forecast-text").html('Retrieving the latest weather... <img style="height: 2.5em; position: absolute;" src="public/img/loading.gif" />');
    
    $.getJSON("index.php?controller=weather&action=get", function(result){
        var date = new Date($.now());
        $("#forecast-text").html(
            'The weather forecast in Scranton from <a href="https://openweathermap.org">OpenWeatherMap.</a> ' +
            'Last updated at: ' + date.getHours() + ":" + date.getMinutes());
        $("#forecast").html('');
        
        $.each(result, function(i, field) { 
            var html = 
                '<div class="card">' +
                '<i class="my-2 text-center owf owf-' + field.ID + '" style="font-size: 5em;"></i><div class="card-body text-center">' +
                '<h5 class="card-title">' + field.Description + '</h5>' + 
                '<p class="card-text">' + field.Temp + '&deg; C</p><hr />' + 
                '<p class="card-text text-muted">' + field.DateTime + '</p></div></div>';

            $("#forecast").append(html);
        });
    });
   
    setTimeout(getWeatherData, 5000);
}
</script>