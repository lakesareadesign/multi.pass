<?php

class WP_Hummingbird_API_Uptime extends WP_Hummingbird_API_Service {

	protected $name = 'uptime';

	public function check( $time = 'day' ) {
		return $this->execute( 'stats/' . $time, array( 'timeout' => 20, 'method' => 'GET' ) );
	}

	public function enable() {
		$results = $this->execute( 'monitoring/', array( 'timeout' => 30, 'method' => 'POST' ) );
		if ( $results !== true ) {
			return new WP_Error( 500, __( 'Unknown Error', 'wphb' ) );
		}

		return $results;
	}

	public function disable() {
		$results = $this->execute( 'monitoring/', array( 'timeout' => 30, 'method' => 'DELETE' ) );
		if ( $results !== true ) {
			return new WP_Error( 500, __( 'Unknown Error', 'wphb' ) );
		}

		return $results;
	}
}