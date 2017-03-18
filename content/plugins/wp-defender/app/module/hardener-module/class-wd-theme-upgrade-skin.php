<?php

/**
 * This just a sub class, to support theme ajax upgrade
 * @author: Hoang Ngo
 */
if ( ! class_exists( 'Theme_Upgrader_Skin' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php';
}

class WD_Theme_Upgrade_Skin extends Theme_Upgrader_Skin {
	/**
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$defaults = array( 'url' => '', 'theme' => '', 'nonce' => '', 'title' => esc_html__( 'Update Theme' ) );
		$args     = wp_parse_args( $args, $defaults );

		$this->theme = $args['theme'];

		parent::__construct( $args );
	}

	public function after() {

	}

	public function error( $errors ) {

	}

	public function feedback( $string ) {

	}

	public function header() {

	}

	public function footer() {

	}
}