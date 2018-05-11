<?php if (count($count_number) > 0): ?>
	<div class="error">
		<?php foreach ($count_number as $cnt):?>
			<p><?php echo $cnt;?> students meet criterions.</p>
		<?php endforeach?>
	</div>
<?php endif?>
<?php if (count($broadcast_state) > 0): ?>
	<div class="error">
		<?php foreach ($broadcast_state as $b):?>
			<p><?php echo $b;?></p>
		<?php endforeach?>
	</div>
<?php endif?>
