<div class="container">

    <div class="ma-b-30">

    </div>
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <?php ?>    
            <div class="search-block">
                <div id="date-search-js" style="display:none;">
                    <form class="searchbox" action="#">
                        <input class="search-field-js datepicker-js" type="search" placeholder="Search people,place,events or dates...." />
                        <button type="submit" value="date" class="search-btn-js">&nbsp;</button>
                    </form>

                </div>
                <div id="text-search-js">
                    <form class="searchbox" action="#">
                        <input class="search-field-js" type="search" placeholder="Search people,place,events or dates...." />
                        <button type="submit" value="text" class="search-btn-js">&nbsp;</button>
                    </form>
                </div>
                <div class="search-selector text-center">
                    <input type="radio" class="input-js" name="type" data-type="text" value="text" checked="checked"><label><h3>Text</h3></label>
                    <input type="radio" class="input-js" name="type" data-type="date" value="date"><label><h3>Date</h3></label>


                </div>
            </div>

            <?php ?>

        </div>
        <div class="col-md-2">

        </div>
    </div>
    <hr>
    <div class="ma-b-30">

    </div>
    <div class="ma-b-30">

    </div>
    <div class="row">
        <div class="search-result-js">
            <?= View::forge("article/search_results", array(), false); ?>
        </div>
    </div>
    <div class="ma-b-60">

    </div>
</div>
<script>
    $(function () {
        $(".datepicker-js").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

    $(".input-js").on('change', function (e) {
        e.preventDefault();
        if (($(this).data('type') === 'date')) {
            $("#text-search-js").hide();
            $("#date-search-js").show();
        } else {
            $("#date-search-js").hide();
            $("#text-search-js").show();
        }

    });
    $(document).on('click', '.search-btn-js', function (e) {
        var url = "<?= Uri::create("article/search"); ?>";
        var search_field = $(this).parent().find(".search-field-js").val();
        var search_type = $(this).val();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url,
            data: {search_field: search_field, search_type: search_type},
            dataType: 'json',
            beforeSend: function () {
                $('.search-result-js').html("<h1>Searching......</h1>");
            },
            success: function (response) {
                if (response.status === "success") {
                    $('.search-result-js').html(response.html);
                }
            },
            error: function () {
                show_message("Ajax Update Error");
                hide_message("Ajax Update Error");
            }
        });
        return false;

    });

</script>
<style>
    #ui-datepicker-div{width:50%}
</style>