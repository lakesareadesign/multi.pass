<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

add_action( 'wp_head', 'kickstart_front_page_setup' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function kickstart_front_page_setup() {

	if ( is_active_sidebar( 'home-top-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-row1-top' ) || is_active_sidebar( 'home-row1-left' ) || is_active_sidebar( 'home-row1-right' ) || is_active_sidebar( 'home-row2' ) || is_active_sidebar( 'home-row3-left' ) || is_active_sidebar( 'home-top-row3-right1' ) || is_active_sidebar( 'home-top-row3-right2' ) || is_active_sidebar( 'home-row4' ) || is_active_sidebar( 'home-row5' ) || is_active_sidebar( 'home-top-row6' ) || is_active_sidebar( 'home-row7' ) ) {

		// Add front-page body class
		add_filter( 'body_class', 'kickstart_body_class' );
		function kickstart_body_class( $classes ) {
   			$classes[] = 'front-page';

  			return $classes;
		}

		// Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add homepage top area
		add_action( 'genesis_after_header', 'kickstart_homepage_top' );

		// Add homepage content area
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'kickstart_homepage_widgets' );

	}
}

// Setup homepage top area
function kickstart_homepage_top() {
	genesis_widget_area( 'home-top-callout', array(
		'before' => '<div id="home-top-callout" class="home-top-callout widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	if ( is_active_sidebar( 'home-top-slider' ) ) {
		genesis_widget_area( 'home-top-slider', array(
			'before' => '<div id="home-top-slider" class="home-top-slider widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}
	else if ( is_active_sidebar( 'home-top' ) ) {
		echo '<div class="before-content">';
			genesis_widget_area( 'home-top', array(
				'before' => '<div id="home-top" class="home-top widget-area"><div class="wrap">',
				'after'  => '</div></div>',
			) );
		echo '</div>';
	}
}

// Setup homepage content area
function kickstart_homepage_widgets() {

	if ( is_active_sidebar( 'home-top-news' ) ) {
		genesis_widget_area( 'home-top-news', array(
			'before' => '<div id="home-top-news" class="home-top-news home-row widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	if ( is_active_sidebar( 'home-row1-top' ) ||
		 is_active_sidebar( 'home-row1-left' ) ||
		 is_active_sidebar( 'home-row1-right' ) ) {
		echo '<div id="home-row1" class="home-row1 home-row">';
			echo '<div class="wrap">';
				genesis_widget_area( 'home-row1-top', array(
					'before' => '<div id="home-row1-top" class="home-row1-top widget-area"><div class="wrap">',
					'after'  => '</div></div>',
				) );
				genesis_widget_area( 'home-row1-left', array(
					'before' => '<div id="home-row1-left" class="home-row1-left widget-area one-half first"><div class="wrap">',
					'after'  => '</div></div>',
				) );
				genesis_widget_area( 'home-row1-right', array(
					'before' => '<div id="home-row1-right" class="home-row1-right widget-area one-half"><div class="wrap">',
					'after'  => '</div></div>',
				) );
			echo '</div>';
		echo '</div>';
	}

	genesis_widget_area( 'home-row2', array(
		'before' => '<div id="home-row2" class="home-row2 home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	if ( is_active_sidebar( 'home-row3-left' ) ||
		 is_active_sidebar( 'home-row3-right1' ) ||
		 is_active_sidebar( 'home-row3-right2' ) ) {
		echo '<div id="home-row3" class="home-row3 home-row">';
			echo '<div class="wrap">';
				genesis_widget_area( 'home-row3-left', array(
					'before' => '<div id="home-row3-left" class="home-row3-left widget-area one-half first"><div class="wrap">',
					'after'  => '</div></div>',
				) );
				genesis_widget_area( 'home-row3-right1', array(
					'before' => '<div id="home-row3-right1" class="home-row3-right1 widget-area one-fourth"><div class="wrap">',
					'after'  => '</div></div>',
				) );
				genesis_widget_area( 'home-row3-right2', array(
					'before' => '<div id="home-row3-right2" class="home-row3-right2 widget-area one-fourth"><div class="wrap">',
					'after'  => '</div></div>',
				) );
			echo '</div>';
		echo '</div>';
	}

	genesis_widget_area( 'home-row4', array(
		'before' => '<div id="home-row4" class="home-row4 home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-row5', array(
		'before' => '<div id="home-row5" class="home-row5 home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-row6', array(
		'before' => '<div id="home-row6" class="home-row6 home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'lean-newsletter', array(
		'before' => '<div id="lean-newsletter" class="lean-newsletter home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-row7', array(
		'before' => '<div id="home-row7" class="home-row7 home-row widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
