<?php

/**
 * Widget for manager blacklist status, data get feed from API
 * IN plugin scope, status will be is turn off, is clean, is blacklisted
 *
 * @author: Hoang Ngo
 */
class WD_Blacklist_Widget extends WD_Controller {
	const BLACKLIST_CACHE = 'wd_blacklist_lastcheck';
	const STATUS_OFF = 'off', STATUS_CLEAN = 'clean', STATUS_BLACKLISTED = 'blacklisted', STATUS_ERROR = 'error';
	private $end_point = "https://premium.wpmudev.org/api/defender/v1/blacklist-monitoring";
	private $domain = '';
	private $status = false;
	public $error = '';

	public function __construct() {
		if ( WD_Utils::get_dev_api() != false ) {
			$this->domain = network_site_url();
			$this->add_ajax_action( 'wd_toggle_blacklist', 'toggle_blacklist' );
		}
	}

	/**
	 * This will check and bind blacklist status
	 */
	protected function settle_status() {
		$endpoint = $this->end_point . '?domain=' . $this->domain;
		$result   = $this->wpmudev_call( $endpoint, array(), array(
			'method'  => 'GET',
			'timeout' => 5
		), true );
		if ( is_wp_error( $result ) ) {
			//this mean error when firing to API
			$this->log( var_export( $result, true ), self::ERROR_LEVEL_DEBUG, 'blacklist' );
			$this->status = self::STATUS_ERROR;
			$this->error  = $result->get_error_message();

			return;
		}
		$this->log( 'backlist call' . var_export( $result, true ), self::ERROR_LEVEL_DEBUG, 'blacklist' );

		$response_code = wp_remote_retrieve_response_code( $result );
		$body          = wp_remote_retrieve_body( $result );
		$body          = json_decode( $body, true );

		if ( $response_code == 412 ) {
			//this mean disable
			$this->status = self::STATUS_OFF;
		} elseif ( isset( $body['services'] ) && is_array( $body['services'] ) ) {
			$this->status = self::STATUS_CLEAN;
			foreach ( $body['services'] as $service ) {
				if ( $service['blacklisted'] == true && $service['last_checked'] != false ) {
					$this->status = self::STATUS_BLACKLISTED;
					break;
				}
			}
		} else {
			//at this point means st wrong happens, domain status enabled, but non response from server.
			//flag as black for now
			$this->status = self::STATUS_ERROR;
			if ( isset( $body['message'] ) ) {
				$this->error = $body['message'];
			} else {
				$this->error = __( "Something wrong happened, please try again.", wp_defender()->domain );
			}
			$this->log( var_export( $result, true ), self::ERROR_LEVEL_DEBUG, 'blacklist' );
		}
	}

	/**
	 * Ajax function for toggle blacklist status on/off
	 */
	public function toggle_blacklist() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_service_nonce' ), 'wd_toggle_blacklist' ) ) {
			return;
		}
		$is_on_hold = WD_Utils::get_setting( 'blacklist->is_hold', false );
		if ( $is_on_hold != false ) {
			//settling,
			return;
		}

		$this->settle_status();

		if ( $this->status == self::STATUS_ERROR ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => $this->error
			) );
		}

		if ( $this->status == self::STATUS_OFF ) {
			//enable for API
			$result      = $this->wpmudev_call( $this->end_point, array(), array(
				'method' => 'POST'
			), true );
			$next_status = 'on';
		} else {
			$endpoint    = $this->end_point . '?domain=' . $this->domain;
			$result      = $this->wpmudev_call( $endpoint, array(), array(
				'method' => 'DELETE'
			), true );
			$next_status = 'off';
		}
		$response_code = wp_remote_retrieve_response_code( $result );
		$body          = wp_remote_retrieve_body( $result );
		$body          = json_decode( $body, true );
		$this->log( var_export( $result, true ), self::ERROR_LEVEL_DEBUG, 'blacklist' );
		if ( $response_code !== 200 ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => $body['message']
			) );
		} else {
			//maybe give it some time
			WD_Utils::update_setting( 'blacklist->is_hold', $next_status );
			ob_start();
			$this->display();
			$contents = ob_get_clean();
			wp_send_json( array(
				'status' => 1,
				'html'   => $contents
			) );
		}
	}

	/**
	 * determine of status is progressing or finished settle
	 * @return bool
	 */
	public function is_on_hold() {
		/**
		 * this is just a flag, if next status = current status, remove onhold key, and return false,
		 * else return true
		 */
		$next_status = WD_Utils::get_setting( 'blacklist->is_hold', false );
		//nothing init here
		if ( $next_status == false ) {
			return false;
		}

		if ( ( $next_status == 'on' && $this->status != self::STATUS_OFF )
		     || ( $next_status == 'off' && $this->status == self::STATUS_OFF )
		) {
			//status update, just remove
			WD_Utils::update_setting( 'blacklist->is_hold', false );

			return false;
		}

		return true;
	}

	/**
	 * get current status
	 * @return bool
	 */
	public function get_status() {
		return $this->status;
	}

	/**
	 * check if the site on local, we need this cause on local domain, blacklist wont work
	 * @return bool
	 */
	public function is_local() {
		$whitelist = array(
			'127.0.0.1',
			'::1'
		);
		if ( ! in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
			return false;
		}

		return true;
	}

	/**
	 * showup the widget
	 */
	public function display() {
		$this->settle_status();
		if ( WD_Utils::get_dev_api() == false ) {
			$this->render( 'widgets/blacklist/blacklist-subscribe', array(), true );
		} elseif ( $this->status == self::STATUS_OFF ) {
			$this->render( 'widgets/blacklist/blacklist-off', array(), true );
		} elseif ( $this->status == self::STATUS_ERROR ) {
			$this->render( 'widgets/blacklist/blacklist-error', array(), true );
		} else {
			$this->render( 'widgets/blacklist/blacklist', array(
				'is_ok' => $this->status == self::STATUS_CLEAN ? true : false
			), true );
		}
	}
}