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
<?php if ($dates): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Summary</th>
                <th>Date</th>
                <th>Created on</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="highlightElement">
            <?php $num = 0; ?>
            <?php foreach ($dates as $date): ?>	
                <tr <?php
                if ($num % 2 == 1) {
                    echo "class='odd'";
                } else {
                    echo "class='even'";
                };
                $num++;
                ?>>

                    <td><?php
                        echo $date->title;
                        ?>
                    </td>
                         <td><?php
                        echo $date->summary;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $date->date);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo date("l jS F Y", $date->created_at);
                        ?>
                    </td>
                    <td>
                        <span class="fancyLink" ><?php echo Html::anchor('admin/date/edit/' .$date->id, '<span class="action"><i class="fa fa-pencil" title="Edit User"></i></span>'); ?></span>
                        <?php /* ?>
                          <span class="fancyLink" ><?php echo Html::anchor('admin/users/delete/' . $user->id, '<span class="action red"><i class="fa fa-trash-o" title="Delete User"></i></span>'); ?></span>
                          <?php */ ?>
                        <?php echo Html::anchor('admin/date/delete/'.$date->id, '<span class="action red"><i class="fa fa-trash-o"></i></span>', array('title' => 'Delete date', 'class' => 'js-cms-modal-call')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>No Dates.</p>
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