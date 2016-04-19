<h2>Editing <span class='muted'>Date</span></h2>
<br>

<?php echo render('date/_form'); ?>
<p>
	<?php echo Html::anchor('date/view/'.$date->id, 'View'); ?> |
	<?php echo Html::anchor('date', 'Back'); ?></p>
