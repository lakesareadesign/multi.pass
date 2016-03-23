<section class="dev-box">
	<div class="box-title">
		<h3><?php _e( "Scan", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content tc">
		<img width="200" src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-man-scan.png"/>

		<p>
			<?php _e( "Defender will check your websites’ core integrity in addition to looking for vulnerabilities in your plugins, themes and wp-content area. He’ll then give you ways to fix any issues with your website! This is a premium only feature – enjoy it!", wp_defender()->domain ) ?>
		</p>

		<form id="start_a_scan" method="post">
			<input type="hidden" name="action" value="wd_start_a_scan">
			<?php wp_nonce_field( 'wd_start_a_scan', 'wd_scan_nonce' ) ?>
			<button type="submit" class="button button-cta wd-button">
				<?php _e( "Scan My Website", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</section>