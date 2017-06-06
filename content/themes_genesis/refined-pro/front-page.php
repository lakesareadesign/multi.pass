<?php
/**
 * This file adds all the settings for the home page of the Refined theme.
 *
 * @package      Refined
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

add_action( 'genesis_meta', 'refined_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function refined_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {

		add_action( 'wp_enqueue_scripts', 'refined_enqueue_refined_script' );
		/**
		 * Enqueue scripts.
		 *
		 * @since 1.0.0
		 */
		function refined_enqueue_refined_script() {
			wp_enqueue_style( 'refined-front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );
		}

		// Add body class.
		add_filter( 'body_class', 'refined_front_page_body_class' );

		// Force full width content layout.
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add widgets on front page.
		add_action( 'genesis_before_content_sidebar_wrap', 'refined_front_page_widgets' );

		$blog = get_option( 'refined_blog_setting', 'true' );

		if ( $blog === 'true' ) {

			// Add opening markup for blog section.
			add_action( 'genesis_before_content_sidebar_wrap', 'refined_front_page_blog_open' );

			// Add closing markup for blog section.
			add_action( 'genesis_after_content_sidebar_wrap', 'refined_front_page_blog_close' );

			// Force full width content layout.
			add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

			add_filter( 'body_class', 'refined_add_archive_body_class' );
			/**
			 * Add archive body class to the head.
			 *
			 * @since 1.0.0
			 *
			 * @param  array $classes Array of classes to apply.
			 * @return array $classes Updated array of classes.
			 */
			function refined_add_archive_body_class( $classes ) {

				$classes[] = 'refined-blog';
   				return $classes;

			}

			add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'refined_no_post_image' );
			/**
			 * Remove featured image (if set in theme settings).
			 *
			 * @since 1.0.0
			 */
			function refined_no_post_image() {
				return '0';
			}

			add_filter( 'genesis_pre_get_option_content_archive', 'refined_show_excerpts' );
			/**
			 * Show excerpts regardless of theme settings.
			 *
			 * @since 1.0.0
			 */
			function refined_show_excerpts() {
				return 'excerpts';
			}

			add_filter( 'excerpt_length', 'refined_excerpt_length' );
			/**
			 * Modify the length of post excerpts to pull first 50 words.
			 *
			 * @since 1.0.0
			 *
			 * @param  int $length Default number of characters to show in the excerpt.
			 * @return int         New number of characters to show.
			 */
			function refined_excerpt_length( $length ) {
				return 60;
			}

			add_filter('excerpt_more', 'refined_new_excerpt_more');
			/**
			 * Modify the Excerpt read more link.
			 *
			 * @since 1.0.0
			 *
			 * @param  string $more Default read more link HTML.
			 * @return string       New string of HTML to output.
			 */
			function refined_new_excerpt_more( $more ) {
				return '... <br><a class="more-link" href="' . get_permalink() . '">Read More</a>';
			}

			add_filter( 'genesis_pre_get_option_content_archive_limit', 'refined_no_content_limit' );
			/**
			 * Make sure content limit (if set in theme settings) doesn't apply.
			 *
			 * @since 1.0.0
			 */
			function refined_no_content_limit() {
				return '0';
			}

			add_action( 'genesis_entry_header', 'refined_show_featured_image', 8 );
			/**
			 * Display centered wide featured image for first post
			 * and left aligned thumbnail for the next five.
			 *
			 * @since 1.0.0
			 */
			function refined_show_featured_image() {

				if ( ! has_post_thumbnail() ) {
					return;
				}

				global $wp_query;

				if ( $wp_query->current_post <= 0 ) {

					$image_args = array(
						'size' => 'horizontal-entry-image',
						'attr' => array(
							'class' => 'aligncenter',
						),
					);

				} else {

					$image_args = array(
						'size' => 'vertical-entry-image',
						'attr' => array(
							'class' => 'alignleft',
						),
					);

				}

				$image = genesis_get_image( $image_args );

				echo '<div class="home-featured-image"><a href="' . get_permalink() . '">' . $image .'</a></div>';

			}

			// Remove entry meta.
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

		} else {

			// Remove the default Genesis loop.
			remove_action( 'genesis_loop', 'genesis_do_loop' );

		}
	}
}

/**
 * Add body class to the head.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of classes.
 * @return array $classes Updated array of classes.
 */
function refined_front_page_body_class( $classes ) {

	$classes[] = 'front-page';
	return $classes;

}

/**
 * Function to sdd widgets on front page.
 *
 * @since 1.0.0
 */
function refined_front_page_widgets() {

	if ( get_query_var( 'paged' ) >= 2 ) {
		return;
	}

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . refined_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div></div>',
	));

	genesis_widget_area( 'site-wide-cta', array(
		'before' => '<div class="site-wide-cta widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ));

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . refined_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div></div>',
	));

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . refined_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div></div>',
	));

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . refined_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div></div>',
	));

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . refined_widget_area_class( 'front-page-5' ) . '">',
		'after'  => '</div></div></div>',
	));

}

/**
 * Add opening markup for blog section.
 *
 * @since 1.0.0
 */
function refined_front_page_blog_open() {

	$blog_text = get_option( 'refined_blog_text', __( 'the Blog', 'refined' ) );

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '<div class="blog widget-area fadeup-effect"><div class="wrap">';

		if ( ! empty( $blog_text ) ) {

			echo '<h4 class="widgettitle widget-title center">latest from</h4>';
			echo '<h3>' . $blog_text . '</h3>';

		}

	}

}

/**
 * Add closing markup for blog section.
 *
 * @since 1.0.0
 */
function refined_front_page_blog_close() {

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '</div></div>';

	}

}

add_action( 'genesis_after_header', 'refined_home_slider' );
/**
 * Add Home Slider Overlay below Header.
 *
 * @since 1.0.0
 */
function refined_home_slider() {

	if ( ! ( is_home() || is_front_page() ) ) {
		return;
	}

	if ( get_query_var( 'paged' ) >= 2 ) {
		return;
	}

	if ( function_exists( 'soliloquy' ) ) {

		echo '<div class="home-slider-container"><div class="home-slider">';
			soliloquy( 'home-slider', 'slug' );
		echo '</div>';

		genesis_widget_area( 'home-slider-overlay', array(
			'before'	=> '<div class="home-slider-overlay widget-area"><div class="wrap">',
			'after'		=> '</div></div></div>',
		));
	}
}

// Run Genesis.
genesis();
