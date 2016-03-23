<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Hardener_Abstract extends WD_Component {
	/**
	 * unique id of the rule
	 * @var string
	 */
	protected $id;
	/**
	 * rule description, can be html
	 * @var string
	 */
	protected $title;

	/**
	 * If this rule can be undone, mark this as true
	 * @var bool
	 */
	protected $can_revert = false;

	/**
	 * For caching status of check
	 * @var bool
	 */
	protected $check_cache;

	/**
	 * Contains errors after process a hardener rule
	 * @var array
	 */
	public $last_processed = 0;

	public function __construct() {
		$this->on_creation();
		if ( ( $last_processed = WD_Utils::get_setting( $this->get_setting_key( 'processed_time' ) ) ) ) {
			$this->last_processed = $last_processed;
		}
		do_action( 'wd_hardener_' . $this->id . '_after_init', $this );
	}

	/**
	 * this must be implement by child class, to initial data when load
	 * @return mixed
	 */
	abstract function on_creation();

	/**
	 * we process the fix here
	 * @return mixed
	 */
	abstract function process();

	/**
	 * For revert the stuff
	 * @return mixed
	 */
	abstract function revert();

	/**
	 * For diagnosis the issue
	 * @return mixed
	 */
	abstract function check();

	/**
	 * This will return the display for current module
	 * @return mixed
	 */
	abstract function display();

	/**
	 * Return css class
	 * @return string
	 */
	protected function get_css_class() {
		return $this->check() === true ? 'fixed' : 'issue';
	}

	/**
	 * This will output a shorter version of hardening title
	 * @return string
	 */
	public function display_link_only() {
		ob_start();
		?>
		<div class="wd-hardener-rule">
			<div class="rule-title <?php echo $this->get_css_class(); ?>">
				<a href="<?php echo $this->get_link() ?>">
					<?php echo $this->get_icon(); ?>
					<?php echo $this->title ?>
				</a>
			</div>
			<div class="wd-clearfix"></div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Return the icon for header
	 * @return string
	 */
	protected function get_icon() {
		return $this->check() === true ? '<i class="wdv-icon wdv-icon-fw wdv-icon-ok"></i>' : '<i class="dashicons dashicons-flag"></i>';
	}

	/**
	 * This will output full version of hardening title
	 *
	 * @return string
	 */
	protected function get_rule_title() {
		ob_start();
		?>
		<div class="rule-title <?php echo $this->get_css_class(); ?> wd-according"
		     data-target="#<?php echo $this->id ?>">
			<?php echo $this->get_icon(); ?>
			<?php echo $this->title ?>
			<i class="wdv-icon wdv-icon-large wdv-icon-plus wd_toggle_icon"></i>

			<div class="wd-caret-down wd-hide"></div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Return the hardening link
	 * @return string|void
	 */
	public function get_link() {
		$base_url = network_admin_url( 'admin.php?page=wdf-hardener' );
		$base_url .= "#" . $this->id;

		return $base_url;
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_ajax_action( $action ) {
		return 'wd_' . $this->id . '_' . $action;
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_nonce_field( $action ) {
		return wp_nonce_field( $this->id . '_' . $action, $this->id . '_nonce' );
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	public function generate_nonce( $action ) {
		return wp_create_nonce( $this->id . '_' . $action );
	}

	/**
	 * @param $action
	 *
	 * @return false|int
	 */
	public function verify_nonce( $action ) {
		return wp_verify_nonce( WD_Utils::http_post( $this->id . '_nonce', null ), $this->id . '_' . $action );
	}

	/**
	 * @param $key
	 * @param $error
	 *
	 * @return WP_Error
	 */
	public function output_error( $key, $error ) {
		//logging
		$this->log( 'WP Defender Error-' . $this->id . ' : ' . $error, self::ERROR_LEVEL_ERROR );
		if ( $this->is_ajax() ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => $error
			) );
		} else {
			return new WP_Error( $key, $error );
		}
	}

	/**
	 * logic after processed
	 */
	protected function after_processed() {
		WD_Utils::update_setting( $this->get_setting_key( 'processed_time' ), time() );
		WD_Utils::flag_for_submitting();
		do_action( 'wd_hardener_' . $this->id . '_after_processed', $this );
		do_action( 'wd_hardener_after_processed', $this );
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	protected function get_setting_key( $key ) {
		return $this->id . '->' . $key;
	}
}