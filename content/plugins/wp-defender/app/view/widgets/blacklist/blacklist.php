<section id="wd-blacklist-widget" class="dev-box wd-blacklist-widget">
	<div class="box-title">
		<h3><?php _e( "Blacklist Monitoring", wp_defender()->domain ) ?> &nbsp;
			<?php if ( $is_ok ): ?>
				<span class="wd-badge wd-badge-green">
						<?php _e( "Domain Clean", wp_defender()->domain ) ?>
					</span>
			<?php else: ?>
				<span class="wd-badge wd-badge-red">
						<?php _e( "Blacklisted", wp_defender()->domain ) ?>
					</span>
			<?php endif; ?>
			<span tooltip="<?php esc_attr_e( __( "Deactivate Blacklist Monitoring", wp_defender()->domain ) ) ?>" class="toggle float-r">
									<input type="checkbox" class="toggle-checkbox"
									       id="toggle_blacklist" <?php checked( true, $controller->get_status() != WD_Blacklist_Widget::STATUS_OFF ) ?>/>
									<label class="toggle-label" for="toggle_blacklist"></label>
								</span>

			<form method="post" id="toggle_blacklist_frm">
				<input type="hidden" name="action" value="wd_toggle_blacklist">
				<?php wp_nonce_field( 'wd_toggle_blacklist', 'wd_service_nonce' ) ?>
			</form>
		</h3>
	</div>
	<div class="box-content">
		<p class="wd-center">
			<?php _e( "We are monitoring blacklists for your domain every 6 hours.", wp_defender()->domain ); ?>
			<a href="https://premium.wpmudev.org/blog/get-off-googles-blacklist/"><?php _e( "Learn more about blacklisting", wp_defender()->domain ); ?>.</a>
		</p>
		<br/>
		<?php
		if ( $is_ok ) {
			?>
			<div class="wd-success wd-padding-heavy tl">
				<i class="dev-icon dev-icon-radio_checked"></i>
				<?php _e( "Your domain is currently clean.", wp_defender()->domain ) ?>
			</div>
			<?php
		} else {
			?>
			<div class="wd-error">
				<?php _e( "Your website has been blacklisted. Please refer to the article above for how to get off the blacklist.", wp_defender()->domain ) ?>
			</div>
			<?php
		}
		?>
	</div>
	<?php if ( $controller->is_on_hold() ): ?>
		<div class="wd-overlay" id="wd-blacklist-overlay">
			<i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i>
		</div>
	<?php endif; ?>
</section>