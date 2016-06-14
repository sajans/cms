<?php if (isset($articles) && count($articles) >= 1): ?> 
    <?php foreach ($articles as $article): ?>

        <div class="col-md-4">
            <div class="same-row-display article-info-block">
                <h4 class="text-center"><?= $article->name; ?></h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p>
                    <?php
                    if (strlen($article->description) >= 120) {
                        echo substr($article->description, 0, 120);
                        echo "........";
                    } else {
                        echo $article->description;
                    }
                    ?>

                </p>
                <div class="text-center">
                    <a class="btn btn-primary" href="<?= Uri::create("article/view/".$article->url_title); ?>">More Info</a>
                </div>
            </div>
        </div>



    <?php endforeach; ?>
<?php else: ?>
    <div class="col-md-4">
        <div class="same-row-display article-info-block">
            <h4 class="text-center">Heading 1</h4>
            <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
            <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
            <div class="text-center">
                <a class="btn btn-primary" href="#">More Info</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="same-row-display article-info-block">
            <h4 class="text-center">Heading 1</h4>
            <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
            <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
            <div class="text-center">
                <a class="btn btn-primary" href="#">More Info</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="same-row-display article-info-block">
            <h4 class="text-center">Heading 1</h4>
            <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
            <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
            <div class="text-center">
                <a class="btn btn-primary" href="#">More Info</a>
            </div>
        </div>
    </div>

<?php endif; ?>

