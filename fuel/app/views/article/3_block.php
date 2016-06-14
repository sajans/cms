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
                    <a class="btn btn-primary" href="<?= Uri::create("article/view/" . $article->url_title); ?>">More Info</a>
                </div>
            </div>
        </div>



    <?php endforeach; ?>
<?php endif; ?>