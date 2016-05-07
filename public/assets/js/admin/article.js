var base_url = Beard.root;
function initArticleView() {
    $('#settingsLink').parent().addClass('active');
    loadArticleGrid(1);
}

function loadArticleGrid(page, limit) {
    var name = $("#form_name").val();
    var category = $("#form_category").val();
    var writter = $("#form_writter").val();
    var status = $("#form_status").val();
    var deleted = $("#form_deleted").val();
    var completion = $("#form_completion").val();
    $.ajax({
        type: "POST",
        cache: false,
        data: {name: name, category: category, writter: writter, status: status, deleted: deleted, completion: completion, page: page, limit: limit},
        url: base_url + "admin/article/grid",
        start: show_message('refreshing..'),
        dataType: "html",
        success: function (response) {
            $("#articleDiv").html(response);
            initArticleGrid();
            hide_message(response.msg);

        }
    });

}



function initArticleGrid()
{
    //  $(".fancyLink a").fancybox({type: 'iframe', 'autoDimensions': false, 'width': 800, 'height': '100%', titleShow: false, });

}

/*
 function addLabel() {
 //displayLoader();
 if ($("#labelsAddForm").valid()) {
 param = $("#labelsAddForm").serialize();
 $.ajax({
 type: "POST",
 cache: false,
 data: param,
 url: base_url + "admin/users/create",
 start: parent.show_message('Saving..'),
 dataType: "json",
 success: function (response) {
 //alert(response.status);
 if (response.status == 'success') {
 parent.show_message(response.msg);
 var limit = parent.$('#paginator-limit-Labels').val();
 var page = parent.$('#paginator-page-Labels').val();
 parent.loadLabelsGrid(page, limit);
 parent.hide_message(response.msg);
 parent.$.fancybox.close();
 
 } else {
 parent.show_message(response.msg);
 parent.hide_message(response.msg);
 }
 
 }
 });
 }
 }
 
 function editLabel(id) {
 //displayLoader();
 if ($("#labelsAddForm").valid()) {
 param = $("#labelsAddForm").serialize();
 $.ajax({
 type: "POST",
 cache: false,
 data: param,
 url: base_url + "admin/labels/edit/" + id,
 start: parent.show_message('Saving..'),
 dataType: "json",
 success: function (response) {
 //alert(response.status);
 if (response.status == 'success') {
 parent.show_message(response.msg);
 var limit = parent.$('#paginator-limit-Labels').val();
 var page = parent.$('#paginator-page-Labels').val();
 parent.loadLabelsGrid(page, limit);
 parent.hide_message(response.msg);
 parent.$.fancybox.close();
 
 } else {
 parent.show_message(response.msg);
 parent.hide_message(response.msg);
 }
 
 }
 });
 }
 }
 
 */

function filterArticle() {
    var limit = $('#paginator-limit-Article').val();
    var page = 1;
    loadArticleGrid(page, limit);
    show_message("Searching…");
    hide_message("Searching…");

}


function resetFilters() {
    $("#form_name").val("")
    $("#form_category").val("")
    $("#filter-trigger-js").click();
    filterArticle();
}

/**************************
 *** Make Article Active*** 
 **************************/
$(document).on('click', '.js-article-update', function (e) {
    var url = $(this).data('url');
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
                loadArticleGrid(1);
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

/**************************
 *** Make Article Active*** 
 **************************/


