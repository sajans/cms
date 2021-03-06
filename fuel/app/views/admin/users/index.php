<script type="text/javascript"src="<?= uri::create('assets/js/admin/users.js') ?>"></script>
<style>
    input[type='text'],select {
        width:170px;
        position:relative;
        top:3px;
    }
</style>  

<a href='javascript:void(0)' id="filter-trigger-js" class="moreinfo showHide"><i class="fa fa-folder-o fa-2x" title="filter"></i></a> &nbsp;
<span class="fancyLink"><?php echo Html::anchor('admin/users/create', '<i class="fa fa-user-plus fa-2x" title="Add User"></i> ', array('class' => 'moreinfo', 'title' => 'Add User')); ?></span> 
<br />
<br />

<div id="filter-js" style="display:none" >
    <table class="table">
        <tr>
            <td>
                <div class="input email">
                    <?php echo Form::label('UserName', 'username'); ?>
                    <?php echo Form::input('username', '', array('class' => '', 'onkeyup' => 'filterUsers()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Email', 'email'); ?>
                    <?php echo Form::input('email', '', array('class' => '', 'onkeyup' => 'filterUsers()')); ?>
                </div>
            </td>
        </tr>
    </table>
    <?php
    echo Html::anchor('javascript:void(0)', '<i class="fa fa-eraser fa-2x"></i>', array('onclick' => 'resetFilters();', 'style' => "float:right", "class" => "moreinfo"));
    ?>
    <div class="clear"></div>
</div>


<div id="usersDiv" class="datagrid-container">
    <div class="centered">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <script>initUsersView()</script>
</div>


