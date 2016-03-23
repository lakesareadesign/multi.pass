<?php

abstract class WP_Hummingbird_API_Service {

	protected $name = '';

	/**
	 * WP_Hummingbird_API_Service constructor.
	 *
	 * @param WP_Hummingbird_API $api WPHB API Instance
	 */
	public function __construct( $api ) {
		$this->api = $api;
	}

	public function execute( $path, $args = array() ) {
		include_once( 'class-wp-hummingbird-api-request.php' );

		try {
			$request = new WP_Hummingbird_API_Request( $this );
			$request->set_api_key( $this->api->get_api_key() );
			$request->set_path( $path );

			if ( isset( $args['timeout'] ) ) {
				$request->set_timeout( $args['timeout'] );
			}

			if ( isset( $args['method'] ) ) {
				$request->set_method( $args['method'] );
			}

			$result = $request->request();
			return $result;
		}
		catch ( WP_Hummingbird_API_Exception $e ) {
			return new WP_Error( $e->getCode(), $e->getMessage() );
		}
	}

	/**
	 * Get the Service Name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

}