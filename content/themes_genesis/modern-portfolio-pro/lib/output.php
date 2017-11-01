<?php
/**
 * Modern Portfolio Pro.
 *
 * This file adds the required CSS to the front end to the Modern Portfolio Pro Theme.
 *
 * @package Modern Portfolio
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/modern-portfolio/
 */

add_action( 'wp_enqueue_scripts', 'modern_portfolio_set_icon' );
/**
 * Checks the settings for the custom initial.
 * If this value is set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function modern_portfolio_set_icon() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$icon = get_option( 'modern_portfolio_custom_initial', 'M' );

	if( empty( $icon ) || get_header_image() ) {
		return;
	}

	$css = sprintf( '.site-title a::before{ content: \'%s\'; }', $icon[0] );

	wp_add_inline_style( $handle, $css );

}
