<h2>Viewing <span class='muted'>#<?php echo $article->id; ?></span></h2>

<p>
	<strong>Category id:</strong>
	<?php echo $article->category_id; ?></p>
<p>
	<strong>Name:</strong>
	<?php echo $article->name; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $article->description; ?></p>
<p>
	<strong>Keywords:</strong>
	<?php echo $article->keywords; ?></p>
<p>
	<strong>Image:</strong>
	<?php echo $article->image; ?></p>

<?php echo Html::anchor('article/edit/'.$article->id, 'Edit'); ?> |
<?php echo Html::anchor('article', 'Back'); ?>