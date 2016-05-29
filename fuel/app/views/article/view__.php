<script>
    $(document).ready(function () {
        $('.js-profile-pic-uploader').each(function () {
            pointer = $(this);
            button = $(this).find('input.uploader-data');
            var dev = $(this).find('.fileUploader');
            data_url = button.attr('data-url');
            button_text = button.attr('button-text');
            multiple_val = button.attr('multiple-val');
            object_id = button.attr('data-object-id');
            object_type = button.attr('data-object-type');
            user_id = button.attr('data-user-id');
            var name_input = $(this).find('input.js-upload-name');
            var image_tool = $(this).find('.js-image-tool');
            //var crop_url = $(this).find('.js-crop-popup');
            var delete_url = $(this).find('.js-logo-remove');
            uploader = new qq.FileUploader({
                action: data_url,
                element: dev[0],
                uploadButtonText: button_text,
                multiple: multiple_val,
                sizeLimit: 10485760, // 10 MB max size
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                template: '<div class="qq-uploader">' +
                        '<div class="qq-upload-drop-area"><span>{dragText}</span></div>' +
                        '<div type="hidden" class="uploader btn btn-primary btn-c-4 qq-upload-button">{uploadButtonText}</div>' +
                        '<ul class="qq-upload-list"></ul>' +
                        '</div>',
                params: {
                    object_id: object_id,
                    object_type: object_type,
                    user_id: user_id,
                },
                onComplete: function (id, fileName, responseJSON) {
                    if (responseJSON.success) {
                        $('.qq-upload-list').html('');
                        $(".js-cmpy-logo-name").val(responseJSON.full_filename); // in popup
                        $(".js-uploaded-logo-wrap").html('<img src="' + responseJSON.uri + '" id="image" class="img-responsive" style="width:100%;">');
                        //crop_url.attr('href', base_url + 'overlay/crop?pid=' + object_id + '&photo=' + responseJSON.full_filename);
                        delete_url.attr("data-photo", responseJSON.full_filename);
                        delete_url.attr("data-upload_id", responseJSON.upload_id);
                        // Notifier.success('uploaded_successfully');
                        //            image_tool.show();
                        dev.hide();
                    } else {
                        // Notifier.error('allowable_formats');
                    }
                },
                onProgress: function (id, fileName, loaded, total) {
                    var percent = (loaded / total) * 100;
                    //console.log(percent);
                },
                onUpload: function (id, fileName) {
                    // Notifier.notify('uploading');
                },
                showMessage: function (message) {
                    // Notifier.error(message);
                },
                debug: true,
            });
        });


    });
    function removeUploads(that) {
        var article_id = $(that).attr('data-article_id');
        var image = $(that).attr('data-photo');
        var upload_id = $(that).attr('data-upload_id');
        var type_id = $(that).attr('data-type-id');
        $.ajax({
            type: "POST",
            cache: false,
            data: {article_id:article_id,image: image, type_id: type_id, upload_id: upload_id},
            url: base_url + 'article/remove_pic',
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $('.js-logo-remove').attr("data-photo", '');
                    $('.js-logo-remove').attr("data-upload_id", '');
                    $(".js-uploaded-logo-wrap").html('<span class="img-upload-cir">Add a Logo</span>');
                    $('.js-image-tool ').hide();
                    $('.fileUploader').show();
                    $('.js-upload-name').val('');
                    //   Notifier.success(response.msg);
                } else {
                    //  Notifier.error(response.msg);
                }
            }
        });
        return false;
    }
</script>


<!-- Page Content -->
<div class="container">
    <!-- Heading Row -->
    <div class="row">
        <div class="center">
            <h3> Sajan Sudedi</h3>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="js-uploaded-logo-wrap">
                <img class="img-responsive img-rounded" src="<?= isset($uploads) ? Uri::create("upload/get_image/" . $uploads->name . "/" . $uploads->id) : '' ?>" alt="">
            </div>
            <?php if (isset($current_user) && $current_user->group == 100): ?>
                <span class="js-profile-pic-uploader" <?php echo ($uploads) ? 'style="display: none;"' : '' ?> >
                    <input type="hidden" class="uploader-data" data-url="<?php echo Uri::create('article/upload_pic'); ?>" data-user-id="<?= $current_user->id; ?>" data-object-type="7" data-object-id="<?php echo $article->id; ?>" button-text= "Upload a Picture" multiple-val= "false" />
                    <input type="hidden" name="logo" class="js-upload-name" value="">
                    <span class="fileUploader text-center"> </span>
                </span>
                <div class="js-image-tool" <?php echo ($uploads) ? '' : 'style="display: none;"' ?>>
                    <a class="js-logo-remove btn btn-danger" data-type-id="<?php echo isset($uploads) ? $uploads->type_id : ''; ?>" data-upload_id="<?php echo isset($uploads) ? $uploads->id : ''; ?>" data-article_id="<?php echo $article->id; ?>" data-photo="<?php echo isset($uploads) ? $uploads->name : ''; ?>" onclick="removeUploads(this);">Delete</a>
                </div>


            <?php endif; ?>

        </div>
        <div class="col-md-4">
            <form id="detail-form">
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label>Name</label>
                    </div>
                    <div class="col-sm-7">
                        <span class="input-sm">
                            Sajan Subedi
                        </span>
                    </div>
                </div>
                <?php foreach ($fields as $key => $label): ?>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <label><?= $label; ?></label>
                        </div>
                        <div class="col-sm-7">
                            <span class="input-sm">
                                <?= ($this->article->detail->$key) ? $this->article->detail->$key : 'Null'; ?>
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>

            </form>

            <?php if (isset($current_user) && $current_user->group == 100): ?>
                <a href="<?= Uri::create('article/edit_info/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil pull-right" title="Edit Info"></i></a>
            <?php endif; ?>

        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                    <?php foreach ($article->dates as $dates): ?>
                        <tr>
                            <td><?= $dates->title; ?></td>
                            <td>
                                <?=
                                date('l \, jS F \of Y', $dates->date);
                                ?>
                            </td>
                            <?php if (isset($current_user) && $current_user->group == 100): ?>
                                <td>
                                    <a href="<?= Uri::create('article/edit_date/' . $article->id . '/' . $dates->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil pull-right" title="Edit Dates"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach;
                    ?>

                </thead>
            </table>
            <!--Create New Date -->
            <?php if (isset($current_user) && $current_user->group == 100): ?>
                <a href="<?= Uri::create('article/create_date/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-calendar pull-right" title="Add New Dates"></i></a>
            <?php endif; ?>
        </div>
    </div>

    <!-- /.row -->

    <hr>
    <!-- Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="well text-center">
                <p>
                    <?= $article->description; ?>
                </p>


            </div>
        </div>
        <!-- /.col-lg-12 -->
        <?php if (isset($current_user) && $current_user->group == 100): ?>
            <a href="<?= Uri::create('article/edit_article/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil pull-right" title="Edit Info"></i></a>
        <?php endif; ?>

    </div>
    <!-- /.row -->

    <!-- People Also Like -->
    <div class="related">
        <h3>You may like</h3>
        <div class="row">
            <div class="col-md-4">
                <h4>Heading 1</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h4>Heading 2</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h4>Heading 3</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <!-- Footer -->

    </div>
</div>
<br>
<br>
<!-- /.container -->
<style>
    .related img{
        float:left;
        margin: 0px 14px 5px 0px;
    }
</style>


