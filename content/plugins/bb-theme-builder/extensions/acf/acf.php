<?php

define( 'FL_THEME_BUILDER_ACF_DIR', FL_THEME_BUILDER_DIR . 'extensions/acf/' );
define( 'FL_THEME_BUILDER_ACF_URL', FL_THEME_BUILDER_DIR . 'extensions/acf/' );

add_action( 'fl_page_data_add_properties', function() {
	if ( class_exists( 'acf' ) ) {
		require_once FL_THEME_BUILDER_ACF_DIR . 'classes/class-fl-page-data-acf.php';
		require_once FL_THEME_BUILDER_ACF_DIR . 'includes/page-data-acf.php';
	}
} );
