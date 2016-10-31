<section class="dev-box wd-blacklist-widget" id="wd-blacklist-widget">
	<div class="box-title">
		<h3><?php esc_html_e( "Blacklist", wp_defender()->domain ) ?>
		</h3>
	</div>
	<div class="box-content">
		<div class="tc">
			<img width="200" class="wd-bottom-30" src="<?php echo wp_defender()->get_plugin_url() . 'assets/img/evil-man.png' ?>"/>
			<br/>

			<div class="wd-error">
				<?php echo $controller->error; ?>
			</div>
			<br/>
			<?php if ( $controller->is_local() ): ?>
				<div class="wd-error">
					<?php
					esc_html_e( "We could’nt get a result from Google. This may be because your website is on a local environment. Blacklist can only work on live websites. If problems still persist please contact our support heroes.", wp_defender()->domain )
					?>
				</div>
			<?php else: ?>
				<form method="post" id="activate_blacklist_frm">
					<input type="hidden" name="action" value="wd_toggle_blacklist">
					<?php wp_nonce_field( 'wd_toggle_blacklist', 'wd_service_nonce' ) ?>
					<button type="submit" class="button wd-button button-cta">
						<?php esc_html_e( "Re-check", wp_defender()->domain ) ?>
					</button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>