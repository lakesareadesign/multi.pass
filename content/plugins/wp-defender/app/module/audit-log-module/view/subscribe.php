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
			</section>
		</div>
	</div>
</div>