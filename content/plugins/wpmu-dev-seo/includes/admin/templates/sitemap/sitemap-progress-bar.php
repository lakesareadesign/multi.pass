<?php $progress = empty($progress) ? 0 : $progress; ?>

<div class="wds-crawl-results-report wds-report">
	<div class="wds-url-crawler-progress">
		<?php
			$this->_render('progress-bar', array(
				'progress' => $progress
			));
		?>
		<?php $this->_render('progress-notice'); ?>
	</div>
</div>