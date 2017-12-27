<?php

	$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
	$percentage = $service->status();
	$progress = (int)$percentage;

	if ($progress > 100) $progress = 100;

	$this->_render('progress-bar', array(
		'progress' => $progress
	));
?>

<div class="wds-checkup-progress-notice">
	<?php $this->_render('progress-notice'); ?>
</div>