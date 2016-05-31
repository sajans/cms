<script>
    $(document).ready(function () {
        $('.js-upload-block').each(function () {
            pointer = $('.js-profile-pic-uploader');
            button = pointer.find('input.uploader-data');
            //var dev = pointer.find('.fileUploader');
            var dev = pointer;
            data_url = button.attr('data-url');
            button_text = button.attr('button-text');
            multiple_val = button.attr('multiple-val');
            object_id = button.attr('data-object-id');
            object_type = button.attr('data-object-type');
            user_id = button.attr('data-user-id');
            var image_tool = $(this).find('.js-image-tool');
            var delete_url = image_tool.find('.js-logo-remove');
            var display_tool = $(this).find(".js-uploaded-file-wrap");
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
                        display_tool.html('<img src="' + responseJSON.uri + '" class="img-responsive" style="width:100%;">');
                        delete_url.attr("data-photo", responseJSON.full_filename);
                        delete_url.attr("data-upload_id", responseJSON.upload_id);
                        dev.hide();
                        image_tool.show();
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
        var type_id = $(that).attr('data-type_id');
        var pointer = $(that).parent().closest('.js-upload-block');
        var dev = pointer.find(".js-profile-pic-uploader");
        var image_tool = pointer.find('.js-image-tool');
        var display_tool = pointer.find(".js-uploaded-file-wrap");
        $.ajax({
            type: "POST",
            cache: false,
            data: {article_id: article_id, image: image, type_id: type_id, upload_id: upload_id},
            url: base_url + 'article/remove_pic',
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    display_tool.html('<img class="img-responsive" src="" alt="">');
                    dev.show();
                    $(that).attr("data-photo", '');
                    $(that).attr("data-upload_id", '');
                    image_tool.hide();
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
    <div class="row">
        <div class="col-md-4">
            <div class="article-info-block same-row-info">
                <div class="js-upload-block">
                    <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>
                        <div class="js-image-tool" <?php echo ($uploads) ? '' : 'style="display: none;"' ?>>
                            <a class="fa fa-crop js-cms-modal-call js-crop-image" href="<?= isset($uploads->id)?Uri::create("upload/crop_init?type_id=7&article_id=".$article->id."&upload_id=".$uploads->id):"#" ; ?>"></a>
                            <a class="js-logo-remove fa fa-trash-o alert-danger" data-type_id="7" data-upload_id="<?php echo isset($uploads) ? $uploads->id : ''; ?>" data-article_id="<?php echo $article->id; ?>" data-photo="<?php echo isset($uploads) ? $uploads->name : ''; ?>" onclick="removeUploads(this);" title="Delete Picture"></a>
                        </div>
                    <?php endif; ?>

                    <div class="js-uploaded-file-wrap">
                        <img class="img-responsive" src="<?= isset($uploads) ? Uri::create("upload/get_image/" . $uploads->name . "/" . $uploads->id) : '' ?>" alt="">
                    </div>
                    <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>

                        <span class="js-profile-pic-uploader" <?php echo ($uploads) ? 'style="display: none;"' : '' ?> >
                            <input type="hidden" class="uploader-data" data-url="<?php echo Uri::create('article/upload_pic'); ?>" data-user-id="<?= $current_user->id; ?>" data-object-type="7" data-object-id="<?php echo $article->id; ?>" button-text= "Upload a Picture" multiple-val= "false" />
                            <input type="hidden" name="logo" class="js-upload-name" value="">
                            <span class="fileUploader text-center"> </span>
                        </span>

                    <?php endif; ?>


                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="article-info-block same-row-info">
                <form id="detail-form">
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <label>Name</label>
                        </div>
                        <div class="col-sm-7">
                            <span class="input-md">
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
                                <span class="input-md">
                                    <?= ($this->article->detail->$key) ? $this->article->detail->$key : 'Null'; ?>
                                </span>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </form>

                <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>
                    <a href="<?= Uri::create('article/edit_info/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil pull-right" title="Edit Info"></i></a>
                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="article-info-block same-row-info">
                <table class="table">
                    <thead>
                        <?php foreach ($article->dates as $dates): ?>
                            <tr>
                                <td style="font-weight: bolder;"><?= $dates->title; ?></td>
                                <td>
                                    <?=
                                    date('l \, jS F \of Y', $dates->date);
                                    ?>
                                </td>
                                <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>
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
                <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>
                    <a href="<?= Uri::create('article/create_date/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-calendar pull-right" title="Add New Dates"></i></a>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- /.row -->
    <br>
    <!-- Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center article-info-block description-block">
                <p>
                    <?= nl2br($article->description); ?>
                </p>
                <?php if (isset($current_user) && $current_user->group == 100 && $admin): ?>
                    <a href="<?= Uri::create('article/edit_article/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil pull-right" title="Edit Info"></i></a>
                <?php endif; ?>

            </div>
        </div>
        <!-- /.col-lg-12 -->


    </div>
    <!-- /.row -->

    <!-- People Also Like -->
    <div class="related">
        <h3>You may like</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="same-row-display article-info-block">
                    <h4 class="text-center">Heading 1</h4>
                    <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                    <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                    <div class="btn-group text-center">
                        <a class="btn btn-default" href="#">More Info</a>
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="same-row-display article-info-block">
                    <h4 class="text-center">Heading 2</h4>
                    <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                    <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                    <div class="btn-group text-center">
                        <a class="btn btn-default" href="#">More Info</a>
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="same-row-display article-info-block">
                    <h4 class="text-center">Heading 3</h4>
                    <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                    <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                    <div class="btn-group text-center">
                        <a class="btn btn-default" href="#">More Info</a>
                    </div>
                </div>
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
    .js-image-tool{
        position: absolute;
        margin-left: 290px;
    }
    //#cms-page{background-color: #80C2D0;}
    .header{    background: #80C24C; height: 70px;}
    //.article-info-block{background: #80C2A2; padding:15px;border-radius: 15px;}
    .article-info-block{background: #EEE; padding:15px;border-radius: 15px;}
    .same-row-info{min-height: 360px;}
    .logo-text{font-size:24px;}
    small{font-size: 12px;color:red;font-style: italic}
    .js-uploaded-file-wrap {width: 328px; height: 328px;}
    .js-uploaded-file-wrap img{border-radius: 15px;}
    .description-block{min-height:400px;}
    .qq-uploader {
        position: relative;
        margin-top: -192px;
        width:100%;
    }
    .same-row-display{min-height: 200px;}
    .footer{background: #80C24C;}

</style>


