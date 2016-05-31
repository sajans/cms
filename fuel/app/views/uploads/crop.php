<?php /* ?>
<!-- load Jquery if from admin side -->
<script src="<?= uri::create('assets/js/jquery-1.11.1.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= uri::create('assets/js/notifier/notifier.js') ?>"></script>  
<?php echo View::forge('js/variables'); ?>
<?php */ ?>
<!-- IMAGE CROPPER PLUGIN START -->
<link rel="stylesheet" href="<?= uri::create('assets/css/cropper/cropper.css') ?>">
<script type="text/javascript" src="<?= uri::create('assets/js/cropper/cropper.js') ?>"></script>
<script type="text/javascript" src="<?= uri::create('assets/js/cropper/crop.js') ?>"></script>


<div class="modal-header">        
    <h3>Crop Image</h3>
</div>
<div class="modal-body">
    <div id="js-cover-loading-div" >
        <input type="hidden" id="crop_upload_id" name="upload_id" value="<?=  $uploads->id; ?>">
        <img width="100%" id="image" src="<?php echo Uri::create('upload/get_image/' . $uploads->name . '/' . $uploads->id) ?>" />
        <script>
            ArticleCrop();
        </script>
    </div>
    <br>
    <div class="js-crop-wrapper">
        <button class="js-Article-Crop btn btn-lg btn-primary">Crop</button>
        <button class="btn btn-lg btn-default" data-dismiss="modal" aria-label="Close" >Close</button>												
    </div>
</div>	
<div class="modal-footer">

</div>
