<?php

if ( ! class_exists( 'Smartcrawl_Work_Unit' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_work_unit.php' ); }

/**
 * Outputs Twitter cards data to the page
 */
class Smartcrawl_Pinterest_Printer extends Smartcrawl_WorkUnit {

	/**
	 * Singleton instance holder
	 */
	private static $_instance;

	private $_is_running = false;
	private $_is_done = false;

	/**
	 * Singleton instance getter
	 *
	 * @return object Smartcrawl_Pinterest_Printer instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->_add_hooks();
	}

	private function _add_hooks() {
		// Do not double-bind
		if ( $this->apply_filters( 'is_running', $this->_is_running ) ) {
			return true;
		}

		add_action( 'wp_head', array( $this, 'dispatch_tags_injection' ), 50 );
		add_action( 'wds_head-after_output', array( $this, 'dispatch_tags_injection' ) );

		$this->_is_running = true;
	}

	public function dispatch_tags_injection() {
		if ( ! ! $this->_is_done ) { return false; }
		$verify = $this->get_verify_content();
		if ( empty( $verify ) ) { return false; }

		$this->_is_done = true;

		echo "{$verify}\n";
	}

	/**
	 * Gets pinterest meta verification tag
	 *
	 * Verbatim HTML
	 *
	 * @return string Pinterest verification tag
	 */
	public function get_verify_content() {
		$options = Smartcrawl_Settings::get_component_options( Smartcrawl_Settings::COMP_SOCIAL );
		$tag = is_array( $options ) && ! empty( $options['pinterest-verify'] )
			? $options['pinterest-verify']
			: ''
		;

		return $this->get_verified_tag( $tag );
	}

	/**
	 * Gets cleaned up and verified meta tag
	 *
	 * @param string $tag HTML to clean up
	 *
	 * @return string Verified tag
	 */
	public function get_verified_tag( $tag ) {
		$sane = trim(wp_kses(
			$tag,
			array(
				'meta' => array(
					'name' => array(),
					'content' => array(),
				),
			),
			array( 'http', 'https' )
		));
		return ! ! preg_match( '/<meta/i', $sane )
			? $sane
			: ''
		;
	}

	public function get_filter_prefix() {
		return 'wds-pinterest';
	}
}