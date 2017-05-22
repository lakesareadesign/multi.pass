<?php
/**
 * This file adds customizations to the front page template on the Milan Pro Theme.
 *
 * @author Themetry
 * @package Milan
 * @subpackage Customizations
 */

//* Add Featured Content widget area to blog index page
add_action( 'genesis_after_header', 'milan_featured_content' );
function milan_featured_content() {
	if ( is_active_sidebar( 'featured-content' ) && ! is_page() ) {
		echo '<div class="featured-area">';
			dynamic_sidebar( 'featured-content' );
		echo '</div>';
	} elseif ( milan_has_enough_featured_posts() && ! is_active_sidebar( 'featured-content' ) && ! is_page() ) {
		get_template_part( 'template-parts/jetpack-featured' );
	}
}

//* Run the Genesis function
genesis();
