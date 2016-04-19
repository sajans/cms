<fildset>
<form id="categoryAddForm" class="form-horizontal" method="post" >
    <div class="form-group">
        <?= Form::label('Name', 'name',array('class'=>'control-label')); ?>
        <?php echo Form::input('name', Input::post('name', isset($category) ? $category->name : ''), array('class' => 'form-control required name', 'maxlength' => '100', 'placeholder' => 'Category Name *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Keywords', 'keywords'); ?>
        <?php echo Form::input('keywords', Input::post('keywords', isset($category) ? $category->keywords : ''), array('class' => 'form-control required name', 'maxlength' => '500', 'placeholder' => 'Keywords *')); ?>
    </div>
        <div class="form-group">
        <?= Form::label('Meta Description', 'meta'); ?>
        <?php echo Form::input('meta', Input::post('meta',isset($category) ? $category->meta : ''), array('class' => 'form-control required', 'maxlength' => '200', 'placeholder' => 'Meta *')); ?>
    </div>
    <div style="position:relative;">
        <div style="position:absolute ;width:182px;height:58px;z-index:0;"  id="submit"></div>
        <input type="submit" id="create_user" class="btn primary" value="Add new Category" style="position:absolute;z-index:1;"/>
    </div>    
</form>
</fildset>
<br>
<br>
<br>
<br>
<br>