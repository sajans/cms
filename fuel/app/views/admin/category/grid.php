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
<?php if ($categories): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created on</th>
                <th>Updated At</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="highlightElement">
            <?php $num = 0; ?>
            <?php foreach ($categories as $category): ?>	
                <tr <?php
                if ($num % 2 == 1) {
                    echo "class='odd'";
                } else {
                    echo "class='even'";
                };
                $num++;
                ?>>
                
                    <td><?php
                        echo $category->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $category->created_at);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $category->updated_at);
                        ?>
                    </td>
                    <td>
                        <span class="fancyLink" ><?php echo Html::anchor('admin/category/edit/' . $category->id, '<span class="action"><i class="fa fa-pencil" title="Edit User"></i></span>'); ?></span>
                        <?php /* ?>
                          <span class="fancyLink" ><?php echo Html::anchor('admin/users/delete/' . $user->id, '<span class="action red"><i class="fa fa-trash-o" title="Delete User"></i></span>'); ?></span>
                          <?php */ ?>
                        <?php echo Html::anchor('javascript:void(0)', '<span class="action red"><i class="fa fa-trash-o"></i></span>', array('title' => 'Delete User', 'onclick' => "deleteCategory($category->id,this); return false;")); ?>
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