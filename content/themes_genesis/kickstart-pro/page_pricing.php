<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

// Template Name: Pricing

add_filter( 'body_class', 'kickstart_body_class' );
// Add custom body class to the head
function kickstart_body_class( $classes ) {
	$classes[] = 'page-pricing';

	return $classes;
}

add_action( 'genesis_after_header', 'kickstart_pricing_before' );
// Add before content section
function kickstart_pricing_before() {
	if ( is_active_sidebar( 'lean-pricing' ) ) {
		genesis_widget_area( 'lean-pricing', array(
			'before' => '<div id="lean-pricing" class="lean-pricing before-content widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}
}

genesis();
