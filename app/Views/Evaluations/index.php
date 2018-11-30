<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card my-4">
                <h5 class="card-header">Evaluation Index</h5>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <?php for ($i = 0; $i < $totalEvaluations; $i++)
                        { ?>
                        <li>
                            <?php if ($week == ($i + 1))
                            {
                                echo 'Week ' . ($i + 1);
                            }
                            else
                            {
                                echo "<a href='index.php?controller=evaluation&action=index&week=".($i + 1)."'>";
                                echo 'Week ' . ($i + 1);
                                echo '</a>';
                            }?>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h1 class="mt-4">Week <?= $evaluation->Week ?></h1>
            <p class="lead"><?= $evaluation->Date ?></p>

            <hr />

            <p><?= $evaluation->Content ?></p>
        </div>
    </div>
</div>
