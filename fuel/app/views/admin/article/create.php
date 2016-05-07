<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Category id', 'category_id', array('class'=>'control-label')); ?>

				<?php echo Form::select('category_id', Input::post('category_id', isset($article) ? $article->category_id : ''),$categories , array('class' => 'col-md-4 form-control', 'placeholder'=>'Category id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>

				<?php echo Form::input('name', Input::post('name', isset($article) ? $article->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Description', 'description', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('description', Input::post('description', isset($article) ? $article->description : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Description')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Keywords', 'keywords', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('keywords', Input::post('keywords', isset($article) ? $article->keywords : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Keywords')); ?>
		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>