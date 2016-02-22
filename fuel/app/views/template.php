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
        <link rel="stylesheet" href="<?= Uri::create("assets/css/bootstrap.min.css") ?>" />
        <link rel="stylesheet" href="<?= Uri::create("assets/css/style.css") ?>" />
    </head>

    <body>
        <!-- Navigation-->
        <?php if(isset($navigation)){ ?>
        <?= View::forge("templates/sections/navigation", $navigation); ?>
        <?php  } ?>
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
        <?= View::forge("templates/sections/footer") ;?>
        <script src="<?= Uri::create("assets/js/jquery-1.11.1.min.js"); ?>"></script>
        <script src="<?= Uri::create("assets/js/bootstrap.min.js"); ?>"></script>
    </body>
</html>