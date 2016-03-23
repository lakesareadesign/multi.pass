<?php

class WP_Hummingbird_API_Performance extends WP_Hummingbird_API_Service {

	public $name = 'performance';

	/**
	 * @param string $request_type ping or wait
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function check() {
		return $this->execute( 'site/check/' );
	}

	public function ping() {
		$args = array();
		$args['timeout'] = 0.1;
		return $this->execute( 'site/check/', $args );
	}

	public function results() {
		return $this->execute( 'site/result/latest/', array( 'method' => 'GET' ) );
	}
}