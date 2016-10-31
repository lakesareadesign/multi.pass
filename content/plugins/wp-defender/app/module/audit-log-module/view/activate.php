<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<section id="header">
				<h1 class="tl"><?php esc_html_e( "Audit Logging", wp_defender()->domain ) ?></h1>
			</section>
			<section class="dev-box">
				<div class="box-title">
					<h3><?php esc_html_e( "Get Started", wp_defender()->domain ) ?></h3>
				</div>
				<div class="box-content tc">
					<form method="post" class="wd_audit_status_toggle">
						<img class="wd-bottom-15" width="200"
						     src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-soon.png"/>
						<div class="wd-error wd-hide">

						</div>
						<h2>
							<?php esc_html_e( "Fight crime quicker with audit logging", wp_defender()->domain ) ?>
						</h2>

						<p>
							<?php
							esc_html_e( "Defender will track and log events when changes are made your website. It’ll give you full visibility of what’s going on behind the scenes including being able to see if hackers or bots enter your site.", wp_defender()->domain )
							?>
						</p>
						<button type="submit" class="button wd-button button-cta">
							<?php wp_nonce_field( 'wd_toggle_audit_log', 'wd_audit_nonce' ) ?>
							<input type="hidden" name="action" value="wd_toggle_audit_log">
							<?php esc_html_e( "Enable Audit Logging", wp_defender()->domain ) ?>
						</button>
					</form>
				</div>
			</section>
		</div>
	</div>
</div>