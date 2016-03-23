<div class="wrap">
	<div class="wp-defender">
		<div class="wd-scan">
			<div class="scan-error">
				<div class="update-notice err">
					<i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i>
					<a href="#" class="wd-dismiss">
						<i class="dev-icon dev-icon-cross"></i>
					</a>

					<p>
						<?php echo $model->message ?></p>
					<p>

					<form method="post">
						<?php wp_nonce_field( 'wd_retry_scan', 'wd_scan_nonce' ) ?>
						<button type="submit" class="button button-secondary">
							<?php _e( "Try again", wp_defender()->domain ) ?>
						</button>
					</form>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>