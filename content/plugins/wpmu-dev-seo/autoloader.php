<?php

function smartcrawl_autoload( $class ) {
	$mappings_file = dirname( __FILE__ ) . '/class-mappings.php';
	if ( ! file_exists( $mappings_file ) ) {
		return;
	}

	$class_mappings = include $mappings_file;
	if ( ! isset( $class_mappings[ $class ] ) ) {
		return;
	}

	$class_path = untrailingslashit( SMARTCRAWL_PLUGIN_DIR ) . $class_mappings[ $class ];
	if ( ! file_exists( $class_path ) ) {
		return;
	}

	include $class_path;
}

spl_autoload_register( 'smartcrawl_autoload' );