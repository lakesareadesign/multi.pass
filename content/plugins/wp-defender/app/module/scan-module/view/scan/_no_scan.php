<section class="dev-box scan-reports">
	<div class="box-title">
		<h3><?php esc_html_e( "Scan Reports", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<div class="no-scan tc">
			<img src="<?php echo wp_defender()->get_plugin_url() . 'assets/img/dev-man-scan.png' ?>"/>

			<p>
				<?php esc_html_e( "Defender will check your websites’ core integrity in addition to looking for vulnerabilities in your plugins, themes and wp-content area. He’ll then give you ways to fix any issues with your website! This is a premium only feature – enjoy it!", wp_defender()->domain ) ?>
			</p>

			<form id="start_a_scan" method="post">
				<input type="hidden" name="action" value="wd_start_a_scan">
				<?php wp_nonce_field( 'wd_start_a_scan', 'wd_scan_nonce' ) ?>
				<button type="submit" class="button wd-button button-cta">
					<?php esc_html_e( "SCAN MY WEBSITE", wp_defender()->domain ) ?>
				</button>
			</form>
		</div>
	</div>
</section>