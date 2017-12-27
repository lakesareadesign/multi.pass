<?php
	$wds_options = WDS_Settings::get_options();
?>
<div id="container" class="wrap wrap-wds wds-page wds-page-dashboard">
<!--
	<div class="wds-notice wds-notice-success">
		<p><?php esc_html_e( 'Settings Updated', 'wds' ); ?></p>
	</div>

	<div class="wds-notice wds-notice-error can-close">
		<span class="close"></span>
		<p><?php esc_html_e( 'Settings Updated', 'wds' ); ?></p>
	</div>

	<div class="wds-notice wds-notice-warning">
		<p><?php esc_html_e( 'Settings Updated', 'wds' ); ?></p>
	</div>

	<div class="wds-notice wds-notice-success wds-notice-box">
		<p><?php esc_html_e( 'Settings Updated', 'wds' ); ?></p>
	</div>

	<div class="wds-notice wds-notice-error wds-notice-box can-close">
		<span class="close"></span>
		<p><?php esc_html_e( 'Settings Updated', 'wds' ); ?></p>
	</div>
-->
	<section id="page-header">
		<h1 class="wds-title-alt"><?php esc_html_e( 'Welcome to SmartCrawl' , 'wds' ); ?></h1>
		<p class="wds-page-desc">
			<?php esc_html_e('Ahoy Cap\'n! Welcome to SmartCrawl. This plugin will help you improve the SEO of your website and get better', 'wds'); ?>
			<br>
			<?php esc_html_e('Search Results Rankings across various search engines.', 'wds'); ?>
		</p>
	</section><!-- end page-header -->

	<?php
		$dashboardLoginLink = admin_url( 'admin.php?page=wpmudev' );
		$dashboardDownloadLink = 'https://premium.wpmudev.org/api/dashboard/v1/download-dashboard';
		$dashboardHubLink = 'https://premium.wpmudev.org/membership/#profile-menu-tabs';
	?>

	<div class="row">

		<div class="col-half col-half-dashboard col-half-dashboard-left">





		<?php
			/**
			 * Pre-built Uptime service dashboard box
			 */
			if (!empty($uptime_message_box)) echo $uptime_message_box;
		?>


		<?php
			/**
			 * Pre-built SEO service dashboard box
			 */
			if (!empty($seo_message_box)) echo $seo_message_box;
		?>

		<?php if (!empty($wds_options['sitemap']) && !empty($wds_options['wds_sitemap-setup'])) { ?>
			<section class="box-dashboard-sitemap-settings dev-box">
				<div class="box-title">
					<div class="buttons buttons-icon">
						<a href="<?php echo $current_admin_url; ?>?page=wds_sitemap" class="edit"><span class="dashicons dashicons-admin-generic wds-dashicons wds-dashicons-link"></span></a>
					</div>
					<h3><span class="dashicons dashicons-networking wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'Sitemaps', 'wds' ); ?></h3>
				</div>
				<div class="box-content">
				<?php if (!empty($wds_options['sitemappath'])) { ?>
					<p><?php esc_html_e( 'Path to the XML Sitemap', 'wds' ); ?></p>
					<div class="wds-block-content wds-block-content-grey">
						<pre><?php echo esc_html($wds_options['sitemappath']); ?></pre>
					</div>
				<?php } ?>
				<?php if (function_exists('wds_get_sitemap_url')) { ?>
					<p><?php esc_html_e( 'URL to the XML Sitemap', 'wds' ); ?>: <a target="_blank" href="<?php echo wds_get_sitemap_url(); ?>"><?php echo wds_get_sitemap_url(); ?></a></p>
				<?php } ?>
				</div>
			</section><!-- end box-dashboard-sitemap-settings -->
		<?php } ?>

		</div><!-- end col-half-dashboard-left -->

		<div class="col-half col-half-dashboard col-half-dashboard-right">

	<?php if (!empty($wds_options['onpage']) && (is_network_admin() || WDS_Settings_Admin::is_tab_allowed(WDS_Settings::TAB_ONPAGE))) { ?>
		<?php if (empty($wds_options['wds_onpage-setup'])) { ?>

			<section class="box-dashboard-improve-seo dev-box">
				<div class="box-title">
					<h3><span class="dashicons dashicons-admin-settings wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'Manually improve SEO', 'wds' ); ?></h3>
				</div>
				<div class="box-content">
					<p>
						<?php esc_html_e('Manually improve your site\'s SEO by configuring various settings.', 'wds'); ?>
						<br />
						<?php esc_html_e('We recommend by starting with Title & Meta as it is generally considered the most valuable area and most likely to be indexed.', 'wds'); ?></p>
				</div>
				<div class="box-footer buttons">
					<a href="<?php echo esc_url(Wds_Settings_Admin::admin_url(Wds_Settings::TAB_ONPAGE)); ?>" class="button button-cta-dark button-configure-seo"><?php esc_html_e( 'Configure SEO', 'wds' ); ?></a>
				</div>
			</section><!-- end box-dashboard-performance-info -->

		<?php } else { ?>

			<section class="box-dashboard-titles-and-meta dev-box">
				<div class="box-title">
					<div class="buttons buttons-icon">
						<a href="<?php echo esc_url(Wds_Settings_Admin::admin_url(Wds_Settings::TAB_ONPAGE)); ?>" class="edit"><span class="dashicons dashicons-admin-generic wds-dashicons wds-dashicons-link"></span></a>
					</div>
					<h3><span class="dashicons dashicons-edit wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'Titles & Meta', 'wds' ); ?></h3>
				</div>
				<div class="box-content">
					<div class="wds-links-list-group">
						<ul class="wds-links-list">
							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo $current_admin_url; ?>?page=wds_onpage#tab_homepage">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Homepage', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li><!-- end wds-links-list-item -->

					<?php
						foreach( get_post_types(array('public' => true)) as $posttype ) {
							if ( in_array( $posttype, array( 'revision', 'nav_menu_item' ) ) ) continue;

							$type_obj = get_post_type_object( $posttype );
							if ( ! is_object( $type_obj ) ) continue;

							?>

								<li class="wds-links-list-item">
									<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_<?php echo esc_attr($posttype); ?>">
										<span class="wds-links-list-item-label"><?php echo esc_html($type_obj->labels->name); ?></span>
										<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
									</a>
								</li><!-- end wds-links-list-item -->

							<?php
						}
					?>
							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_post-categories">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Post Categories', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

						</ul><!-- end wds-links-list -->

						<ul class="wds-links-list">
						<?php
							foreach( get_taxonomies( array( '_builtin' => false ), 'objects' ) as $taxonomy ) {
								?>

									<li class="wds-links-list-item">
										<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_<<?php echo esc_attr($taxonomy->name); ?>">
											<span class="wds-links-list-item-label"><?php echo esc_html(ucfirst( $taxonomy->label )); ?></span>
											<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
										</a>
									</li><!-- end wds-links-list-item -->

								<?php
							}
						?>

							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_post-tags">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Post Tags', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_author-archive">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Author Archive', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_date-archive">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Date Archive', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_search-page">
									<span class="wds-links-list-item-label"><?php esc_html_e( 'Search Page', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

							<li class="wds-links-list-item">
								<a class="wds-links-list-item-link" href="<?php echo esc_attr($current_admin_url); ?>?page=wds_onpage#tab_404-page">
									<span class="wds-links-list-item-label"><?php esc_html_e( '404 Page', 'wds' ) ?></span>
									<span class="wds-links-list-item-edit"><?php esc_html_e( 'Edit', 'wds' ) ?></span>
								</a>
							</li>

						</ul><!-- end wds-links-list -->

					</div>
				</div>
			</section><!-- end box-dashboard-titles-and-meta -->

		<?php } ?>

	<?php } // end if tab is allowed ?>

		<?php if( ! empty( $wds_options['access-id'] ) && ! empty( $wds_options['secret-key'] ) ) { ?>
			<section class="box-dashboard-seo-moz-stats dev-box">
				<div class="box-title">
					<div class="buttons buttons-icon">
						<a href="<?php echo esc_attr($current_admin_url); ?>?page=wds_settings" class="edit"><span class="dashicons dashicons-admin-generic wds-dashicons wds-dashicons-link"></span></a>
					</div>
					<h3><span class="dashicons dashicons-chart-area wds-dashicons wds-dashicons-box-title"></span><?php esc_html_e( 'SEO Moz Stats', 'wds' ); ?></h3>
				</div>
				<div class="box-content"><?php WDS_Seomoz_Dashboard_Widget::widget(); ?></div>
			</section><!-- end box-dashboard-seo-moz-stats -->

		<?php } ?>

		</div>

	</div>

</div><!-- end container -->

<?php do_action('wds-dshboard-after_settings'); ?>