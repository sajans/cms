function ProposalCoverCrop() {
    var image = document.getElementById('image');
    var cropBoxData;
    var canvasData;
    var cropInit;
    cropInit = new Cropper(image, {
        autoCropArea: 0.9,
        aspectRatio: 16 / 6,
        built: function () {
            // Strict mode: set crop box data first
            cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });

    cropper = cropInit;
}

function UserCoverCrop() {
    var image = document.getElementById('image');
    var cropBoxData;
    var canvasData;
    var cropInit;
    cropInit = new Cropper(image, {
        autoCropArea: 0.9,
        aspectRatio: 16 / 4,
        built: function () {
            // Strict mode: set crop box data first
            cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });

    cropper = cropInit;
}

function TeamMemberPhotoCrop() {
    var image = document.getElementById('image');
    var cropBoxData;
    var canvasData;
    var cropInit;
    cropInit = new Cropper(image, {
        autoCropArea: 0.9,
        aspectRatio: 16 / 16,
        built: function () {
            // Strict mode: set crop box data first
            cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        }
    });

    cropper = cropInit;
}

$(document).ready(function () {
    $(".js-Profile-Cover-Crop").click(function () {
        $(".js-crop-wrapper").hide();
        theming = '';
        var croppedCanvas;
        croppedCanvas = cropper.getCroppedCanvas();
        var Image = croppedCanvas.toDataURL()
        var uid = parent.$('#js-investor-id').val();
        var uploadedfrom = $(".js-uploaded-from").val();
        if (uploadedfrom == 1) {
            theming = 1; // From admin Side;
        }
        if (theming) {
            parent.parent.show_message(labels.cropping);
        } else {
            Notifier.success(labels.cropping);
        }
        $("#js-cover-loading-div").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            type: "POST",
            cache: false,
            url: base_url + 'investor/crop_investor_cover_photo',
            data: {imgpath: Image, uid: uid},
            dataType: 'json',
            success: function (response) {
                var path = base_url + 'investor/get_investor_cover_photo/' + response.background_name + '/' + uid;
                parent.$("#cover-wrapper").html("<img src='" + path + "' class='uploaded-background'>");
                parent.$('input.bck-image-name').val(response.background_name);
                parent.$("#js-crop-cover").attr('href', base_url + 'overlay/crop_cover/profile?id=' + uid + '&cover=' + response.background_name);
                if (theming) {
                    parent.$("#js-uploaded-cover").html("<img src='" + path + "' class='uploaded-background test' style='max-height: 100px;'>");
                    parent.$("#js-crop-cover").attr('href', base_url + 'overlay/crop_cover/profile/1?id=' + uid + '&cover=' + response.background_name);
                } else {
                    parent.$("#js-crop-cover").attr('href', base_url + 'overlay/crop_cover/profile?id=' + uid + '&cover=' + response.background_name);
                }
                if (theming) {
                    parent.parent.show_message(response.msg);
                    parent.parent.hide_message(response.msg);
                    parent.$.fancybox.close();
                } else {
                    Notifier.success(response.msg);
                    $("#js-ain-modal").modal('hide');
                }
                cropper.destroy();
            }
        });
    });

    $(".js-Proposal-Cover-Crop").click(function () {
        $(".js-crop-wrapper").hide();
        var croppedCanvas;
        croppedCanvas = cropper.getCroppedCanvas();
        var Image = croppedCanvas.toDataURL()

        theming = '';
        var propId = $('#js-proposal-id').val();
        if (!propId) {
            propId = parent.$('#js-proposal-id').val(); // for admin section
        }
        var flag = $("#js-proposal-from").val(); //From Proposal Detail Page
        if (flag) {
            var path = $("#js-uploaded-cover .uploaded-background").attr('src');
        } else {
            flag = 0; //from crop popup Only
            var path = $(".js-uploaded-background").val();
            var uploadedfrom = $(".js-uploaded-from").val();
            if (uploadedfrom == 1) {
                theming = 1; // From admin Side;
            }
        }

        if (theming) {
            parent.parent.show_message(labels.cropping);
        } else {
            Notifier.success(labels.cropping);
        }
        $("#js-cover-loading-div,.js-uploaded-cover").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            type: "POST",
            cache: false,
            url: base_url + 'proposal/crop_proposal_cover_photo',
            data: {imgpath: Image, propId: propId},
            dataType: 'json',
            success: function (response) {
                var path = base_url + 'proposal/get_proposal_cover_photo/' + response.background_name + '/' + propId;
                if (flag != '0') {
                    parent.$("#js-prop-" + propId).find("#proposal-cover-wrapper").html("<img src='" + path + "' class='uploaded-background'>");
                    parent.$('input.bck-image-name').val(response.background_name);
                } else {
                    parent.$("#js-uploaded-cover").html("<img src='" + path + "' class='uploaded-background test' style='max-height: 100px;'>");
                    parent.$('input.bck-image-name').val(response.background_name);
                    if (theming) {
                        parent.$("#js-crop-cover").attr('href', base_url + 'overlay/crop_cover/proposal/1?id=' + propId + '&cover=' + response.background_name);
                    } else {
                        parent.$("#js-crop-cover").attr('href', base_url + 'overlay/crop_cover/proposal?id=' + propId + '&cover=' + response.background_name);
                    }
                }
                if (theming) {
                    parent.parent.show_message(response.msg);
                    parent.parent.hide_message(response.msg);
                    parent.$.fancybox.close();
                } else {
                    Notifier.success(response.msg);
                    $("#js-ain-modal").modal('hide');
                }
                cropper.destroy();
            }
        });

    });

    $(".js-Team-Crop").click(function () {
        $(".js-crop-wrapper").hide();
        var croppedCanvas;
        croppedCanvas = cropper.getCroppedCanvas();
        var Image = croppedCanvas.toDataURL()
        theming = '';
        var propId = $('.js-proposal-id').val();
        var photo = $('.js-uploaded-photo').val();
        var uploadedfrom = $(".js-uploaded-from").val();
        var team_id = $('.js-Crop-this').parents('.team-members-block').find('.js-team-member-id').val();
        if (uploadedfrom == 1) {
            theming = 1; // From admin Side;
        }
        if (theming) {
            var team_id = parent.$('.js-Crop-this').parents('.team-members-block').find('.js-team-member-id').val();
            parent.parent.show_message(labels.cropping);
        } else {
            var team_id = $('.js-Crop-this').parents('.team-members-block').find('.js-team-member-id').val();
            Notifier.success(labels.cropping);
        }
        $("#js-cropper-loading-div").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            type: "POST",
            cache: false,
            url: base_url + 'proposal/crop_team_member_photo',
            data: {imgpath: Image, propId: propId, photo: photo, team_id: team_id},
            dataType: 'json',
            success: function (response) {
                var path = base_url + 'proposal/get_team_member_photo/' + response.team_photo_name + '/' + propId + '?' + Math.random();
                if (theming) {
                    parent.$('.js-Crop-this').attr('src', path);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('input.js-image-name').val(response.team_photo_name);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('.js-crop-popup').attr('href', base_url + 'overlay/crop/1?pid=' + propId + '&photo=' + response.team_photo_name);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('.js-teamphoto-remove').attr("data-photo", response.team_photo_name);
                } else {
                    $('.js-Crop-this').attr('src', path);
                    $('.js-Crop-this').parents('.team-members-block').find('input.js-image-name').val(response.team_photo_name);
                    $('.js-Crop-this').parents('.team-members-block').find('.js-crop-popup').attr('href', base_url + 'overlay/crop?pid=' + propId + '&photo=' + response.team_photo_name);
                    $('.js-Crop-this').parents('.team-members-block').find('.js-teamphoto-remove').attr("data-photo", response.team_photo_name);
                }
                if (theming) {
                    parent.parent.show_message(response.msg);
                    parent.parent.hide_message(response.msg);
                    parent.$.fancybox.close();
                } else {
                    Notifier.success(response.msg);
                    $("#js-ain-modal").modal('hide');
                }
                cropper.destroy();
            }
        });

    });

    $(".js-Team-Broking-Crop").click(function () {
        $(".js-crop-wrapper").hide();
        var croppedCanvas;
        croppedCanvas = cropper.getCroppedCanvas();
        var Image = croppedCanvas.toDataURL()
        theming = '';
        var propId = $('.js-proposal-id').val();
        var photo = $('.js-uploaded-photo').val();
        var uploadedfrom = $(".js-uploaded-from").val();
        if (uploadedfrom == 1) {
            theming = 1; // From admin Side;
        }
        if (theming) {
            parent.parent.show_message(labels.cropping);
        } else {
            Notifier.success(labels.cropping);
        }
        $("#js-cropper-loading-div").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            type: "POST",
            cache: false,
            url: base_url + 'admin/broking/proposaldetail/crop_team_member_photo',
            data: {imgpath: Image, propId: propId, photo: photo},
            dataType: 'json',
            success: function (response) {
                var path = base_url + 'admin/broking/proposaldetail/get_team_member_photo/' + response.team_photo_name + '/' + propId + '?' + Math.random();
                if (theming) {
                    parent.$('.js-Crop-this').attr('src', path);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('input.js-image-name').val(response.team_photo_name);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('.js-crop-popup').attr('href', base_url + 'overlay/broking_crop/1?pid=' + propId + '&photo=' + response.team_photo_name);
                    parent.$('.js-Crop-this').parents('.team-members-block').find('.js-teamphoto-remove').attr("data-photo", response.team_photo_name);
                } else {
                    $('.js-Crop-this').attr('src', path);
                    $('.js-Crop-this').parents('.team-members-block').find('input.js-image-name').val(response.team_photo_name);
                    $('.js-Crop-this').parents('.team-members-block').find('.js-crop-popup').attr('href', base_url + 'overlay/broking_crop?pid=' + propId + '&photo=' + response.team_photo_name);
                    $('.js-Crop-this').parents('.team-members-block').find('.js-teamphoto-remove').attr("data-photo", response.team_photo_name);
                }
                if (theming) {
                    parent.parent.show_message(response.msg);
                    parent.parent.hide_message(response.msg);
                    parent.$.fancybox.close();
                } else {
                    Notifier.success(response.msg);
                    $("#js-ain-modal").modal('hide');
                }
                cropper.destroy();
            }
        });

    });
});