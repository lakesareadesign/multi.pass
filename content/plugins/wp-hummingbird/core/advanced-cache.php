<?php
/**
 * Hummingbird Page Caching
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'WPHB_ADVANCED_CACHE', true );

/**
 * Load necessary modules for caching.
 */

if ( ! class_exists( 'WP_Hummingbird_Module_Page_Caching' ) ) {
	if ( is_dir( WP_CONTENT_DIR . '/plugins/wp-hummingbird/' ) ) {
		$path = WP_CONTENT_DIR . '/plugins/wp-hummingbird/';
	} elseif ( is_dir( WP_CONTENT_DIR . '/plugins/hummingbird-performance/' ) ) {
		$path = WP_CONTENT_DIR . '/plugins/wp-hummingbird/';
	} else {
		$path = WP_CONTENT_DIR . '/plugins/wp-hummingbird-wporg/';
	}

	include_once( $path . 'helpers/wp-hummingbird-helpers-core.php' );
	include_once( $path . 'core/class-abstract-module.php' );
	include_once( $path . 'core/modules/class-module-page-caching.php' );
	WP_Hummingbird_Module_Page_Caching::serve_cache();
}