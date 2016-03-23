<section class="dev-box wd-blacklist-widget wd-relative-position" id="wd-blacklist-widget">
	<div class="box-title">
		<h3><?php _e( "Blacklist", wp_defender()->domain ) ?>
	</div>
	<div class="box-content">
		<div class="tc">
			<img width="200" src="<?php echo wp_defender()->get_plugin_url() . 'assets/img/evil-man.png' ?>"/>
			<br/>

			<div class="wd-error wd-hide">

			</div>
			<p>
				<?php _e( "Defender can check Google’s blacklist to see if your site is malware free. All you have to do is turn this on and we’ll scan your site every 6 hours automatically. This is a premium only feature – get a membership today and make sure you’re safe!", wp_defender()->domain ) ?>
			</p>
			<br/>
			<a class="button wd-button button-cta"
			   href="https://premium.wpmudev.org/"><?php _e( "Upgrade Membership", wp_defender()->domain ) ?></a>

			<div class="wd-clearfix"></div>
			<br/>

			<p>
				<?php
				if ( WD_Utils::is_wpmudev_dashboard_installed() ) {
					echo sprintf( __( "Already have a membership? <a href=\"%s\">You might need to login</a>", wp_defender()->domain ), network_site_url( 'admin.php?page=wpmudev' ) );
				} else {
					echo sprintf( __( "Already have a membership? <a href=\"%s\">Install the Dashboard</a>", wp_defender()->domain ), 'https://premium.wpmudev.org/project/wpmu-dev-dashboard/' );
				} ?>
			</p>
		</div>
	</div>
</section>