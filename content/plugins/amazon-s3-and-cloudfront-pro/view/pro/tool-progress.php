<div class="progress-content modal-content">
	<span class="close-progress-content close-progress-content-button">&times;</span>

	<div class="progress-header">
		<h2 class="progress-title"><?php _e( 'Uploading Media Library to S3', 'amazon-s3-and-cloudfront' ); ?></h2>
		<span class="timer">00:00:00</span>
	</div>

	<div class="progress-info-wrapper clearfix">
		<div class="progress-text"><?php _e( 'Initiating', 'amazon-s3-and-cloudfront' ); ?>&hellip;</div>
		<div class="upload-progress">0 <?php _e( 'Files Processed', 'amazon-s3-and-cloudfront' ); ?></div>
	</div>
	<div class="clearfix"></div>
	<div class="progress-bar-wrapper">
		<div class="progress-bar"></div>
	</div>

	<div class="upload-controls">
		<span class="pause-resume button"><?php _ex( 'Pause', 'Temporarily stop process', 'amazon-s3-and-cloudfront' ); ?></span>
		<span class="cancel button"><?php _ex( 'Cancel', 'Stop the process', 'amazon-s3-and-cloudfront' ); ?></span>
	</div>
	<div class="progress-errors">
		<div class="progress-errors-title">
			<span class="error-count">0</span>
			<span class="error-text"><?php _ex( 'Errors', 'Process errors', 'amazon-s3-and-cloudfront' ); ?></span>

			<a class="toggle-progress-errors" href="#"><?php _ex( 'Show', 'Show process errors', 'amazon-s3-and-cloudfront' ); ?></a>
		</div>
		<div class="progress-errors-detail">
			<ol></ol>
		</div>
	</div>
</div>