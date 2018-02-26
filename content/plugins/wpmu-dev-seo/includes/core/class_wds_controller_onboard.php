<?php

class Smartcrawl_Controller_Onboard extends Smartcrawl_Renderable {

	private static $_instance;

	private $_is_running = false;

	public function _get_view_defaults() {}

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function serve() {
		$me = self::get();
		if ( $me->is_running() ) { return false; }

		return $me->_add_hooks();
	}

	public static function stop() {
		$me = self::get();
		if ( ! $me->is_running() ) { return false; }

		return $me->_remove_hooks();
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return Smartcrawl_Controller_IO instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) { self::$_instance = new self; }
		return self::$_instance;
	}

	/**
	 * Bind listening actions
	 *
	 * @return bool
	 */
	private function _add_hooks() {
		add_action( 'admin_init', array( $this, 'dispatch_actions' ) );

		return ! ! $this->_is_running = true;
	}

	/**
	 * Unbinds listening actions
	 *
	 * @return bool
	 */
	private function _remove_hooks() {
		remove_action( 'admin_init', array( $this, 'dispatch_actions' ) );

		return ! $this->_is_running = false;
	}

	/**
	 * Check if we already have the actions bound
	 *
	 * @return bool Status
	 */
	public function is_running() {
		return $this->_is_running;
	}

	/**
	 * Dispatches action listeners for admin pages
	 *
	 * @return bool
	 */
	public function dispatch_actions() {
		add_action( 'wds-dshboard-after_settings', array( $this, 'add_onboarding' ) );

		add_action( 'wp_ajax_wds-boarding-toggle', array( $this, 'process_boarding_action' ) );
		add_action( 'wp_ajax_wds-boarding-skip', array( $this, 'process_boarding_skip' ) );
	}

	public function process_boarding_skip() {
		update_site_option( 'wds-onboarding-done', true );
		return wp_send_json_success();
	}

	public function process_boarding_action() {
		$data = stripslashes_deep( $_POST );
		$target = ! empty( $data['target'] ) ? sanitize_key( $data['target'] ) : false;

		if ( ! current_user_can( 'manage_options' ) ) { return wp_send_json_error(); }

		// Throw the switch on onboarding
		update_site_option( 'wds-onboarding-done', true );

		switch ( $target ) {
			case 'checkup-enable':
				$opts = Smartcrawl_Settings::get_specific_options( 'wds_settings_options' );
				$opts['checkup'] = true;
				Smartcrawl_Settings::update_specific_options( 'wds_settings_options', $opts );

				if ( Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member() ) {
					$opts = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_CHECKUP );
					$opts['checkup-cron-enable'] = true;
					Smartcrawl_Settings::update_component_options( Smartcrawl_Settings::COMP_CHECKUP, $opts );
				}

				$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
				$result = $service->start();
				if ( ! $result ) { $service->start(); }

				return wp_send_json_success();
			case 'checkup-run':
				$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
				$service->start();
				return wp_send_json_success();
			case 'analysis-enable':
				$opts = Smartcrawl_Settings::get_specific_options( 'wds_settings_options' );
				$opts['analysis-seo'] = true;
				$opts['analysis-readability'] = true;
				Smartcrawl_Settings::update_specific_options( 'wds_settings_options', $opts );
				return wp_send_json_success();
			case 'opengraph-enable':
				$opts = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
				$opts['og-enable'] = true;
				Smartcrawl_Settings::update_component_options( Smartcrawl_Settings::COMP_SOCIAL, $opts );
				return wp_send_json_success();
			case 'sitemaps-enable':
				$opts = Smartcrawl_Settings::get_specific_options( 'wds_settings_options' );
				$opts['sitemap'] = true;
				Smartcrawl_Settings::update_specific_options( 'wds_settings_options', $opts );
				return wp_send_json_success();
			case 'twitter-enable':
				$opts = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
				$opts['twitter-card-enable'] = true;
				Smartcrawl_Settings::update_component_options( Smartcrawl_Settings::COMP_SOCIAL, $opts );
				return wp_send_json_success();
			default:
				return wp_send_json_error();
		}
		return wp_send_json_error();
	}

	public function add_onboarding() {
		if ( get_site_option( 'wds-onboarding-done', false ) ) { return false; }

		$version = Smartcrawl_Loader::get_version();
		wp_enqueue_script( 'wds-onboard', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-onboard.js', array( 'wds-admin' ), $version );
		wp_localize_script('wds-onboard', '_wds_onboard', array(
			'templates' => array(
				'progress' => $this->_load( 'dashboard/onboard-progress' ),
			),
			'strings' => array(
				'All done' => __( 'All done, please hold on...', 'wds' ),
			),
		));

		$this->_render( 'dashboard/onboarding' );
	}
}