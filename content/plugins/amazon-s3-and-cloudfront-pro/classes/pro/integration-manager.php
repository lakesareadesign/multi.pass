<?php

namespace DeliciousBrains\WP_Offload_S3\Pro;

class Integration_Manager {

	/**
	 * @var Integration_Manager
	 */
	protected static $instance;

	/**
	 * @var array
	 */
	private $integrations = array();

	/**
	 * Make this class a singleton.
	 *
	 * Use this instead of __construct().
	 *
	 * @return Integration_Manager
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) && ! ( self::$instance instanceof Integration_Manager ) ) {
			static::$instance = new Integration_Manager();
		}

		return static::$instance;
	}

	/**
	 * Register integration.
	 *
	 * @param string      $slug
	 * @param Integration $integration
	 */
	public function register_integration( $slug, Integration $integration ) {
		if ( $integration->is_installed() ) {
			$integration->init();
		}

		$this->integrations[ $slug ] = $integration;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * class via the `new` operator from outside of this class.
	 */
	protected function __construct() {
	}

	/**
	 * As this class is a singleton it should not be clone-able.
	 */
	protected function __clone() {
	}

	/**
	 * As this class is a singleton it should not be able to be unserialized.
	 */
	protected function __wakeup() {
	}

}