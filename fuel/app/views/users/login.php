<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "login" ); ?>'><?php echo Html::anchor('users/login','Login');?></li>
	<li class='<?php echo Arr::get($subnav, "logout" ); ?>'><?php echo Html::anchor('users/logout','Logout');?></li>
	<li class='<?php echo Arr::get($subnav, "register" ); ?>'><?php echo Html::anchor('users/register','Register');?></li>

</ul>
<p>Login</p>

<div class="container">
    <div class="row">
        <div class="form-group">
           <?php  echo Form::open(array('action' => Uri::create('users/login'), 'method' => 'post')); ?>
            <?php echo Form::input('email','',array()) ?>
            <?php echo Form::input('password','',array()) ?>
            <?php echo Form::submit('login','Login',array()) ?>
        </div>
        
    </div>
    
</div>