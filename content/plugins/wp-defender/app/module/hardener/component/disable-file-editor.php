<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Hardener\Component;

use WP_Defender\Module\Hardener\Model\Settings;
use WP_Defender\Module\Hardener\Rule;

class Disable_File_Editor extends Rule {
	static $slug = 'disable_file_editor';
	static $service;

	function getDescription() {
		$this->renderPartial( 'rules/disable-file-editor' );
	}

	function check() {
		return $this->getService()->check();
	}

	public function getTitle() {
		return __( "Disable the file editor", wp_defender()->domain );
	}

	function addHooks() {
		$this->add_action( 'processingHardener' . self::$slug, 'process' );
		$this->add_action( 'processRevert' . self::$slug, 'revert' );
	}

	function revert() {
		if ( ! $this->verifyNonce() ) {
			return;
		}
		$ret = $this->getService()->revert();
		if ( ! is_wp_error( $ret ) ) {
			Settings::instance()->addToIssues( self::$slug );
		} else {
			wp_send_json_error( array(
				'message' => $ret->get_error_message()
			) );
		}
	}

	function process() {
		if ( ! $this->verifyNonce() ) {
			return;
		}

		$ret = $this->getService()->process();
		if ( ! is_wp_error( $ret ) ) {
			Settings::instance()->addToResolved( self::$slug );
		} else {
			wp_send_json_error( array(
				'message' => $ret->get_error_message()
			) );
		}
	}

	/**
	 * @return Disable_File_Editor_Service
	 */
	function getService() {
		if ( self::$service == null ) {
			self::$service = new Disable_File_Editor_Service();
		}

		return self::$service;
	}
}