<?php

function smartcrawl_autoload( $class ) {
	$class_mappings = include 'class-mappings.php';
	if ( isset( $class_mappings[ $class ] ) && file_exists( SMARTCRAWL_PLUGIN_DIR . $class_mappings[ $class ] ) ) {
		include SMARTCRAWL_PLUGIN_DIR . $class_mappings[ $class ];
	}
}

spl_autoload_register( 'smartcrawl_autoload' );