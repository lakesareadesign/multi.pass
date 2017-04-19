<?php
/**
 * Showcase Pro
 *
 * This file adds the front page to the Showcase Pro Theme.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */

// Add widget support for front page
add_action( 'genesis_meta', 'showcase_front_page_genesis_meta' );
function showcase_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4') || is_active_sidebar( 'front-page-5') ) {

		// Add front-page body class
		add_filter( 'body_class', 'showcase_body_class' );
		function showcase_body_class( $classes ) {

			$classes[] = 'front-page';

			if ( is_active_sidebar( 'front-page-1' ) ) {
				$classes[] .= 'with-page-header';
			}

			return $classes;

		}

		// Force full width content layout
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Add widgets on front page
		add_action( 'genesis_before_content_sidebar_wrap', 'showcase_front_page_widgets', 15 );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Remove .site-inner
		add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

	}

}

// Add widgets on front page
function showcase_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'showcase' ) . '</h2>';

	if ( is_active_sidebar( 'front-page-1' ) ) {

		$image = get_option( 'showcase-page-header-image', sprintf( '%s/images/page-header.jpg', get_stylesheet_directory_uri() ) );
		$background_image = 'style="background-image: url(' . $image . ')"';
		$background_image_class = $image ? 'with-background-image' : '';

		?>

		<div id="front-page-1" class="front-page-1 page-header bg-primary <?php echo $background_image_class; ?>" <?php echo $background_image; ?>>
			<div class="wrap">
				<?php

					genesis_widget_area( 'front-page-1', array(
						'before' => '<div id="front-page-1" class="front-page-1 widget-area">',
						'after'  => '</div>',
					) );

				?>
			</div>
		</div>

		<?php

	}

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_halves_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4 bg-primary flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5 flexible-widget-area"><div class="wrap"><div class="widget-area">',
		'after'  => '</div></div></div>',
	) );

}

genesis();
