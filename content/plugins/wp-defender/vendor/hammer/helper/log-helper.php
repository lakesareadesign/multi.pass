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
		} else {
			$filename = $path . '/debug.log';
			$fd = fopen( $filename, "a" );
			// append date/time to message
			$str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $log;
			// write string
			fwrite( $fd, $str . "\n" );
			// close file
			fclose( $fd );
		}
	}
}