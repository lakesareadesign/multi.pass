<?php
/* ==========================================================================
 * Theme Setup
 * ========================================================================== */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Page Header
include_once( get_stylesheet_directory() . '/lib/page-header.php' );

//* Testimonials
include_once( get_stylesheet_directory() . '/lib/testimonials.php' );
include_once( get_stylesheet_directory() . '/lib/widget-testimonials.php' );

//* Team
include_once( get_stylesheet_directory() . '/lib/team.php' );
include_once( get_stylesheet_directory() . '/lib/widget-team.php' );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Showcase Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/showcase/' );
define( 'CHILD_THEME_VERSION', '1.0.2' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'showcase_scripts_styles' );
function showcase_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Hind:400,300,500,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'showcase-fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array(), CHILD_THEME_VERSION );
    wp_enqueue_script( 'showcase-global', get_stylesheet_directory_uri() . '/js/global.js', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'showcase-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array(), CHILD_THEME_VERSION );

	if ( is_front_page() ) {
		wp_enqueue_style( 'bxslider', get_stylesheet_directory_uri() . '/css/bxslider.css' );
		wp_enqueue_script( 'showcase-bxslider', get_stylesheet_directory_uri() . '/js/jquery.bxslider.min.js', array(), CHILD_THEME_VERSION );
	}

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Add screen reader class to archive description
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

/* ==========================================================================
 * Header
 * ========================================================================== */

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 400,
	'height'          => 150,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Assign the correct class for white or transparent header
$header_color = get_option( 'showcase_header_color', 'true' );
if ( $header_color === 'white' ) {

	add_filter( 'body_class', 'showcase_header_color_class' );
	function showcase_header_color_class( $classes ) {

		$classes[] = 'white-header';
		return $classes;

	}
}

//* Add Image Sizes
add_image_size( 'showcase_featured_posts', 600, 400, TRUE );
add_image_size( 'showcase_archive', 900, 500, TRUE );
add_image_size( 'showcase_team_thumb', 600, 800, TRUE );
add_image_size( 'showcase_hero', 1920, 960, TRUE );


/* ==========================================================================
 * Navigation
 * ========================================================================== */

//* Rename primary and secondary navigation menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'Header Menu', 'showcase' ), 'secondary' => __( 'Page Header Menu', 'showcase' ) ) );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove secondary navigation menu, it's added back in the /lib/page-header.php
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Reduce secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'showcase_secondary_menu_args' );
function showcase_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'showcase_remove_genesis_metaboxes' );
function showcase_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

/* ==========================================================================
 * Widget Areas
 * ========================================================================== */

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for shortcodes in widget areas
add_filter('widget_text', 'do_shortcode');

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Setup widget counts
function showcase_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function showcase_widget_area_class( $id ) {

	$count = showcase_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves even';
	}
	return $class;

}

//* Flexible widget classes
function showcase_halves_widget_area_class( $id ) {

	$count = showcase_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-hero',
	'name'        => __( 'Front Page Hero', 'showcase' ),
	'description' => __( 'This is the page header section on the front page.', 'showcase' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'showcase' ),
	'description' => __( 'This is the 1st section on the front page.', 'showcase' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'showcase' ),
	'description' => __( 'This is the 2nd section on the front page.', 'showcase' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'showcase' ),
	'description' => __( 'This is the 3rd section on the front page.', 'showcase' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'showcase' ),
	'description' => __( 'This is the 4th section on the front page.', 'showcase' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'showcase' ),
	'description' => __( 'This is a widget area right before the footer on every page.', 'showcase' ),
) );

//* Add the Before Footer Widget Area
add_action( 'genesis_before_footer', 'showcase_before_footer_widget_area', 5 );
function showcase_before_footer_widget_area() {
	if ( is_active_sidebar( 'before-footer' ) ) {
		genesis_widget_area( 'before-footer', array(
			'before' => '<div id="before-footer" class="before-footer"><div class="wrap"><div class="widget-area' . showcase_widget_area_class( 'before-footer' ) . '">',
			'after'  => '</div></div></div>',
		) );
	}
}

//* Add support for 4-column footer widget
add_theme_support( 'genesis-footer-widgets', 4 );


/* ==========================================================================
 * Blog Related
 * ========================================================================== */

//* Reposition entry meta in entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'showcase_entry_meta_header' );
function showcase_entry_meta_header($post_info) {

	$post_info = '[post_categories before="" after=" &middot;"] [post_date] [post_edit before=" &middot; "]';
	return $post_info;

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'showcase_content_limit_read_more_markup', 10, 3 );
function showcase_content_limit_read_more_markup( $output, $content, $link ) {

	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'showcase_read_more_link' );
function showcase_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

//* Customize author box title
add_filter( 'genesis_author_box_title', 'showcase_author_box_title' );
function showcase_author_box_title() {

	return '<span itemprop="name">' . get_the_author() . '</span>';

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'showcase_author_box_gravatar' );
function showcase_author_box_gravatar( $size ) {

	return 160;

}

//* Remove entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'showcase_remove_entry_footer' );
function showcase_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );


/* ==========================================================================
 * Helper Functions
 * ========================================================================== */

/**
 * Bar to Line Break
 *
 */
function showcase_bar_to_br( $content ) {
	return str_replace( ' | ', '<br class="mobile-hide">', $content );
}