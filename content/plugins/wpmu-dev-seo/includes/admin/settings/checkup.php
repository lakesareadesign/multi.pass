<?php
/**
 * Checkup service
 *
 * @package wpmu-dev-seo
 */

/**
 * Checkup service admin handler class
 */
class Smartcrawl_Checkup_Settings extends Smartcrawl_Settings_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Smartcrawl_Checkup_Settings
	 */
	private static $_instance;

	/**
	 * Singleton instance getter
	 *
	 * @return Smartcrawl_Checkup_Settings instance
	 */
	public static function get_instance() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Validate submitted options
	 *
	 * @param array $input Raw input.
	 *
	 * @return array Validated input
	 */
	public function validate( $input ) {
		if ( empty( $input['checkup-cron-enable'] ) ) {
			$result['checkup-cron-enable'] = false;
			return $result;
		} else { $result['checkup-cron-enable'] = true; }

		$frequency = ! empty( $input['checkup-frequency'] )
			? Smartcrawl_Controller_Cron::get()->get_valid_frequency( $input['checkup-frequency'] )
			: Smartcrawl_Controller_Cron::get()->get_default_frequency();
		$result['checkup-frequency'] = $frequency;

		$dow = isset( $input['checkup-dow'] ) && is_numeric( $input['checkup-dow'] )
			? (int) $input['checkup-dow']
			: 0
		;
		$result['checkup-dow'] = in_array( $dow, range( 0,6 ) ) ? $dow : 0;

		$tod = isset( $input['checkup-tod'] ) && is_numeric( $input['checkup-tod'] )
			? (int) $input['checkup-tod']
			: 0
		;
		$result['checkup-tod'] = in_array( $tod, range( 0,23 ) ) ? $tod : 0;

		if ( ! empty( $input['email-recipients'] ) && is_array( $input['email-recipients'] ) ) {
			$result['email-recipients'] = array();
			foreach ( $input['email-recipients'] as $user ) {
				if ( ! is_numeric( $user ) ) {
					$user_obj = get_user_by( 'login', $user );
					$user = $user_obj->ID;
				}

				if ( is_numeric( $user ) ) { $result['email-recipients'][] = (int) $user; }
			}
			$result['email-recipients'] = array_values( array_filter( array_unique( $result['email-recipients'] ) ) );
		}
		if ( empty( $result['email-recipients'] ) ) {
			$defaults = $this->get_default_options();
			$result['email-recipients'] = $defaults['email-recipients'];
		}

		return $result;
	}

	/**
	 * Initialize admin pane
	 */
	public function init() {
		$this->option_name = 'wds_checkup_options';
		$this->name        = Smartcrawl_Settings::COMP_CHECKUP;
		$this->slug        = Smartcrawl_Settings::TAB_CHECKUP;
		$this->action_url  = admin_url( 'options.php' );
		$this->title       = __( 'SEO Checkup', 'wds' );
		$this->page_title  = __( 'SmartCrawl Wizard: SEO Checkup', 'wds' );

		parent::init();

		add_action( 'wp_ajax_wds-checkup-status', array( $this, 'ajax_checkup_status' ) );
	}

	/**
	 * Checks checkup service status and sends back percentage.
	 */
	public function ajax_checkup_status() {
		$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
		$percentage = $service->status();
		return wp_send_json_success(array(
			'percentage' => $percentage,
		));
	}

	/**
	 * Process run action
	 */
	public function process_run_action() {
		if ( ! empty( $_GET['run-checkup'] ) ) { // Simple presence switch, no value.
			return $this->run_checkup();
		}
	}

	/**
	 * Add admin settings page
	 */
	public function options_page() {
		parent::options_page();

		$options = Smartcrawl_Settings::get_component_options( $this->name );
		$options = wp_parse_args(
			(is_array( $options ) ? $options : array()),
			$this->get_default_options()
		);

		$arguments = array(
			'options'    => $options,
			'active_tab' => $this->_get_last_active_tab( 'tab_checkup' ),
		);

		$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
		wp_enqueue_script( 'wds-admin-checkup' );

		$this->_render_page( 'checkup/checkup-settings', $arguments );
	}

	/**
	 * Gets default options set and their initial values
	 *
	 * @return array
	 */
	public function get_default_options() {
		return array(
			'checkup-cron-enable' => false,
			'checkup-frequency' => 'weekly',
			'checkup-dow' => rand( 0, 6 ),
			'checkup-tod' => rand( 0, 23 ),
			'email-recipients' => array( get_current_user_id() ),
		);
	}

	/**
	 * Default settings
	 */
	public function defaults() {
		$options = Smartcrawl_Settings::get_component_options( $this->name );
		$options = is_array( $options ) ? $options : array();

		foreach ( $this->get_default_options() as $opt => $default ) {
			if ( ! isset( $options[ $opt ] ) ) { $options[ $opt ] = $default; }
		}

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			update_site_option( $this->option_name, $options );
		} else {
			update_option( $this->option_name, $options );
		}
	}

}
