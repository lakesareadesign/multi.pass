<?php
/**
 * Author: Hoang Ngo
 */

namespace Hammer\Helper;

class Log_Helper {
	public static function logger( $log ) {
		$path = WP_Helper::getUploadDir() . '/wp-defender/logs';
		if ( ! is_dir( $path ) ) {
			wp_mkdir_p( $path );
		}
		if ( class_exists( '\Katzgrau\KLogger\Logger' ) ) {
			$logger = new \Katzgrau\KLogger\Logger( $path );
			$logger->debug( $log );
		}
	}
}