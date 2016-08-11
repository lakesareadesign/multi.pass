<section class="dev-box wd-blacklist-widget" id="wd-blacklist-widget">
	<div class="box-title">
		<h3><?php _e( "Blacklist", wp_defender()->domain ) ?>
		</h3>
	</div>
	<div class="box-content">
		<div class="tc">
			<img width="200" class="wd-bottom-30" src="<?php echo wp_defender()->get_plugin_url() . 'assets/img/evil-man.png' ?>"/>
			<br/>

			<div class="wd-error wd-hide">

			</div>
			<p>
				<?php _e( "Defender can check Google’s blacklist to see if your site is malware free. All you have to do is turn this on and we’ll scan your site every 6 hours automagically.", wp_defender()->domain ) ?>
			</p>
			<br/>
			<form method="post" id="activate_blacklist_frm">
				<input type="hidden" name="action" value="wd_toggle_blacklist">
				<?php wp_nonce_field( 'wd_toggle_blacklist', 'wd_service_nonce' ) ?>
				<button type="submit" class="button wd-button button-cta">
					<?php _e( "Activate Blacklist Monitoring", wp_defender()->domain ) ?>
				</button>
			</form>
		</div>
	</div>
</section>