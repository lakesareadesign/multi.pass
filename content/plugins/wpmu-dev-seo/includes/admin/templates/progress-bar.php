<?php
	$progress = empty($progress) ? 0 : $progress;
?>

<div class="wds-progress">
	<span class="wds-progress-bar-current-percent"><?php echo (int)$progress; ?>%</span>
	<div class="wds-progress-bar">
		<div class="wds-progress-bar-inside" style="width:<?php echo (int)$progress; ?>%;"></div>
	</div>
</div>