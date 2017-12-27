<?php
	$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
?>
<div id="container" class="wrap wrap-wds wds-page wds-checkup-settings <?php echo $service->is_member() ? 'wds-is-member' : 'wds-is-not-member'; ?>">

	<section id="header">
		<?php $this->_render('settings-message-top'); ?>
		<div class="actions">
			<?php
				printf(
					__('Last checked: %s', 'wds'),
					$service->get_last_checked(get_option('date_format') . ' ' . get_option('time_format'))
				);
			?>
			<a href="<?php echo esc_url(add_query_arg('run-checkup', 'yes')); ?>" class="button button-small">
				<?php esc_html_e('Run checkup', 'wds'); ?>
			</a>
		</div>
		<h1><?php esc_html_e( 'SEO Checkup' , 'wds' ); ?></h1>
	</section><!-- end header -->

	<div class="wds-seo-checkup-stats-container">
		<?php $this->_render('checkup/checkup-top'); ?>
	</div>

<?php
	$wds_options = WDS_Settings::get_options();
	if ( ! wds_is_allowed_tab( $_view['slug'] ) ) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'SEO Checkup' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {

?>
	<form action='<?php echo esc_attr($_view['action_url']); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1">

		<div class="vertical-tabs" id="checkup-settings-tabs">
			<?php
				$this->_render('report-vertical-tab', array(
					'tab_id'       => 'tab_checkup',
					'tab_name'     => __('Checkup', 'wds'),
					'is_active'    => $active_tab == 'tab_checkup',
					'tab_sections' => array(
						array(
							'section_template' => 'checkup/checkup-checkup',
						)
					)
				));
			?>
			<?php
				$is_member = $service->is_member();
				$this->_render(
					$is_member ? 'vertical-tab' : 'report-vertical-tab',
					array(
						'tab_id'       => 'tab_settings',
						'tab_name'     => __('Reporting', 'wds'),
						'is_active'    => $active_tab == 'tab_settings',
						'title_button' => 'upgrade',
						'tab_sections' => array(
							array(
								'section_description' => esc_html__('Set up SmartCrawl to automatically run a comprehensive checkup daily, weekly or monthly and receive an email report.', 'wds'),
								'section_template'    => 'checkup/checkup-reporting',
							)
						)
					)
				);
			?>

		</div>
	</form>

<?php
	} else {
		$this->_render('disabled-component', array(
			'content'     => sprintf(
				'%s<br/>%s',
				__("Automatically generate a full sitemap, regularly send updates to search engines and set up", 'wds'),
				__("SmartCrawl to automatically check URLs are discoverable by search engines.", 'wds')
			),
			'image'       => 'sitemap-disabled.png',
			'component'   => 'sitemap',
			'button_text' => __('Activate Sitemap', 'wds')
		));
	}
?>
	<?php $this->_render('upsell-modal'); ?>
</div>
