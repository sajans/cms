<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Edit Date</h4>
</div>
<?php echo Form::open(array("class" => "form-horizontal", 'id' => $form_id, 'action' => $form_action)); ?>
<div class="modal-body">
    <fieldset>
        <?php foreach ($fields as $key => $label): ?>
            <div class="form-group">
                <?php echo Form::label($label, $key, array('class' => 'control-label')); ?>
                <?php if ($key == 'description'): ?>
                    <?php echo Form::textarea($key, Input::post($key, isset($data->$key) ? ($key == 'date') ? date('d/m/Y', $data->$key) : $data->$key : ''), array('class' => 'col-md-4 form-control', 'placeholder' => "Enter " . $label)); ?>

                <?php else : ?>
                    <?php echo Form::input($key, Input::post($key, isset($data->$key) ? ($key == 'date') ? date('d/m/Y', $data->$key) : $data->$key : ''), array('class' => 'col-md-4 form-control', 'placeholder' => "Enter " . $label)); ?>

                <?php endif; ?>

                <p class="help-block"></p>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label class='control-label'>&nbsp;</label>
            <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary pull-right autosave-js', 'data-control-area' => $form_id)); ?>		
        </div>
    </fieldset>
</div>
<?php echo Form::close(); ?>
