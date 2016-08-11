<section class="dev-box">
	<div class="box-title">
		<h3><?php _e( "Audit Logging", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content tc">
		<form method="post" class="wd_audit_status_toggle">
			<img width="200px"
			     src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-man-log.png"/>

			<h2><?php _e( "Audit Logging", wp_defender()->domain ) ?></h2>

			<p>
				<?php
				_e( "Defender will track and log events when changes are made your website. It’ll give you full visibility of what’s going on behind the scenes including being able to see if hackers or bots enter your site.", wp_defender()->domain )
				?>
			</p>
			<button type="submit" class="button wd-button button-cta">
				<?php wp_nonce_field( 'wd_toggle_audit_log', 'wd_audit_nonce' ) ?>
				<input type="hidden" name="action" value="wd_toggle_audit_log">
				<?php _e( "Enable Audit Logging", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</section>