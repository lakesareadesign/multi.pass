<?php

class WP_Hummingbird_API_Request {

	private $api_url = 'https://premium.wpmudev.org/api/%%MODULE%%/v1/';

	/**
	 * API Key
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Module action path
	 *
	 * @var string
	 */
	private $path = '';

	/**
	 * @var null|WP_Hummingbird_API_Service
	 */
	private $service = null;

	/**
	 * Request Method
	 *
	 * @var string
	 */
	private $method = 'POST';


	private $timeout = 15;

	/**
	 * WP_Hummingbird_API_Request constructor.
	 *
	 * @param WP_Hummingbird_API_Service $service
	 *
	 * @throws WP_Hummingbird_API_Exception
	 */
	public function __construct( $service ) {
		if ( ! $service instanceof WP_Hummingbird_API_Service ) {
			throw new WP_Hummingbird_API_Exception( __( 'Wrong Service. $service must be an instance of WP_Hummingbird_API_Service', 'wphb' ), 404 );
		}

		$this->service = $service;
	}

	/**
	 * Set the Request API Key
	 *
	 * @param string $api_key
	 */
	public function set_api_key( $api_key ) {
		$this->api_key = $api_key;
	}


	/**
	 * Set the Request Path
	 *
	 * @param string $path
	 */
	public function set_path( $path ) {
		$this->path = $path;
	}

	public function set_method( $method ) {
		$this->method = $method;
	}

	public function set_timeout( $timeout ) {
		$this->timeout = $timeout;
	}

	/**
	 * Get the Request URL
	 *
	 * @return mixed
	 */
	public function get_api_url() {
		if ( defined( 'WPHB_TEST_API_URL' ) && WPHB_TEST_API_URL ) {
			$url = WPHB_TEST_API_URL;
		} else {
			$url = $this->api_url;
		}

		$url = trailingslashit( str_replace( '%%MODULE%%', $this->service->get_name(), $url ) );
		$url .= $this->path;

		if ( $this->method != 'POST' ) {
			$url = add_query_arg( array( 'domain' => $this->get_this_site() ), $url );
		}

		return $url;
	}

	/**
	 * Get the current Site URL
	 *
	 * @return string
	 */
	public function get_this_site() {
		if ( defined( 'WPHB_API_DOMAIN' ) ) {
			$domain = WPHB_API_DOMAIN;
		} else {
			$domain = network_site_url();
		}

		return $domain;
	}


	/**
	 * @throws WP_Hummingbird_API_Exception
	 */
	public function request() {
		$url = $this->get_api_url();

		if ( $this->method == 'POST' ) {
			$args['body'] = array( 'domain' => $this->get_this_site() );
		}

		$args['headers'] = array( 'Authorization' => 'Basic ' . $this->api_key );
		$args['sslverify'] = false;
		$args['method']    = $this->method;
		$args['timeout'] = $this->timeout;

		if ( ! $args['timeout'] || 0.1 === $args['timeout'] ) {
			$args['blocking'] = false;
		}

		$this->log( "WPHB API: Sending request to $url" );
		$this->log( "WPHB API: Arguments:" );
		$this->log( $args );

		$response = wp_remote_post( $url, $args );

		$this->log( "WPHB API: Response:" );
		$this->log( $response );

		if ( is_wp_error( $response ) ) {
			throw new WP_Hummingbird_API_Exception( $response->get_error_message(), $response->get_error_code() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		$body = json_decode( wp_remote_retrieve_body( $response ) );
		$message = isset( $body->message ) ? $body->message : sprintf( __( 'Unknown Error. Code: %s', 'wphb' ), $code );

		if ( 200 != $code ) {
			throw new WP_Hummingbird_API_Exception( $message, $code );
		}
		else {
			if ( is_object( $body ) && isset( $body->error ) && $body->error ) {
				throw new WP_Hummingbird_API_Exception( $message, $code );
			}
			return $body;
		}

	}

	private function log( $message ) {
		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			$date = current_time( 'mysql' );
			if ( ! is_string( $message ) ) {
				$message = print_r( $message, true );
			}
			error_log( '[' . $date . '] - ' . $message );
		}
	}
}