<?php
	$page_url = Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_AUTOLINKS );

	$redirection_model = new Smartcrawl_Model_Redirection;
	$redirection_count = count( $redirection_model->get_all_redirections() );

	$option_name = Smartcrawl_Settings::TAB_SETTINGS . '_options';
	$options = $_view['options'];
	$autolinking_enabled = smartcrawl_get_array_value( $options, 'autolinks' );
	$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
	$is_member = $service->is_member();
	$moz_connected = ! empty( $options['access-id'] ) && ! empty( $options['secret-key'] );
?>

<section id="<?php echo Smartcrawl_Settings_Dashboard::BOX_ADVANCED_TOOLS; ?>" class="dev-box">
	<div class="box-title">
		<div class="buttons buttons-icon">
			<a href="<?php echo esc_attr( $page_url ); ?>" class="wds-settings-link">
				<i class="wds-icon-arrow-right-carats"></i>
			</a>
		</div>
		<h3>
			<i class="wds-icon-wand-magic"></i> <?php esc_html_e( 'Advanced Tools', 'wds' ); ?>
		</h3>
	</div>

	<div class="box-content">
		<p><?php esc_html_e( 'Advanced tools focus on the finer details of SEO including internal linking, redirections and Moz analysis.', 'wds' ); ?></p>

		<div class="wds-separator-top">
			<span class="wds-small-text"><strong><?php esc_html_e( 'URL Redirects', 'wds' ); ?></strong></span>
			<span class="wds-box-stat-value"><?php echo esc_html( $redirection_count ); ?>
		</div>

		<div class="wds-separator-top cf">
			<span class="wds-small-text"><strong><?php esc_html_e( 'Moz Integration', 'wds' ); ?></strong></span>

			<?php if ( $moz_connected ) :  ?>
				<span class="wds-box-stat-value">
					<a href="<?php echo esc_attr( $page_url ); ?>#tab_moz"
					   class="button button-small button-dark button-dark-o">

						<?php esc_html_e( 'View Report', 'wds' ); ?>
					</a>
				</span>
			<?php else : ?>
				<p class="wds-small-text">
					<?php esc_html_e( 'Moz provides reports that tell you how your site stacks up against the competition with all of the important SEO measurement tools.', 'wds' ); ?>
				</p>
				<a href="<?php echo esc_attr( $page_url ); ?>#tab_moz"
				   class="button button-small">

					<?php esc_html_e( 'Connect', 'wds' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="wds-separator-top wds-autolinking-section <?php echo ! $is_member ? 'wds-box-blocked-area' : ''; ?>">
			<span class="wds-small-text"><strong><?php esc_html_e( 'Automatic Linking', 'wds' ); ?></strong></span>
			<?php if ( $autolinking_enabled && $is_member ) :  ?>
				<span class="wds-box-stat-value wds-box-stat-value-success"><?php esc_html_e( 'Active', 'wds' ); ?></span>
			<?php else : ?>
				<p class="wds-small-text">
					<?php esc_html_e( 'Moz provides reports that tell you how your site stacks up against the competition with all of the important SEO measurement tools.', 'wds' ); ?>
				</p>
				<button type="button"
						data-option-id="<?php echo esc_attr( $option_name ); ?>"
						data-flag="<?php echo 'autolinks'; ?>"
						class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

					<?php esc_html_e( 'Activate', 'wds' ); ?>
				</button>
				<?php if ( ! $is_member ) :  ?>
					<button class="wds-upgrade-button button-pro wds-has-tooltip"
							data-content="<?php _e( 'Get SmartCrawl Pro today Free', 'wds' ); ?>"
							type="button">
						<?php esc_html_e( 'Pro feature', 'wds' ); ?>
					</button>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="wds-box-footer" style="margin-top: 0;">
			<a href="<?php echo esc_attr( $page_url ); ?>"
			   class="button button-small button-dark button-dark-o wds-dash-configure-button">

				<?php esc_html_e( 'Configure', 'wds' ); ?>
			</a>

			<?php
			if ( ! $is_member ) {

				$this->_render('mascot-message', array(
					'key'         => 'seo-checkup-upsell',
					'dismissible' => false,
					'message'     => sprintf(
						'%s <a href="#upgrade-to-pro">%s</a>',
						esc_html__( 'Upgrade to Pro and automatically link your articles both internally and externally with automatic linking - a favourite among SEO pros.', 'wds' ),
						esc_html__( '- Try SmartCrawl Pro FREE today!', 'wds' )
					),
				));
			}
			?>
		</div>
	</div>
</section>