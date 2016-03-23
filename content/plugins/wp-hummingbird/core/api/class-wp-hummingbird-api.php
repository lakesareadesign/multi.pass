<?php

class WP_Hummingbird_API {

	public function __construct() {
		include_once( 'abstract-wp-hummingbird-api-service.php' );
		include_once( 'class-wp-hummingbird-api-request.php' );
		include_once( 'class-wp-hummingbird-api-uptime.php' );
		include_once( 'class-wp-hummingbird-api-performance.php' );
		include_once( 'class-wp-hummingbird-api-exception.php' );

		$this->uptime = new WP_Hummingbird_API_Uptime( $this );
		$this->performance = new WP_Hummingbird_API_Performance( $this );
	}

	public function get_api_key() {
		global $wpmudev_un;

		if ( ! is_object( $wpmudev_un )  && class_exists( 'WPMUDEV_Dashboard' ) && method_exists( 'WPMUDEV_Dashboard', 'instance' ) ) {
			$wpmudev_un = WPMUDEV_Dashboard::instance();
		}

		if ( defined( 'WPHB_API_KEY' ) ) {
			$api_key = WPHB_API_KEY;
		}
		elseif ( is_object( $wpmudev_un ) && method_exists( $wpmudev_un, 'get_apikey' ) ) {
			$api_key = $wpmudev_un->get_apikey();
		}
		elseif ( is_object( WPMUDEV_Dashboard::$api ) && method_exists( WPMUDEV_Dashboard::$api, 'get_key' ) ) {
			$api_key = WPMUDEV_Dashboard::$api->get_key();
		}
		else {
			$api_key = '';
		}


		return $api_key;
	}

}