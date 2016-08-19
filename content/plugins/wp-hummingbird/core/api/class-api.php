<?php

class WP_Hummingbird_API {

	public function __construct() {
		include_once( 'autoload.php' );
		$this->uptime = new WP_Hummingbird_API_Service_Uptime();
		$this->performance = new WP_Hummingbird_API_Service_Performance();
		$this->cloudflare = new WP_Hummingbird_API_Service_Cloudflare();
	}
}