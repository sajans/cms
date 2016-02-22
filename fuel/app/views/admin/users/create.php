<fildset>
<form id="usersAddForm" class="form-horizontal" method="post" >
    <div class="form-group">
        <?= Form::label('First Name', 'first_name',array('class'=>'control-label')); ?>
        <?php echo Form::input('first_name', Input::post('first_name', isset($user) ? $user->first_name : ''), array('class' => 'form-control required name', 'maxlength' => '25', 'placeholder' => 'First Name *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Last Name', 'last_name'); ?>
        <?php echo Form::input('last_name', Input::post('last_name', isset($user) ? $user->last_name : ''), array('class' => 'form-control required name', 'maxlength' => '25', 'placeholder' => 'Last Name *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Email', 'email'); ?>
        <?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'form-control required email', 'maxlength' => '50', 'remote' => Uri::create('rest/user/unique_email.json'), 'placeholder' => 'Email *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Password', 'password'); ?>
        <?php echo Form::password('password', Input::post('password', ''), array('class' => 'form-control required', 'placeholder' => 'Password *', 'id' => 'password2')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Confirm Password', 'confirm_password'); ?>
        <?php echo Form::password('confirm_password', Input::post('confirm_password', ''), array('class' => 'form-control required', 'equalTo' => '#password2', 'placeholder' => 'Confirm Password *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Group', 'group'); ?>
        <?php echo Form::select('group', "", $grouplist, array('class' => 'required')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Address', 'address'); ?>
        <?php echo Form::input('address', Input::post('address', ''), array('class' => 'form-control required', 'maxlength' => '200', 'placeholder' => 'Address *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Town', 'town'); ?>
        <?php echo Form::input('town', Input::post('town', ''), array('class' => 'form-control required', 'maxlength' => '15', 'placeholder' => 'City/Town *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('County', 'county'); ?>
        <?php echo Form::input('county', Input::post('county', ''), array('class' => 'form-control required', 'maxlength' => '15', 'placeholder' => 'County/State *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Mobile Number', 'mobile_number'); ?>
        <?php echo Form::input('mobile_number', Input::post('mobile_number', ''), array('class' => 'form-control', 'maxlength' => '20', 'placeholder' => 'Mobile Number')); ?>
    </div>  
    <div style="position:relative;">
        <div style="position:absolute ;width:182px;height:58px;z-index:0;"  id="submit"></div>
        <input type="submit" id="create_user" class="btn primary" value="Add new user" style="position:absolute;z-index:1;"/>
    </div>    
</form>
</fildset>
<br>
<br>
<br>
<br>
<br>