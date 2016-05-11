<script type="text/javascript"src="<?= uri::create('assets/js/admin/date.js') ?>"></script>
<style>
    input[type='text'],select {
        width:170px;
        position:relative;
        top:3px;
    }
</style>  
<a href='javascript:void(0)' id="filter-trigger-js" class="moreinfo showHide"><i class="fa fa-folder-o fa-2x" title="filter"></i></a> &nbsp;
<span class="fancyLink"><?php echo Html::anchor('admin/date/create', '<i class="fa fa-plus-square fa-2x" title="Add Category"></i> ', array('class' => 'moreinfo', 'title' => 'Add User')); ?></span> 
<br />
<br />

<div id="filter-js" style="display:none" >
    <table class="table">
        <tr>
            <td>
                <div class="input email">
                    <?php echo Form::label('Name', 'title'); ?>
                    <?php echo Form::input('title', '', array('class' => '', 'onkeyup' => 'filterDate()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Summary', 'summary'); ?>
                    <?php echo Form::input('summary', '', array('class' => '', 'onkeyup' => 'filterDate()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Date', 'date'); ?>
                    <?php echo Form::input('date', '', array('class' => '','id'=>'search-datepicker-js' ,'onkeyup' => 'filterDate()')); ?>
                </div>
            </td>
        </tr>
    </table>
    <?php
    echo Html::anchor('javascript:void(0)', '<i class="fa fa-eraser fa-2x"></i>', array('onclick' => 'resetFilters();', 'style' => "float:right", "class" => "moreinfo"));
    ?>
    <div class="clear"></div>
</div>


<div id="dateDiv" class="datagrid-container">
    <div class="centered">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <script>initDateView()</script>
    <script>
        $(function () {
            $("#search-datepicker-js").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
</div>


