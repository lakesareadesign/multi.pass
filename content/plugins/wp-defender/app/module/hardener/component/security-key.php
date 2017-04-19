<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Hardener\Component;

use Hammer\Helper\HTTP_Helper;
use Hammer\Helper\WP_Helper;
use WP_Defender\Behavior\Utils;
use WP_Defender\Module\Hardener\Model\Settings;
use WP_Defender\Module\Hardener\Rule;

class Security_Key extends Rule {
	static $slug = 'security_key';
	static $service;

	function getDescription() {
		$cache = WP_Helper::getCache();
		$time  = $cache->get( Security_Key_Service::CACHE_KEY, false );
		if ( $time ) {
			$daysAgo = ( time() - $time ) / ( 60 * 60 * 24 );
		} else {
			$daysAgo = null;
		}
		$this->renderPartial( 'rules/security-key', array(
			'interval' => '60 days',
			'daysAgo'  => $daysAgo
		) );
	}

	/**
	 * @return string
	 */
	function getTitle() {
		return __( "Update old security keys", wp_defender()->domain );
	}

	function check() {
		return $this->getService()->check();
	}

	function addHooks() {
		$this->add_action( 'processingHardener' . self::$slug, 'process' );
		$this->add_ajax_action( 'updateSecurityReminder', 'updateSecurityReminder' );
	}

	public function updateSecurityReminder() {
		if ( ! Utils::instance()->checkPermission() ) {
			return;
		}

		$reminder = HTTP_Helper::retrieve_post( 'remind_date', null );
		if ( $reminder ) {
			WP_Helper::getCache()->set( 'securityReminderDate', strtotime( '+' . $reminder . ' days', current_time( 'timestamp' ) ) );
			die;
		}
	}

	function revert() {

	}

	function process() {
		if ( ! $this->verifyNonce() ) {
			return;
		}
		$ret = $this->getService()->process();
		if ( is_wp_error( $ret ) ) {
			wp_send_json_error( array(
				'message' => $ret->get_error_message()
			) );
		} else {
			Settings::instance()->addToResolved( self::$slug );
			wp_send_json_success( array(
				'message' => sprintf( __( 'All key salts have been regenerated. You will now need to <a href="%s"><strong>re-login</strong></a>.<br/>This will auto reload after 3 seconds.', wp_defender()->domain ), network_admin_url( 'admin.php?page=wdf-hardener' ) ),
				'reload'  => 3
			) );
		}
	}

	/**
	 * @return Security_Key_Service
	 */
	public function getService() {
		if ( self::$service == null ) {
			self::$service = new Security_Key_Service();
		}

		return self::$service;
	}
}