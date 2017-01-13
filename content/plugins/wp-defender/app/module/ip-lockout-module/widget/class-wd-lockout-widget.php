<?php

/**
 * Author: Hoang Ngo
 */
class WD_Lockout_Widget extends WD_Controller {
	public function __construct() {
		$this->add_ajax_action( 'ip_protection_toggle', 'toggle_protection' );
	}

	public function toggle_protection() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		$type = WD_Utils::http_post( 'type' );
		if ( $type == 'login' ) {
			$settings                   = new \WP_Defender\IP_Lockout\Model\Settings_Model();
			$settings->login_protection = true;
			$settings->save();
			wp_send_json( array(
				'status' => 1,
				'value'  => count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_login_lockouts( 'monday this week' ) )
			) );
		} elseif ( $type == '404' ) {
			$settings             = new \WP_Defender\IP_Lockout\Model\Settings_Model();
			$settings->detect_404 = true;
			$settings->save();
			wp_send_json( array(
				'status' => 1,
				'value'  => count( \WP_Defender\IP_Lockout\Component\Login_Protection_Api::get_404_lockouts( 'monday this week' ) )
			) );
		}
	}

	public function display() {
		$this->render( 'widget/activate' );
	}
}