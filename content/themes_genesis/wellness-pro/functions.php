<?php
/**
 * Wellness Pro.
 *
 * This file adds functions to the Wellness Pro Theme.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'wellness_localization_setup' );
function wellness_localization_setup(){
	load_child_theme_textdomain( 'wellness-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme's helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add the required WooCommerce setup functions.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the Customizer CSS for the WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Wellness Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/wellness-pro/' );
define( 'CHILD_THEME_VERSION', '1.1.2' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'wellness_enqueue_scripts_styles' );
function wellness_enqueue_scripts_styles() {

	wp_enqueue_style( 'wellness-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700|Arbutus+Slab', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'wellness-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'wellness-responsive-menu',
		'genesis_responsive_menu',
		wellness_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function wellness_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'wellness-pro' ),
		'subMenu'     => __( 'Submenu', 'wellness-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-header',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add Image Sizes.
add_image_size( 'author-pro-image', 640, 640, TRUE );
add_image_size( 'featured-image', 640, 640, TRUE );
add_image_size( 'featured-image-large', 1000, 1000, TRUE );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'wellness_remove_genesis_metaboxes' );
function wellness_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Remove skip link for primary navigation and add skip link for footer widgets.
add_filter( 'genesis_skip_links_output', 'wellness_skip_links_output' );
function wellness_skip_links_output( $links ) {

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'flex-footer' ) ) {
		$new_links['footer'] = __( 'Skip to footer', 'wellness-pro' );
	}

	return array_merge( $new_links, $links );

}

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'wellness-pro' ), 'secondary' => __( 'Footer Menu', 'wellness-pro' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'wellness_secondary_menu_args' );
function wellness_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Add featured image on single post.
add_action( 'genesis_entry_content', 'wellness_featured_image', 1 );
function wellness_featured_image() {

	$add_single_image = get_theme_mod( 'wellness_single_image_setting', true );

	$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => 'featured-image-large',
			'context' => '',
			'attr'    => array ( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'aligncenter' ),
		) );

	if ( is_singular() && ( true === $add_single_image ) ) {
		if ( $image ) {
			printf( '<div class="featured-image">%s</div>', $image );
		}
	}

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'wellness_author_box_gravatar' );
function wellness_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'wellness_comments_gravatar' );
function wellness_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Setup widget counts.
function wellness_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Set the widget class for flexible widgets.
function wellness_widget_area_class( $id ) {

	$count = wellness_count_widgets( $id );

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

// Add the before footer widget area.
add_action( 'genesis_before_footer', 'wellness_before_footer_widget' );
function wellness_before_footer_widget() {

	genesis_widget_area( 'before-footer', array(
		'before' => '<div id="before-footer" class="before-footer"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Before Footer', 'wellness-pro' ) . '</h2><div class="flexible-widgets widget-area ' . wellness_widget_area_class( 'before-footer' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Add the flexible footer widget area.
add_action( 'genesis_before_footer', 'wellness_footer_widgets' );
function wellness_footer_widgets() {

	genesis_widget_area( 'flex-footer', array(
		'before' => '<div id="footer" class="flex-footer footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer', 'wellness-pro' ) . '</h2><div class="flexible-widgets widget-area ' . wellness_widget_area_class( 'flex-footer' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'sticky-message',
	'name'        => __( 'Sticky Message', 'wellness-pro' ),
	'description' => __( 'This is the sticky message section that appears on the front page.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'wellness-pro' ),
	'description' => __( 'This is the front page 1 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'wellness-pro' ),
	'description' => __( 'This is the front page 2 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'wellness-pro' ),
	'description' => __( 'This is the front page 3 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'wellness-pro' ),
	'description' => __( 'This is the front page 4 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'wellness-pro' ),
	'description' => __( 'This is the front page 5 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'wellness-pro' ),
	'description' => __( 'This is the front page 6 section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'wellness-pro' ),
	'description' => __( 'This is the before footer section.', 'wellness-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'flex-footer',
	'name'        => __( 'Footer', 'wellness-pro' ),
	'description' => __( 'This is the footer section.', 'wellness-pro' ),
) );
