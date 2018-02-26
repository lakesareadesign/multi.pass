<?php
	$page_url = Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_SITEMAP );
	$options = $_view['options'];
	$sitemap_enabled = smartcrawl_get_array_value( $options, 'sitemap' );
	$option_name = Smartcrawl_Settings::TAB_SETTINGS . '_options';
	$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
	$is_member = $service->is_member();
?>
<section id="<?php echo Smartcrawl_Settings_Dashboard::BOX_SITEMAP; ?>"
		 class="dev-box"
		 data-dependent="<?php echo Smartcrawl_Settings_Dashboard::BOX_TOP_STATS; ?>">

	<div class="box-title">
		<div class="buttons buttons-icon">
			<a href="<?php echo esc_attr( $page_url ); ?>">
				<i class="wds-icon-arrow-right-carats"></i>
			</a>
		</div>
		<h3>
			<i class="wds-icon-web-globe-world"></i> <?php esc_html_e( 'Sitemap', 'wds' ); ?>
			<?php
				$this->_render('url-crawl-master', array(
					'ready_template' => 'dashboard/dashboard-box-title-url-crawl-stats',
				));
			?>
		</h3>
	</div>
	<div class="box-content">
		<p><?php esc_html_e( 'Automatically generate detailed sitemaps to tell search engines what content you want them to crawl and index.', 'wds' ); ?></p>

		<div class="wds-separator-top">
			<span class="wds-small-text"><strong><?php esc_html_e( 'XML Sitemap', 'wds' ); ?></strong></span>
			<?php if ( $sitemap_enabled ) :  ?>

				<?php
				$this->_render('notice', array(
					'class'   => 'wds-notice-success',
					'message' => sprintf(
						__( 'Your sitemap is available at %s', 'wds' ),
						sprintf( '<a href="%s">/sitemap.xml</a>', esc_attr( smartcrawl_get_sitemap_url() ) )
					),
				));
				?>

			<?php else : ?>
				<p class="wds-small-text">
					<?php esc_html_e( 'Enables an XML page that search engines will use to crawl and index your website pages.', 'wds' ); ?>
				</p>

				<?php
				$this->_render('dismissable-notice', array(
					'key'     => 'dashboard-sitemap-disabled-warning',
					'message' => __( 'Your sitemap is currently disabled. We highly recommend you enable this feature if you don’t already have a sitemap.', 'wds' ),
					'class'   => 'wds-notice-warning',
				));
				?>
				<button type="button"
						data-option-id="<?php echo esc_attr( $option_name ); ?>"
						data-flag="<?php echo 'sitemap'; ?>"
						class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

					<?php esc_html_e( 'Activate', 'wds' ); ?>
				</button>
			<?php endif; ?>
		</div>

		<div class="wds-separator-top <?php echo $is_member ? '' : 'wds-box-blocked-area'; ?>">
			<span class="wds-small-text"><strong><?php esc_html_e( 'URL Crawler', 'wds' ); ?></strong></span>
			<?php if ( $sitemap_enabled ) :  ?>
				<?php
					$this->_render('url-crawl-master', array(
						'ready_template'    => 'dashboard/dashboard-url-crawl-stats',
						'progress_template' => 'dashboard/dashboard-url-crawl-in-progress',
						'no_data_template'  => 'dashboard/dashboard-url-crawl-no-data-small',
					));
				?>
			<?php else : ?>
				<?php if ( $is_member ) :  ?>
					<div class="wds-box-crawl-stats">
						<span class="wds-issues wds-issues-invalid">
							<?php esc_html_e( 'Sitemaps must be activated', 'wds' ) ?>
						</span>
					</div>
				<?php else : ?>
					<p class="wds-small-text">
						<?php esc_html_e( 'Automatically schedule SmartCrawl to run check for URLs that are missing from your Sitemap.', 'wds' ) ?>
					</p>
					<button class="wds-upgrade-button button-pro wds-has-tooltip"
							data-content="<?php _e( 'Get SmartCrawl Pro today Free', 'wds' ); ?>"
							type="button">
			            <?php esc_html_e( 'Pro feature', 'wds' ); ?>
					</button>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="wds-box-footer" style="<?php echo $is_member ? '' : 'margin-top:0;'; ?>">
			<a href="<?php echo esc_attr( $page_url ); ?>"
			   class="button button-small button-dark button-dark-o wds-dash-configure-button">

				<?php esc_html_e( 'Configure', 'wds' ); ?>
			</a>
		</div>
	</div>
</section>