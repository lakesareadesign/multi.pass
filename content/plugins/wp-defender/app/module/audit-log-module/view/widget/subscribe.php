<section class="dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( "Audit Logging", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<div class="tc">
			<img width="200px"
			     src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-man-log.png"/>

			<h2><?php esc_html_e( "Audit Logging", wp_defender()->domain ) ?></h2>

			<p>
				<?php
				esc_html_e( "Defender will track and log events when changes are made your website. It’ll give you full visibility of what’s going on behind the scenes including being able to see if hackers or bots enter your site.", wp_defender()->domain )
				?>
			</p>
			<a href="https://premium.wpmudev.org/"
			   class="button wd-button button-cta"><?php esc_html_e( "Upgrade Membership", wp_defender()->domain ) ?></a>

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