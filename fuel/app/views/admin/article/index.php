<h2>Listing <span class='muted'>Articles</span></h2>
<br>
<?php if ($articles): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Category id</th>
			<th>Name</th>
			<th>Description</th>
			<th>Keywords</th>
			<th>Image</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($articles as $item): ?>		<tr>

			<td><?php echo $item->category_id; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->description; ?></td>
			<td><?php echo $item->keywords; ?></td>
			<td><?php echo $item->image; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('article/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-small')); ?>						<?php echo Html::anchor('article/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-small')); ?>						<?php echo Html::anchor('article/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-small btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Articles.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('article/create', 'Add new Article', array('class' => 'btn btn-success')); ?>

</p>
