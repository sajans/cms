<table class="table pagination-table">
    <tr>
        <td><?php echo $pagination->first; ?></td >
        <td><?php echo $pagination->prev; ?></td>
        <td><?php echo $pagination->pager; ?></td>
        <td><?php echo $pagination->next; ?></td>
        <td><?php echo $pagination->last; ?></td>  
        <td><?php echo $pagination->limiter; ?></td>                 
    </tr>
</table>
<?php if ($articles): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Writer</th>
                <th>Status</th>
                <th>Complete</th>
                <th>Created on</th>
                <th>Updated At</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="highlightElement">
            <?php $num = 0; ?>
            <?php foreach ($articles as $article): ?>	
                <tr <?php
                if ($num % 2 == 1) {
                    echo "class='odd'";
                } else {
                    echo "class='even'";
                };
                $num++;
                ?>>

                    <td><?php
                        echo $article->name;
                        ?>
                    </td>
                    <td><?php
                        if (strlen($article->description) > 50) {
                            echo substr($article->description, 0, 50);
                            echo "...";
                        } else {
                            echo $article->description;
                        }
                        ?></td>
                    <td>
                        <?php
                        echo Model_User::find($article->user_id)->username;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo ($article->status == 'A') ? "Active" : "Disabled";
                        ?>
                    </td>
                    <td>
                        <?php
                        echo ($article->completion == 'C') ? "Complete" : "Not Complete";
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $article->created_at);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $article->updated_at);
                        ?>
                    </td>
                    <td>
                        <span class="fancyLink" ><?php echo Html::anchor('admin/article/edit/' . $article->id, '<span class="action"><i class="fa fa-pencil" title="Edit User"></i></span>'); ?></span>
                        <?php if ($article->deleted == 0) { ?>
                            <?php echo Html::anchor('admin/article/delete/' . $article->id, '<span class="action red"><i class="fa fa-trash-o"></i></span>', array('title' => 'Delete Article', 'class' => 'js-cms-modal-call')); ?>
                        <?php } else { ?>
                            <?php echo Html::anchor('admin/article/make_active/' . $article->id, '<span class="action red"><i class="fa fa-exclamation-triangle"></i></span>', array('title' => 'Make Active Article','class'=>'js-article-update')); ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>No Category.</p>
<?php endif; ?> 


<table class="table pagination-table">
    <tr>
        <td><?php echo $pagination->first; ?></td>
        <td><?php echo $pagination->prev; ?></td>
        <td><?php echo $pagination->pager; ?></td>
        <td><?php echo $pagination->next; ?></td>
        <td><?php echo $pagination->last; ?></td>  
        <td><?php echo $pagination->limiter; ?></td>                 
    </tr>
</table>