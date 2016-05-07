<fildset>
<form id="categoryAddForm" class="form-horizontal" method="post" >
    <div class="form-group">
        <?= Form::label('Title', 'title',array('class'=>'control-label')); ?>
        <?php echo Form::input('title', Input::post('title', isset($date) ? $date->title : ''), array('class' => 'form-control required name', 'maxlength' => '100', 'placeholder' => 'Date Title *')); ?>
    </div>
    <div class="form-group">
        <?= Form::label('Summary', 'summary'); ?>
        <?php echo Form::textarea('summary', Input::post('keywords', isset($date) ? $date->summary : ''), array('class' => 'form-control required name', 'maxlength' => '500', 'placeholder' => 'Summary *')); ?>
    </div>
        <div class="form-group">
        <?= Form::label('Date', 'date'); ?>
        <?php echo Form::input('date', Input::post('date', isset($date) ? $date->date : ''), array('id'=>'datepicker','class' => 'form-control required name','placeholder' => 'Date *')); ?>
    </div>
        <div class="form-group">
        <?= Form::label('Keywords', 'meta'); ?>
        <?php echo Form::input('date_keywords', Input::post('meta',isset($date) ? $date->date_keywords : ''), array('class' => 'form-control required', 'maxlength' => '200', 'placeholder' => 'Date Keywords *')); ?>
    </div>
    <div style="position:relative;">
        <div style="position:absolute ;width:182px;height:58px;z-index:0;"  id="submit"></div>
        <input type="submit" id="create_user" class="btn primary" value="Add new Date" style="position:absolute;z-index:1;"/>
    </div>    
</form>
</fildset>
<br>
<br>
<br>
<br>
<br>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
</script>
<style>
    #ui-datepicker-div{width:50%}
</style>