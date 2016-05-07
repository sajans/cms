<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <?php echo Asset::css('bootstrap.css'); ?>
        <?php echo Asset::css('main.css'); ?>
        <?php echo Asset::css('jquery-ui.min.css'); ?>
        <?php //echo Asset::css('jquery-ui.theme.min.css'); ?>
        <?php echo Asset::css('tags/jquery.tag-editor.css'); ?>
        <link type="text/css" rel="stylesheet" href="<?= Uri::Create('assets/font-awesome/css/font-awesome.min.css'); ?>" />

        <style>
            body { margin: 50px; }
        </style>
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
        <script>
            $(function () {
                $('.topbar').dropdown();
            });
        </script>
    </head>
    <body>

        <?php if ($current_user): ?>
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= Uri::create("/"); ?>">My Site</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="<?php echo Uri::segment(2) == '' ? 'active' : '' ?>">
                                <?php echo Html::anchor('admin/dashboard', 'Dashboard') ?>
                            </li>
                            <li class="<?php echo Uri::segment(2) == 'users' ? 'active' : '' ?>">
                                <?php echo Html::anchor('admin/users', 'Users') ?>
                            </li>
                            <li class="<?php echo Uri::segment(2) == 'category' ? 'active' : '' ?>">
                                <?php echo Html::anchor('admin/category', 'Categories') ?>
                            </li>
                            <li class="<?php echo Uri::segment(2) == 'article' ? 'active' : '' ?>">
                                <?php echo Html::anchor('admin/article', 'Articles') ?>
                            </li>
                              <li class="<?php echo Uri::segment(2) == 'date' ? 'active' : '' ?>">
                                <?php echo Html::anchor('admin/date', 'Dates') ?>
                            </li>

                            <?php
                            /*
                              $files = new GlobIterator(APPPATH . 'classes/controller/admin/*.php');
                              foreach ($files as $file) {
                              $section_segment = $file->getBasename('.php');
                              $section_title = Inflector::humanize($section_segment);
                              ?>
                              <li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
                              <?php echo Html::anchor('admin/' . $section_segment, $section_title) ?>
                              </li>
                              <?php
                              }
                             */
                            ?>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->username ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo Html::anchor('admin/logout', 'Logout') ?></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $title; ?></h1>
                    <hr>
                    <?php if (Session::get_flash('success')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p>
                                <?php echo implode('</p><p>', (array) Session::get_flash('success')); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php if (Session::get_flash('error')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p>
                                <?php echo implode('</p><p>', (array) Session::get_flash('error')); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-12">
                    <?php echo $content; ?>
                </div>
            </div>
            <hr/>
            <footer>
                <div id="notificationDiv" class="ajax-status-popup-display-js" style="display:none;"></div>
                <p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
                <p>
                    <a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
                    <small>Version: <?php echo e(Fuel::VERSION); ?></small>
                </p>
                <!--Bootstrap Modal Can Used to all-->
                <div class="modal fade" id="js-cms-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content cms-modal-content">
                          
                        </div>
                    </div>
                </div>

                <!--Bootstrap Modal Can Used to all-->



            </footer>
        </div>
    </body>
</html>
