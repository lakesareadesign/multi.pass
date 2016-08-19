<?php

class WP_Hummingbird_API_Service_Performance extends WP_Hummingbird_API_Service {

	public $name = 'performance';

	private $version = 'v1';

	public function __construct() {
		$this->request = new WP_Hummingbird_API_Request_WPMUDEV( $this );
	}

	public function get_version() {
		return $this->version;
	}

	/**
	 * Check if performance test has finished on server
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function check() {
		return $this->request->post( 'site/check/', array( 'domain' => $this->request->get_this_site() ) );
	}

	/**
	 * Ping to Performance Module so it starts to gather data
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function ping() {
		$this->request->set_timeout( 0.1 );
		return $this->request->post( 'site/check/', array( 'domain' => $this->request->get_this_site() ) );
	}

	/**
	 * Get the latest performance test results
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function results() {
		return $this->request->get( 'site/result/latest/', array( 'domain' => $this->request->get_this_site() ) );
	}


}