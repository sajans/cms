<h2>Viewing <span class='muted'>#<?php echo $date->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $date->name; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $date->description; ?></p>
<p>
	<strong>Date:</strong>
	<?php echo $date->date; ?></p>
<p>
	<strong>Keywords:</strong>
	<?php echo $date->keywords; ?></p>

<?php echo Html::anchor('date/edit/'.$date->id, 'Edit'); ?> |
<?php echo Html::anchor('date', 'Back'); ?>