/***********************
 *** Notification Div*** 
 ***********************/

function show_message(msg) {
    $('#notificationDiv').html(msg).show();
}
function hide_message(msg) {
    $('#notificationDiv').html(msg).fadeOut(5000);
}


/***********************
 *** Notification Div*** 
 ***********************/
$(document).ready(function () {
    function toggleme(that) {
        if ($("#filter-js").css('display') == 'none') {
            $(".showHide i").attr("class", "fa fa-folder-open fa-2x");
            $("#filter-js").show(600);
        } else {
            $(".showHide i").attr("class", "fa fa-folder-o fa-2x");
            $("#filter-js").hide(600);
        }
    }
    ;

    $("#filter-trigger-js").click(function () {

        toggleme($(this));
    });

    /****************************************
     *** Trigger Modal using class for all*** 
     ****************************************/

    $(document).on('click', '.js-cms-modal-call', function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var data = {};

        var myModal = $('#js-cms-modal').modal('show');
        loadModalContent(url, data, $(this), myModal);

    });
    function loadModalContent(url, data, element, myModal) {
        $.ajax({
            type: 'get',
            url: url,
            data: data,
            dataType: 'html',
            beforeSend: function () {
                myModal.find(".cms-modal-content").html('<div class="cms-loader"> <i class="fa fa-spin fa-spinner"></i> </div>');
            },
            success: function (data) {
                var newHtml = myModal.find(".cms-modal-content").html(data);
            },
            error: function () {
                myModal.find(".cmsmodal-content").html('<div class="cms-loader"> Error </div>');
            }
        });
        return false;
    }

    /****************************************
     *** Trigger Modal using class for all*** 
     ****************************************/


    /***************************************
     *** Delete From Modal Script For All*** 
     ***************************************/
    $(document).on('click', '.delete-frm-modal-js', function (e) {
        var url = $(this).data('url');
        var ajaxload = $(this).data('ajax-load');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            // data: data,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status === "success") {
                    $('#js-cms-modal').modal('toggle');
                    window[ajaxload](1);
                }
                show_message(response.msg);
                hide_message(response.msg);
            },
            error: function () {
                show_message("Ajax Update Error");
                hide_message("Ajax Update Error");
            }
        });
        return false;

    });

    /***************************************
     *** Delete From Modal Script For All*** 
     ***************************************/

});