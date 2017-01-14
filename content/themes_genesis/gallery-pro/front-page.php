<?php
/**
 * Add front page widget areas to the Front Page
 *
 */
add_action( 'genesis_meta', 'bbs_front_page_genesis_meta' );
function bbs_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {

		//* Add front-page body class
		add_filter( 'body_class', 'bbs_front_page_body_class' );
		function bbs_front_page_body_class( $classes ) {

			$classes[] = 'bbs-front-page';
			return $classes;

		}

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Add widgets to the front page
		add_action( 'genesis_after_header', 'bbs_front_page_widgets_1' );

		$blog = get_option( 'bbs_front_page_blog_setting', 'true' );

		if ( $blog === 'true' ) {

			//* Add opening markup for blog section
			add_action( 'genesis_before_loop', 'bbs_front_page_blog_open' );

			//* Add closing markup for blog section
			add_action( 'genesis_after_loop', 'bbs_front_page_blog_close' );

		} else {

			//* Remove the default Genesis loop
			remove_action( 'genesis_loop', 'genesis_do_loop' );

			//* Force full-width-content layout
			add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

			//* Remove .site-inner
			add_filter( 'genesis_markup_site-inner', '__return_null' );
			add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
			add_filter( 'genesis_markup_content', '__return_null' );

		}

		//* Add remaining widgets to front page
		add_action( 'genesis_before_footer', 'bbs_front_page_widgets_2', 8 );

	}

}

//* Add widgets to the front page
function bbs_front_page_widgets_1() {

	if ( get_query_var( 'paged' ) >= 2 )
		return;

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'bbs' ) . '</h2>';

	$front_page_image_1 = get_option( 'bbs_front_page_image_1', sprintf( '%s/images/front-page-image-1.jpg', get_stylesheet_directory_uri() ) );
	$front_page_image_2 = get_option( 'bbs_front_page_image_2', sprintf( '%s/images/front-page-image-2.jpg', get_stylesheet_directory_uri() ) );

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1 flexible-widget-area bg bg-scrim" style="background-image: url(' . $front_page_image_1 . ')"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . bbs_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 flexible-widget-area bg bg-scrim" style="background-image: url(' . $front_page_image_2 . ')"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . bbs_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div></div>',
	) );

}

//* Add remaining widget to front page
function bbs_front_page_widgets_2() {

	if ( get_query_var( 'paged' ) >= 2 )
		return;

	$front_page_image_3 = get_option( 'bbs_front_page_image_3', sprintf( '%s/images/front-page-image-3.jpg', get_stylesheet_directory_uri() ) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5 hero flexible-widget-area bg bg-scrim" style="background-image: url(' . $front_page_image_3 . ')"><div class="wrap"><div class="flexible-widgets widget-area' . bbs_widget_area_class( 'front-page-5' ) . '">',
		'after'  => '</div></div></div>',
	) );

}

//* Add opening markup for blog section
function bbs_front_page_blog_open() {

	$blog_title = get_option( 'bbs_blog_title', __( 'Recent Posts', 'bbs' ) );

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '<div class="front-page-blog widget-area">';

		if ( ! empty( $blog_title ) ) {

			echo '<h2 class="widgettitle widget-title">' . $blog_title . '</h2>';

		}

	}

}

//* Add closing markup for blog section
function bbs_front_page_blog_close() {

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '</div>';

	}

}

genesis();
