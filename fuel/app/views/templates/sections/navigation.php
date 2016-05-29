<?php
$links = $top_links['links'];
//echo "<pre>"; var_dump($navigation); exit;
foreach ($links as $i => $link) {
    if (!isset($current_user)) {
        $ignor = array(
            "sajan/sajan",
        );
        $ignorChildren = array('sajan/sajan');
        if ($link['href'] == "#") {
            foreach ($link['children'] as $j => $children) {
                if (in_array($children['href'], $ignorChildren)) {
                    unset($top_links['links'][$i]['children'][$j]);
                }
            }
        }

        if (in_array($link['href'], $ignor)) {
            unset($top_links['links'][$i]);
        }
    } else {
        $ignor = array(
            'sajan/sajan',
        );
        $ignorChildren[] = 'sajan/sajan';
        if ($link['href'] == "#") {
            foreach ($link['children'] as $j => $children) {
                if (in_array($children['href'], $ignorChildren)) {
                    unset($top_links['links'][$i]['children'][$j]);
                }
            }
        }

        if (in_array($link['href'], $ignor)) {
            unset($top_links['links'][$i]);
        }
    }
}
?>  

<div class="header">
    <div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                  <a class="logo-mobile" href="#"><img class="img-responsive centered" src="<?= Uri::create("assets/img/logo.png") ?>" /></a>
             
            </div>
            <div class="col-md-2">
 		<?php /* ?>
                <a class="logo-desktop" href="#">
                <h3>
                    <strong>Artricle</strong><small>Saga</small>
                </h3>
                    </a>
                  <?php */ ?>
                  <img class="logo-desktop" src="<?= Uri::create("assets/img/logo.png") ?>" style="width:153px;" />
               

            </div>
            <div class="login col-md-10">
                <?php /* ?>
                  <a href="javascript:void(0)" class="pull-right">Hi Steve <span class="caret"></span></a>
                  <a href="javascript:void(0)" class="pull-right hidden-xs">Jukebox <span class="caret"></span></a>
                  <?php */ ?>
                <div class="clearfix"></div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <?php echo Utils_Html::ul($top_links); ?>
                        <?php /* ?>
                          <ul class="nav navbar-nav pull-right">
                          <li>
                          <a href="#">Home</a>
                          </li>
                          <li class="active">
                          <a href="javascript:void(0)">News</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Community</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Tours</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Media</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Discography</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Bio</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Help</a>
                          </li>
                          <li>
                          <a href="javascript:void(0)">Store</a>
                          </li>
                          </ul>
                          <?php */ ?>
                    </div>
                </div>

            </div><!-- /.navbar-collapse -->

        </nav>
    </div>
</div>
