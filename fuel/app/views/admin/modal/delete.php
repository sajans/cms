<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Are You Sure Want to Delete <?= $control; ?> ?</h4>
</div>
<div class="modal-body">
    <button type="button" class="btn btn-danger delete-frm-modal-js" data-ajax-load="<?= $ajaxload; ?>" data-url="<?= $url; ?>">Yes</button>
    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Not Now</button>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>