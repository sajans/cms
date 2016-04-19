<h2>Viewing <span class='muted'>#<?php echo $category->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $category->name; ?></p>
<p>
	<strong>Keywords:</strong>
	<?php echo $category->keywords; ?></p>
<p>
	<strong>Meta:</strong>
	<?php echo $category->meta; ?></p>

<?php echo Html::anchor('category/edit/'.$category->id, 'Edit'); ?> |
<?php echo Html::anchor('category', 'Back'); ?>