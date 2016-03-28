<?php
/**
 * Interior Pro.
 *
 * This file adds functions to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'interior', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'interior' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Interior Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/interior-pro/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'interior_enqueue_scripts_styles' );
function interior_enqueue_scripts_styles() {

	wp_enqueue_style( 'interior-fonts', '//fonts.googleapis.com/css?family=Open+Sans:700|Lora:400,400italic,700|Homemade+Apple', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'interior-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'interior' ),
		'subMenu'  => __( 'Menu', 'interior' ),
	);
	wp_localize_script( 'interior-responsive-menu', 'InteriorL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 520,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add Image Sizes
add_image_size( 'front-page-sq', 800, 800, TRUE );
add_image_size( 'front-page-rec', 800, 400, TRUE );
add_image_size( 'front-page-lg-rec', 1200, 600, TRUE );

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'interior_remove_genesis_metaboxes' );
function interior_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Remove skip link for primary navigation and add skip link for footer widgets
add_filter( 'genesis_skip_links_output', 'interior_skip_links_output' );
function interior_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'flex-footer' ) ) {
		$new_links['footer'] = __( 'Skip to footer', 'interior' );
	}

	return array_merge( $new_links, $links );

}

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'Header Menu', 'interior' ), 'secondary' => __( 'Footer Menu', 'interior' ) ) );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'interior_secondary_menu_args' );
function interior_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

//* Setup widget counts
function interior_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function interior_widget_area_class( $id ) {

	$count = interior_count_widgets( $id );

	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 1 ) {
		$class .= ' widget-halves uneven';
	} else {	
		$class .= ' widget-halves';
	}

	return $class;

}

//* Reposition Page Title
add_action( 'genesis_meta', 'interior_page_description_meta' );
function interior_page_description_meta() {

	if ( is_singular() && is_page() && !is_page_template() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'genesis_do_post_title', 10 );
	}

}

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 10 );
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
add_action( 'genesis_after_header', 'genesis_do_author_title_description', 10 );

add_action( 'genesis_after_header', 'interior_open_after_header', 5 );
add_action( 'genesis_after_header', 'interior_close_after_header', 15 );

function interior_open_after_header() {
	echo '<div class="after-header dark"><div class="wrap">';
}

function interior_close_after_header() {
	echo '</div></div>';
}

//* Reposition Entry Meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_header', 'genesis_post_meta', 5 );
add_action( 'genesis_entry_footer', 'genesis_post_info' );

//* Customize the entry meta in the entry footer (requires HTML5 theme support)
add_filter( 'genesis_post_meta', 'interior_post_meta_filter' );
function interior_post_meta_filter( $post_meta ) {

	$post_meta = '[post_categories before=""]';

	return $post_meta;

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'interior_content_limit_read_more_markup', 10, 3 );
function interior_content_limit_read_more_markup( $output, $content, $link ) {	

	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Add the footer widget area
add_action( 'genesis_before_footer', 'interior_footer_widgets' );
function interior_footer_widgets() {

	genesis_widget_area( 'before-footer', array(
		'before' => '<div id="before-footer" class="before-footer dark"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Before Footer', 'interior' ) . '</h2><div class="flexible-widgets widget-area ' . interior_widget_area_class( 'before-footer' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'flex-footer', array(
		'before' => '<div id="footer" class="flex-footer footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer', 'interior' ) . '</h2><div class="flexible-widgets widget-area ' . interior_widget_area_class( 'flex-footer' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'interior' ),
	'description' => __( 'This is the front page 1 section.', 'interior' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'interior' ),
	'description' => __( 'This is the front page 2 section.', 'interior' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'interior' ),
	'description' => __( 'This is the front page 3 section.', 'interior' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'interior' ),
	'description' => __( 'This is the before footer section.', 'interior' ),
) );
genesis_register_sidebar( array(
	'id'          => 'flex-footer',
	'name'        => __( 'Footer', 'interior' ),
	'description' => __( 'This is the footer section.', 'interior' ),
) );
