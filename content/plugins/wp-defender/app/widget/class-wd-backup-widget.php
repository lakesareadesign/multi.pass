<?php

/**
 * @author: Hoang Ngo
 */
class WD_Backup_Widget extends WD_Controller {
	public function __construct() {
		$this->add_ajax_action( 'wd_install_snapshot', 'install_snapshot' );
	}

	public function install_snapshot() {
		if ( ! WD_Utils::check_permission()  ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_backup_widget' ), 'wd_install_snapshot' ) ) {
			return;
		}

		if ( WD_Utils::is_wpmudev_dashboard_installed() == false ) {
			return;
		}
		//need to check if we got that plugin install
		$slug = 'snapshot/snapshot.php';
		if ( file_exists( WP_CONTENT_DIR . '/plugins/' . $slug ) ) {
			//check if pplugn inactive, this mostly happen
			if ( is_plugin_inactive( $slug ) ) {
				$ret = activate_plugin( $slug );
				if ( ! is_wp_error( $ret ) ) {
					wp_send_json( array(
						'status' => 1
					) );
				} else {
					wp_send_json( array(
						'status' => 0,
						'error'  => $ret->get_error_message()
					) );
				}
			}
		} else {
			//plugin doesnt install
			$sid      = 257;
			$site_api = WPMUDEV_Dashboard::$site;
			$res      = $site_api->install_project( $sid, $errors, false );
			if ( $res == false ) {
				wp_send_json( array(
					'status' => 0,
					'error'  => $errors
				) );
			} else {
				//activate it
				activate_plugin( $slug );
				wp_send_json( array(
					'status' => 1
				) );
			}
		}
	}

	public function display() {
		$this->render( 'widgets/backup/main', array(), true );
	}
}