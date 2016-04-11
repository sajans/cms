//Notification Div

function show_message(msg) {
    $('#notificationDiv').html(msg).show();
}
function hide_message(msg) {
    $('#notificationDiv').html(msg).fadeOut(5000);
}


//Notification Div
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

});