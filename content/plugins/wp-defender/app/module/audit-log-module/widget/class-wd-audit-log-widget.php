<?php

/**
 * Author: Hoang Ngo
 */
class WD_Audit_Log_Widget extends WD_Controller {
	public function __construct() {

	}

	public function display() {
		if ( WD_Utils::get_dev_api() == false ) {
			$this->render( 'widget/subscribe', array(), true );

			return;
		}


		if ( WD_Utils::get_setting( 'audit_log->enabled', 0 ) == 0 ) {
			$this->render( 'widget/activate', array(), true );
		} else {
			//get the amount
			$logs = WD_Audit_API::get_summary();

			$this->render( 'widget/log', array(
				'total' => is_wp_error( $logs ) ? $logs : $logs['count']
			), true );
		}
	}
}