<div class="wd-scan">
	<section class="dev-box scanning">
		<div class="box-title">
			<h3><?php esc_html_e( "Scan", wp_defender()->domain ) ?></h3>
		</div>
		<div class="box-content tc">
			<p><?php esc_html_e( "This scan is running in the background and you can check back any time to see its progress.", wp_defender()->domain ) ?></p>

			<div
				class="wd-progress <?php echo $model->status !== WD_Scan_Result_Model::STATUS_PAUSE ? 'animate' : null ?>">
					<span
						style="width: <?php echo (int) $model->get_percent() ?>%"><?php echo (int) $model->get_percent(); ?>
						%</span>
			</div>
			<?php if ( $model->status != WD_Scan_Result_Model::STATUS_ERROR ): ?>
				<span class="current_working"><?php echo $model->message ?></span>
				<form method="post" id="secret_key_scanning">
					<input type="hidden" name="action" value="wd_query_scan_progress">
					<?php wp_nonce_field( 'query_scan_progress', 'wd_scan_nonce' ) ?>
				</form>
			<?php endif; ?>
		</div>
	</section>
</div>