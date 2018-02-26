<?php
	// We have Dashboard installed, but the user didn't log in yet
	$dashboardLoginLink = admin_url( 'admin.php?page=wpmudev' );
	$dashboardDownloadLink = 'https://premium.wpmudev.org/api/dashboard/v1/download-dashboard';
	$dashboardHubLink = 'https://premium.wpmudev.org/membership/#profile-menu-tabs';
?>
<section class="box-dashboard-upgrade-membership dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Upgrade Membership', 'wds' ); ?></h3>
	</div>
	<div class="box-content">
		<p>
			<?php echo sprintf(
				esc_html( '%s SEO Analysis & Reporting is a feature available to people with active WPMU DEV memberships. Get access to all of our Premium Plugins and Themes as well as 24/7 Support today. It´s easy to join and only takes a few minutes!', 'wds' ),
				Smartcrawl_Model_User::current()->get_first_name()
			); ?>
		</p>
		<ul class="listing bold wds-listing">
			<li class="cta-alt"><?php _e( 'Access to 140+ plugins & Upfront themes', 'wds' ); ?></li>
			<li class="cta-alt"><?php _e( 'Access to security, backups, SEO and performance services', 'wds' ); ?></li>
			<li class="cta-alt"><?php _e( '24/7 expert WordPress support', 'wds' ); ?></li>
		</ul>
	</div>
	<div class="box-footer buttons">
		<a href="<?php echo $dashboardHubLink; ?>" class="button block button-cta-alt large"><?php esc_html_e( 'Upgrade Membership', 'wds' ); ?></a>
		<p class="wds-footer-text"><?php echo sprintf( __( 'Already a member? You need to <a href="%1$s">download</a> the WPMU DEV Plugin & <a href="%1$s">login</a>!', 'wds' ), $dashboardDownloadLink, $dashboardLoginLink ); ?></p>
	</div>
</section><!-- end box-dashboard-upgrade-membership -->