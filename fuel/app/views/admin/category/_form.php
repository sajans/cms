<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>

				<?php echo Form::input('name', Input::post('name', isset($category) ? $category->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Keywords', 'keywords', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('keywords', Input::post('keywords', isset($category) ? $category->keywords : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Keywords')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Meta', 'meta', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('meta', Input::post('meta', isset($category) ? $category->meta : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Meta')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>