<section class="dev-box">
	<div class="box-title">
		<h3><?php _e( "Scan", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<div class="tc">
			<img width="200" class="wd-bottom-15"
			     src="<?php echo wp_defender()->get_plugin_url() . 'assets/img/dev-man-scan.png' ?>"/>
			<br/>

			<p>
				<?php _e( "Defender can scan your WordPress core integrity looking for file changes and injected code. Often hackers and bots try to change WP Core without you noticing so it’s a good idea to check it!", wp_defender()->domain ) ?>
			</p>
			<br/>
			<a href="https://premium.wpmudev.org/"
			   class="button wd-button button-cta"><?php _e( "Upgrade Membership", wp_defender()->domain ) ?></a>

			<div class="wd-clearfix"></div>
			<br/>
			<?php
			if ( WD_Utils::is_wpmudev_dashboard_installed() ) {
				$link = sprintf( __( "Already have a membership? <a href=\"%s\">You might need to login</a>", wp_defender()->domain ), network_admin_url( 'admin.php?page=wpmudev' ) );
			} else {
				$link = sprintf( __( "Already have a membership? <a href=\"%s\">Install the Dashboard</a>", wp_defender()->domain ), 'https://premium.wpmudev.org/project/wpmu-dev-dashboard/' );
			}
			echo $link; ?>
		</div>
	</div>
</section>