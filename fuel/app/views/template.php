<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>cms</title>
        <meta name="description" content="" />
        <meta name="author" content="SA" />

        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <!-- CSS -->
        <?php echo Asset::css('bootstrap.css'); ?>
        <?php echo Asset::css('main.css'); ?>
        <?php echo Asset::css('jquery-ui.min.css'); ?>
        <?php //echo Asset::css('jquery-ui.theme.min.css'); ?>
        <?php echo Asset::css('tags/jquery.tag-editor.css'); ?>
        <link type="text/css" rel="stylesheet" href="<?= Uri::Create('assets/font-awesome/css/font-awesome.min.css'); ?>" />

        <link rel="stylesheet" href="<?= Uri::create("assets/css/style.css") ?>" />
        <!--JS -->
        <?php
        echo Asset::js(array(
            'jquery-1.11.1.min.js',
            'bootstrap.min.js',
            'jquery-ui.min.js',
            'tags/jquery.caret.min.js',
            'tags/jquery.tag-editor.min.js',
            'script.js',
        ));
        echo View::forge("js/variables");
        ?>

    </head>

    <body>
        <!-- Navigation-->
        <?php if (isset($navigation)) { ?>
            <?= View::forge("templates/sections/navigation", $navigation); ?>
        <?php } ?>
        <!-- Navigation-->
        <div id="cms-page">
            <div class="alert-section">
                <?php if (Session::get_flash('success')): ?>
                    <div class="alert alert-success">
                        <strong>Success</strong>
                        <p>
                            <?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (Session::get_flash('error')): ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong>
                        <p>
                            <?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            <!--Content -->
            <?= $content; ?>
            <!--Content -->
        </div>
        <!--Footer -->
        <?= View::forge("templates/sections/footer"); ?>
    </body>
</html>