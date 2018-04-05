<?php
/**
 * This file adds the home page to Kreativ theme
 */

// Kreativ front page init.
add_action( 'genesis_meta', 'kreativ_front_page_init' );
function kreativ_front_page_init() {
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) || is_active_sidebar( 'front-page-7' ) ) {

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', 'kreativ_home_scripts' );
		function kreativ_home_scripts() {
			wp_enqueue_style( 'kreativ-front-css', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );
			wp_enqueue_script( 'kreativ-front-page', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery' ), CHILD_THEME_VERSION );
		}

		// Enqueue RTL Styles.
		add_action( 'wp_enqueue_scripts', 'kreativ_home_rtl_styles', 12 );
		function kreativ_home_rtl_styles() {
			// Load RTL stylesheet.
			if ( ! is_rtl() ) {
				return;
			}

			wp_enqueue_style( 'kreativ-front-rtl', get_stylesheet_directory_uri() . '/rtl/style-front-rtl.css', array(), CHILD_THEME_VERSION );

		}

		// Add front-page body class.
		add_filter( 'body_class', 'kreativ_body_class' );
		function kreativ_body_class( $classes ) {
			$classes[] = 'front-page';
			return $classes;
		}

		add_filter( 'genesis_site_title_wrap', 'kreativ_h1_for_site_title' );
		/**
		 * Use h1 for site title.
		 */
		function kreativ_h1_for_site_title( $wrap ) {
			return 'h1';
		}

		// Force full width content layout.
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'kreativ_front_page_widgets' );

	}
}

// Add markup for front page widgets.
function kreativ_front_page_widgets() {

	// Front page section 1.
	genesis_widget_area( 'front-page-1', array(
		'before' => '<section id="front-page-1" class="front-page-1"><div class="image-section"><div class="wrap">',
		'after'  => '</div><div class="overlay"></div></div></section>',
	) );

	// Front page section 2.
	genesis_widget_area( 'front-page-2', array(
		'before' => '<section id="front-page-2" class="front-page-2"><div class="solid-section flexible-widgets widget-area' . kreativ_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	// Front page section 3.
	genesis_widget_area( 'front-page-3', array(
		'before' => '<section id="front-page-3" class="front-page-3"><div class="solid-section flexible-widgets widget-area"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	// Front page section 4.
	genesis_widget_area( 'front-page-4', array(
		'before' => '<section id="front-page-4" class="front-page-4"><div class="solid-section flexible-widgets widget-area widget-thirds"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	// Front page section 5.
	genesis_widget_area( 'front-page-5', array(
		'before' => '<section id="front-page-5" class="front-page-5"><div class="solid-section flexible-widgets widget-area widget-thirds"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	// Front page section 6.
	genesis_widget_area( 'front-page-6', array(
		'before' => '<section id="front-page-6" class="front-page-6"><div class="solid-section flexible-widgets widget-area widget-thirds"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

	// Front page section 7.
	genesis_widget_area( 'front-page-7', array(
		'before' => '<section id="front-page-7" class="front-page-7"><div class="solid-section flexible-widgets widget-area"><div class="wrap">',
		'after'  => '</div></div></section>',
	) );

}

// Run the Genesis loop.
genesis();
