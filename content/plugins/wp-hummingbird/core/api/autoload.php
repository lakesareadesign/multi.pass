<?php

/**
 * Hummingbird API autoloader
 */
spl_autoload_register( 'wphb_api_autoload' );
function wphb_api_autoload( $classname ) {
	if ( strpos( $classname, 'WP_Hummingbird_API_' ) !== 0 ) {
		return;
	}

	$base_dir = wphb_plugin_dir() . 'core/api';

	$classname = str_replace( 'WP_Hummingbird_API_', '', $classname );
	$class_parts = explode( '_', $classname );

	if ( ! $class_parts ) {
		return;
	}

	$file = '';
	$folder = strtolower( $class_parts[0] );
	if ( ! isset( $class_parts[1] ) ) {
		$file = "$base_dir/$folder/$folder.php";
	}
	else {
		$file_slug = strtolower( $class_parts[1] );
		$file = "$base_dir/$folder/$file_slug.php";
	}

	if ( is_readable( $file ) ) {
		include_once( $file );
	}
}