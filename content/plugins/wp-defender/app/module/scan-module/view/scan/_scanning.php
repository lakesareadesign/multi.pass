<section class="dev-box scan-reports">
	<div class="box-title">
		<h3><?php _e( "Scan Reports", wp_defender()->domain ) ?>
			<a class="button button-light button-small wd-scan-toggle-log"
			   href="#"><?php _e( "Show Log", wp_defender()->domain ) ?></a>
		</h3>
	</div>
	<?php if ( $model->status == WD_Scan_Result_Model::STATUS_ERROR ): ?>
		<div class="wd-error">
			<?php echo $model->message ?>
		</div>
	<?php endif; ?>
	<div class="box-content">
		<div class="scanning">
			<div class="wd-well">
				<h3><?php _e( "Running New Scan", wp_defender()->domain ) ?></h3>

				<p class="tc"><?php _e( "This scan is running in the background and will continue to run if you navigate away or close your browser. Check back in a few minutes to see your results.", wp_defender()->domain ) ?></p>
				<br/>

				<div
					class="wd-progress <?php echo $model->status !== WD_Scan_Result_Model::STATUS_PAUSE ? 'animate' : null ?>">
					<span
						style="width: <?php echo (int) $model->get_percent() ?>%">
						<?php echo (int) $model->get_percent() ?>
						%</span>
				</div>
				<?php if ( $model->status != WD_Scan_Result_Model::STATUS_ERROR ): ?>
					<span class="current_working"><?php echo $model->message ?></span>
					<div class="wd-clearfix"></div>
					<form class="block tc" id="wd_cancel_scan" method="post">
						<button type="submit" class="button button-grey button-small">
							<input type="hidden" name="action" value="wd_cancel_scan">
							<?php wp_nonce_field( 'wd_cancel_scan', 'wd_scan_nonce' ) ?>
							<?php _e( "Cancel Scan", wp_defender()->domain ) ?>
						</button>
					</form>
					<form method="post" id="secret_key_scanning">
						<input type="hidden" name="action" value="wd_query_scan_progress">
						<?php wp_nonce_field( 'query_scan_progress', 'wd_scan_nonce' ) ?>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<section class="dev-box wd-hide">
	<div class="box-title">
		<h3><?php _e( "File scanned", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<div class="wd-scan-log">

		</div>
	</div>
</section>