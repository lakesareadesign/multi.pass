<?php

add_filter('body_class', 'string_body_class');
function string_body_class( $classes ) {

	$styleSelected = genesis_get_option( 'style_selection' );
	if ( isset( $_GET['color'] ) ) {
		// Get 'color' variable from URL
		if ( $_GET['color'] == 'gray' ) {
			// Default color
			$classes[] = $styleSelected;
		} else {
			$classes[] = 'hello-pro-' . sanitize_html_class( $_GET['color'] );
		}
	} else if ( $styleSelected ) {
		$classes[] = $styleSelected;
	} else {
		/* // If no color choice selected // */
		$classes[] = '';
	}

	return $classes;

}
