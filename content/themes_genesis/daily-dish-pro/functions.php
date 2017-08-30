<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the functions to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/daily-dish/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'daily_dish_localization_setup' );
function daily_dish_localization_setup(){
	load_child_theme_textdomain( 'daily-dish-pro', get_stylesheet_directory() . '/languages' );
}

// Include helper functions for the Daily Dish Pro theme.
require_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Include WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Include the WooCommerce styles and related Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Daily Dish Pro', 'daily-dish-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/daily-dish/' );
define( 'CHILD_THEME_VERSION', '1.1.2' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'daily_dish_enqueue_scripts_styles' );
function daily_dish_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'daily-dish-google-fonts', '//fonts.googleapis.com/css?family=Alice|Lato:400,700,900', array(), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'daily-dish-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'daily-dish-responsive-menu',
		'genesis_responsive_menu',
		daily_dish_get_responsive_menu_settings()
	);

}

// Responsive menu settings.
function daily_dish_get_responsive_menu_settings() {

	$settings = array(
		'mainMenu' => __( 'Menu', 'daily-dish-pro' ),
		'subMenu'  => __( 'Submenu', 'daily-dish-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-secondary',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background.
add_theme_support( 'custom-background', array(
	'default-attachment' => 'fixed',
	'default-color'      => 'ffffff',
	'default-image'      => get_stylesheet_directory_uri() . '/images/bg.png',
	'default-repeat'     => 'repeat',
	'default-position-x' => 'left',
) );

// Add image sizes.
add_image_size( 'daily-dish-featured', 720, 470, TRUE );
add_image_size( 'daily-dish-archive', 340, 200, TRUE );
add_image_size( 'daily-dish-sidebar', 100, 100, TRUE );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 160,
	'width'           => 800,
) );

// Unregister the header right widget area.
unregister_sidebar( 'header-right' );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'daily_dish_remove_genesis_metaboxes' );
function daily_dish_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Rename Primary and Secondary Menu.
add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Before Header Menu', 'daily-dish-pro' ), 'primary' => __( 'After Header Menu', 'daily-dish-pro' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );

// Hook before header widget area above header.
add_action( 'genesis_before_header', 'daily_dish_before_header', 5 );
function daily_dish_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Open wrap within site-container.
add_action( 'genesis_before_header', 'daily_dish_open_site_container_wrap', 6 );
function daily_dish_open_site_container_wrap() {
	echo '<div class="site-container-wrap">';
}


// Customize the entry meta in the entry header.
add_filter( 'genesis_post_info', 'daily_dish_single_post_info_filter' );
function daily_dish_single_post_info_filter( $post_info ) {

	$post_info = '[post_date] [post_author_posts_link] [post_comments] [post_edit]';

	return $post_info;

}

// Customize the entry meta in the entry footer.
add_filter( 'genesis_post_meta', 'daily_dish_post_meta_filter' );
function daily_dish_post_meta_filter($post_meta) {

	$post_meta = '[post_categories before=""] [post_tags before=""]';

	return $post_meta;

}

// Modify the size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'daily_dish_author_box_gravatar' );
function daily_dish_author_box_gravatar( $size ) {
	return 90;
}

// Modify the size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'daily_dish_comments_gravatar' );
function daily_dish_comments_gravatar( $args ) {

	$args['avatar_size'] = 48;

	return $args;

}

// Hook before footer widget area below footer widgets.
add_action( 'genesis_before_footer', 'daily_dish_before_footer_widgets', 5 );
function daily_dish_before_footer_widgets() {

	genesis_widget_area( 'before-footer-widgets', array(
		'before' => '<div class="before-footer-widgets"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Close wrap within site-container.
add_action( 'genesis_after_footer', 'daily_dish_close_site_container_wrap', 1 );
function daily_dish_close_site_container_wrap() {
	echo '</div>';
}

// Hook after footer widget area below footer.
add_action( 'genesis_after_footer', 'daily_dish_after_footer' );
function daily_dish_after_footer() {

	genesis_widget_area( 'after-footer', array(
		'before' => '<div class="after-footer"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display before the header on every page.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display at the top of the homepage.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display in the middle of the homepage.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display at the bottom of the homepage.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer-widgets',
	'name'        => __( 'Before Footer Widgets', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display before the footer widgets on every page.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-footer',
	'name'        => __( 'After Footer', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display at the bottom of every page.', 'daily-dish-pro' ),
) );
