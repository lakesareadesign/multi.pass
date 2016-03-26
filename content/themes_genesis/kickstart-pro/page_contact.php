<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

// Template Name: Contact

add_filter( 'body_class', 'kickstart_body_class' );
// Add custom body class to the head
function kickstart_body_class( $classes ) {
	$classes[] = 'page-contact';

	return $classes;
}

// Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', 'kickstart_contact_before' );
// Add before content section
function kickstart_contact_before() {

	if ( is_active_sidebar( 'kickstart-contact-map' ) ) {

		echo '<div class="before-contact">';
			genesis_widget_area( 'kickstart-contact-map', array(
				'before' => '<div id="kickstart-contact-map" class="kickstart-contact-map widget-area">',
				'after'  => '</div>',
			) );

			if ( is_active_sidebar( 'kickstart-contact-box' ) ) {
				genesis_widget_area( 'kickstart-contact-box', array(
					'before' => '<div class="wrap"><div id="kickstart-contact-box" class="kickstart-contact-box widget-area">',
					'after'  => '</div></div>',
				) );
			}
		echo '</div>';

	}

}

genesis();
