<?php
	// We don't have Dashboard installed
	$dashboardLoginLink = admin_url( 'admin.php?page=wpmudev' );
	$dashboardDownloadLink = 'https://premium.wpmudev.org/api/dashboard/v1/download-dashboard';
	$dashboardHubLink = 'https://premium.wpmudev.org/membership/#profile-menu-tabs';
?>
<section class="box-dashboard-install-dashboard-plugin dev-box">
	<div class="box-title">
		<h3><?php esc_html_e( 'Install WPMU DEV Dashboard', 'wds' ); ?></h3>
	</div>
	<div class="box-content">
		<p>
			<?php echo sprintf(
				esc_html("%s, WPMU DEV Dashboard Plugin is required in order to make advantage of SEO Analysus & Reporting. Once you Install, Activate & Login, you will be able to preform SEO Analysis sancs of your entire website, receive tips about improving your SEO Rankings.", 'wds'),
				WDS_Model_User::current()->get_first_name()
			); ?>
		</p>
	</div>
	<div class="box-footer buttons">
		<a href="<?php echo $dashboardDownloadLink; ?>" class="button block button-cta-alt large"><?php esc_html_e('Download WPMU DEV Dashboard', 'wds'); ?></a>
	</div>
</section><!-- end box-dashboard-install-dashboard-plugin -->