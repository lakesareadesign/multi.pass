<?php
/* ==========================================================================
 * Theme Setup
 * ========================================================================== */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Maker Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/maker/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'maker_scripts_styles' );
function maker_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Martel:200,700,900|Roboto+Condensed:700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'maker-fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array(), CHILD_THEME_VERSION );
  wp_enqueue_script( 'maker-global', get_stylesheet_directory_uri() . '/js/global.js', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'maker-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array(), CHILD_THEME_VERSION );

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

//* Add Image Sizes
add_image_size( 'maker_archive', 800, 500, TRUE );
add_image_size( 'maker_wide', 1600, 600, TRUE );

//* Overide Genesis Portfolio Pro featured Image
add_image_size( 'portfolio', 800, 600, TRUE );


/* ==========================================================================
 * Navigation
 * ========================================================================== */

//* Rename primary and secondary navigation menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'Header Menu', 'maker' ) ) );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'maker_remove_genesis_metaboxes' );
function maker_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}


/* ==========================================================================
 * Widget Areas
 * ========================================================================== */

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );

//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Setup widget counts
function maker_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function maker_widget_area_class( $id ) {

	$count = maker_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves even';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

//* Flexible widget classes
function maker_halves_widget_area_class( $id ) {

	$count = maker_count_widgets( $id );

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
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1: Thin Width', 'maker' ),
	'description' => __( 'This is the 1st section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2: Full Width', 'maker' ),
	'description' => __( 'This is the 2nd section on the front page. It is full width but will respond to the number of widgets inside.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3: Thin Width', 'maker' ),
	'description' => __( 'This is the 3rd section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'maker' ),
	'description' => __( 'This is the 4th section on the front page. It has the default width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5: Full Width', 'maker' ),
	'description' => __( 'This is the 5th section on the front page. It is full width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6: Left Aligned Titles', 'maker' ),
	'description' => __( 'This is the 6th section on the front page. It is the default width and puts the widget titles to the left of the content.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'maker' ),
	'description' => __( 'This is the 7th section on the front page. It is the default width and responds to the number of widgets in it.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-8',
	'name'        => __( 'Front Page 8', 'maker' ),
	'description' => __( 'This is the 8th section on the front page. It is the default width and responds to the number of widgets in it.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-9',
	'name'        => __( 'Front Page 9: Thin Width', 'maker' ),
	'description' => __( 'This is the 9th section on the front page. It has a thinner width.', 'maker' )
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-10',
	'name'        => __( 'Front Page 10: Full Width', 'maker' ),
	'description' => __( 'This is the 10th section on the front page. It is full width.', 'maker' )
) );

//* Add support for 4-column footer widget
add_theme_support( 'genesis-footer-widgets', 5 );


/* ==========================================================================
 * Blog Related
 * ========================================================================== */

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'maker_entry_meta_header' );
function maker_entry_meta_header($post_info) {

	$post_info = '[post_categories before="" after=" &middot;"] [post_date] [post_edit before=" &middot; "]';
	return $post_info;

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'maker_content_limit_read_more_markup', 10, 3 );
function maker_content_limit_read_more_markup( $output, $content, $link ) {

	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'maker_read_more_link' );
function maker_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

//* Customize author box title
add_filter( 'genesis_author_box_title', 'maker_author_box_title' );
function maker_author_box_title() {

	return '<span itemprop="name">' . get_the_author() . '</span>';

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'maker_author_box_gravatar' );
function maker_author_box_gravatar( $size ) {

	return 160;

}

//* Remove entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'maker_remove_entry_footer' );
function maker_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Display author box on archive pages
add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );
