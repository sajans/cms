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
<?php /* ?>
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
  <?php ?>
  <a class="logo-desktop" href="#">
  <large class="logo-text">
  <strong>Artricle</strong><small>Saga</small>
  </large>
  </a>
  <?php ?>
  <?php /* ?>
  <img class="logo-desktop" src="<?= Uri::create("assets/img/logo.png") ?>" style="width:153px;" />
  <?php */ ?>
<?php /* ?>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <?php echo Utils_Html::ul($top_links); ?>
  </div><!-- /.navbar-collapse -->

  </nav>
  </div>
  </div>

  <?php */ ?>
<div class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        </button> 
<img class="logo-desktop" src="<?= Uri::create("assets/img/logo.png") ?>" style="width:153px;" />
<?php /* 'MuseoSans_xFat' ?>                           
                        <a class="logo-desktop" href="<?= Uri::create('/');?>">
                            <large class="logo-text">
                                <strong>Artricle</strong><small>Saga</small>
                            </large>
                        </a>
<?php */?>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="col-md-10">
                        <?php echo Utils_Html::ul($top_links); ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
