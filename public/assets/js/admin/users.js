var base_url = Beard.root;
function initUsersView() {
    $('#settingsLink').parent().addClass('active');
    loadUsersGrid(1);
}

function loadUsersGrid(page, limit) {
   var username = $("#form_username").val();
   var email = $("#form_email").val();
    $.ajax({
        type: "POST",
        cache: false,
        data: {username: username,email:email,page: page, limit: limit},
        url: base_url + "admin/users/grid",
        //start: show_message('refreshing..'),
        dataType: "html",
        success: function (response) {
            $("#usersDiv").html(response);
            initUsersGrid();
            //hide_message(response.msg);

        }
    });

}



function initUsersGrid()
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

function filterUsers() {
    var limit = $('#paginator-limit-Users').val();
    var page = 1;
    loadUsersGrid(page, limit);
    show_message("Searching…");
    hide_message("Searching…");

}


function resetFilters() {
    $("#form_email").val("")
    $("#form_username").val("")
    $("#filter-trigger-js").click();
    filterUsers();
}

/*
function deleteUser(id, elem) {
    jConfirm(' Are you sure you want to delete this User?', 'Delete Label', function (r) {
        if (r == true) {
            $.ajax({
                type: "POST",
                cache: false,
                url: base_url + "admin/users/delete/" + id,
                start: show_message('Deleting..'),
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        show_message(response.msg);
                        $(elem).closest('tr').remove();
                        var limit = $('#paginator-limit-Labels').val();
                        var page = $('#paginator-page-Labels').val();
                        loadLabelsGrid(page, limit);
                        hide_message(response.msg);

                    } else {
                        show_message(response.msg);
                        hide_message(response.msg);
                    }


                }
            });
        }
    });
}
*/
function deleteUser(id, elem) {
  $.jconfirm(
       'Are you sure you want to delete this career?',
      'Delete Career'
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

