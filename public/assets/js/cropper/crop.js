function ArticleCrop() {
    var image = document.getElementById('image');
    var cropBoxData;
    var canvasData;
    var cropInit;
    cropInit = new Cropper(image, {
        autoCropArea: 0.9,
        aspectRatio: 14.4 / 16,
        built: function () {
            // Strict mode: set crop box data first
            cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });

    cropper = cropInit;
}

$(document).ready(function () {
    $(".js-Article-Crop").click(function () {
        $(".js-crop-wrapper").hide();
        var croppedCanvas;
        croppedCanvas = cropper.getCroppedCanvas();
        var Image = croppedCanvas.toDataURL();
        var upload_id = $('#crop_upload_id').val();
        $("#js-cover-loading-div").html('<i class="fa fa-spin fa-spinner"></i>');
        parent.$("#upload_img_" + upload_id).parent().parent().find(".js-uploaded-file-wrap").html('<i class="fa fa-spin fa-spinner" id="upload_img_' + upload_id + '"></i>');
        $.ajax({
            type: "POST",
            cache: false,
            url: base_url + 'upload/crop_upload',
            data: {imgpath: Image, upload_id: upload_id},
            dataType: 'json',
            success: function (response) {
                var path = base_url + 'upload/get_image/' + response.background_name + '/' + upload_id;
                //parent.$(".js-uploaded-file-wrap").html('<img src="' + path + '" class="img-responsive" style="width:100%;">');
                parent.$("#upload_img_" + upload_id).parent().parent().find(".js-uploaded-file-wrap").html('<img src="' + path + '" class="img-responsive" style="width:100%;" id="upload_img_' + upload_id + '">');
                //Notifier.success(response.msg);
                $("#js-cms-modal").modal('toggle');
                cropper.destroy();
            }
        });
    });


});