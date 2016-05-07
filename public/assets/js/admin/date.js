var base_url = Beard.root;
function initDateView() {
    $('#settingsLink').parent().addClass('active');
    loadDateGrid(1);
}

function loadDateGrid(page, limit) {
    var name = $("#form_username").val();
    $.ajax({
        type: "POST",
        cache: false,
        data: {name: name, page: page, limit: limit},
        url: base_url + "admin/date/grid",
        start: show_message('refreshing..'),
        dataType: "html",
        success: function (response) {
            $("#categoryDiv").html(response);
            initDateGrid();
            hide_message(response.msg);

        }
    });

}



function initDateGrid()
{
    //  $(".fancyLink a").fancybox({type: 'iframe', 'autoDimensions': false, 'width': 800, 'height': '100%', titleShow: false, });

}
function filterDate() {
    var limit = $('#paginator-limit-Date').val();
    var page = 1;
    loadDateGrid(page, limit);
    show_message("Searching…");
    hide_message("Searching…");

}


function resetFilters() {
    $("#form_email").val("")
    $("#form_username").val("")
    $("#filter-trigger-js").click();
    filterDate();
}
function deleteDate(id, elem) {
    $.jconfirm(
            'Are you sure you want to delete this Date?',
            'Delete Category'
            ), function () {
        $.ajax({
            url: "ajax_career_delete.php",
            type: "GET",
            data: "career_id=" + career_id,
            success: function (response) {
                alert('Career deleted');
            }
        })
    };
}


