<script type="text/javascript"src="<?= uri::create('assets/js/admin/article.js') ?>"></script>
<style>
    input[type='text'],select {
        width:170px;
        position:relative;
        top:3px;
    }
</style>  

<a href='javascript:void(0)' id="filter-trigger-js" class="moreinfo showHide"><i class="fa fa-folder-o fa-2x" title="filter"></i></a> &nbsp;
<span class="fancyLink"><?php echo Html::anchor('admin/article/create', '<i class="fa fa-plus-square fa-2x" title="Add Article"></i> ', array('class' => 'moreinfo', 'title' => 'Add User')); ?></span> 
<br />
<br />
<div id="filter-js" style="display:none" >
    <table class="table">
        <tr>
            <td>
                <div class="input email">
                    <?php echo Form::label('Name', 'name'); ?>
                    <?php echo Form::input('name', '', array('class' => '', 'onkeyup' => 'filterArticle()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Category', 'category'); ?>
                    <?php echo Form::select('category', '', $categories, array('class' => '', 'onchange' => 'filterArticle()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Writter', 'writter'); ?>
                    <?php echo Form::select('writter', '', $writters, array('class' => '', 'onchange' => 'filterArticle()')); ?>
                </div>
            </td>

        </tr>


        <tr>
            <td>
                <div class="input email">
                    <?php echo Form::label('Status', 'status'); ?>
                    <?php echo Form::select('status', '', array(''=>'All','A' => 'Active', 'R' => 'Reviewed', 'D' => 'Disabled'), array('class' => '', 'onchange' => 'filterArticle()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Deleted', 'deleted'); ?>
                    <?php echo Form::select('deleted', '', array(''=>'All','0' => 'Active', '1' => 'Deleted'), array('class' => '', 'onchange' => 'filterArticle()')); ?>
                </div>
            </td>
            <td>
                <div class="input email">
                    <?php echo Form::label('Completion', 'completion'); ?>
                    <?php echo Form::select('completion', '', array(''=>'All','C' => 'Complete', 'NC' => 'Not Complete'), array('class' => '', 'onchange' => 'filterArticle()')); ?>
                </div>
            </td>

        </tr>
    </table>
    <?php
    echo Html::anchor('javascript:void(0)', '<i class="fa fa-eraser fa-2x"></i>', array('onclick' => 'resetFilters();', 'style' => "float:right", "class" => "moreinfo"));
    ?>
    <div class="clear"></div>
</div>


<div id="articleDiv" class="datagrid-container">
    <div class="centered">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <script>initArticleView()</script>
</div>



