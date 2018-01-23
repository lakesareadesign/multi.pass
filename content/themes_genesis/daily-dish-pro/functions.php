<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the functions to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
 */

// Start the engine.
include_once get_template_directory() . '/lib/init.php';

// Setup Theme.
include_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'daily_dish_localization_setup' );
/**
 * Set Localization (do not remove).
 *
 * @since 1.0.0
 */
function daily_dish_localization_setup() {
	load_child_theme_textdomain( 'daily-dish-pro', get_stylesheet_directory() . '/languages' );
}

// Include helper functions for the Daily Dish Pro theme.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Add Color select to WordPress Theme Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Include Customizer CSS.
include_once get_stylesheet_directory() . '/lib/output.php';

// Include WooCommerce support.
include_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Include the WooCommerce styles and related Customizer CSS.
include_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Include the Genesis Connect WooCommerce notice.
include_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Daily Dish Pro', 'daily-dish-pro' ) );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/daily-dish/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

add_action( 'wp_enqueue_scripts', 'daily_dish_enqueue_scripts_styles' );
/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function daily_dish_enqueue_scripts_styles() {

	wp_enqueue_style( 'daily-dish-google-fonts', '//fonts.googleapis.com/css?family=Cormorant:400,400i,700,700i|Poppins:300,400,500,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'daily-dish-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'daily-dish-global-script', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'daily-dish-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'daily-dish-responsive-menu',
		'genesis_responsive_menu',
		daily_dish_get_responsive_menu_settings()
	);

}

/**
 * Responsive menu settings.
 *
 * @since 1.0.0
 *
 * @return array The menu settings.
 */
function daily_dish_get_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'daily-dish-pro' ),
		'menuIconClass'    => 'ionicon-before ion-android-menu',
		'subMenu'          => __( 'Submenu', 'daily-dish-pro' ),
		'subMenuIconClass' => 'ionicon-before ion-android-arrow-dropdown',
		'menuClasses'      => array(
			'combine'      => array(
				'.nav-secondary',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background.
add_theme_support( 'custom-background', array(
	'default-attachment' => 'fixed',
	'default-color'      => 'f5f5f5',
	'default-image'      => get_stylesheet_directory_uri() . '/images/bg.png',
	'default-repeat'     => 'repeat',
	'default-position-x' => 'left',
) );

// Add image sizes.
add_image_size( 'daily-dish-featured', 720, 470, true );
add_image_size( 'daily-dish-archive', 340, 200, true );
add_image_size( 'daily-dish-sidebar', 100, 100, true );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 160,
	'width'           => 800,
) );

// Unregister header right widget area.
unregister_sidebar( 'header-right' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

add_action( 'genesis_theme_settings_metaboxes', 'daily_dish_remove_genesis_metaboxes' );
/**
 * Remove navigation meta box.
 *
 * @since 1.0.0
 *
 * @param string $_genesis_theme_settings_pagehook The name of the page hook when the menu is registered.
 */
function daily_dish_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

// Rename Primary and Secondary Menu.
add_theme_support( 'genesis-menus', array(
	'secondary' => __( 'Before Header Menu', 'daily-dish-pro' ),
	'primary'   => __( 'After Header Menu', 'daily-dish-pro' ),
) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_meta', 'daily_dish_add_search_icon' );
/**
 * Add the search icon to header if option is set in Customizer.
 *
 * @since 1.0.0
 */
function daily_dish_add_search_icon() {

	$show_icon = get_theme_mod( 'daily_dish_header_search', daily_dish_customizer_get_default_search_setting() );

	// Exit early if option set to false.
	if ( ! $show_icon ) {
		return;
	}

	add_action( 'genesis_after_header', 'daily_dish_do_header_search_form', 14 );
	add_filter( 'genesis_nav_items', 'daily_dish_add_search_menu_item', 10, 2 );
	add_filter( 'wp_nav_menu_items', 'daily_dish_add_search_menu_item', 10, 2 );

}

/**
 * Modify Header Menu items.
 *
 * @param string $items Menu items.
 * @param array  $args Menu arguments.
 * @since 2.0.0
 *
 * @return string The modified menu.
 */
function daily_dish_add_search_menu_item( $items, $args ) {

	$search_toggle = sprintf( '<li class="menu-item">%s</li>', daily_dish_get_header_search_toggle() );

	if ( 'primary' === $args->theme_location ) {
		$items .= $search_toggle;
	}

	return $items;

}

add_action( 'genesis_after_header', 'daily_dish_menu_open', 5 );
/**
 * Open markup for menu wrap.
 *
 * @since 2.0.0
 */
function daily_dish_menu_open() {

	echo '<div class="menu-wrap">';

}

add_action( 'genesis_after_header', 'daily_dish_menu_close', 15 );
/**
 * Close markup for menu wrap.
 *
 * @since 2.0.0
 */
function daily_dish_menu_close() {

	echo '</div>';

}

// Reposition secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' );


add_action( 'genesis_before', 'daily_dish_before_header' );
/**
 * Hook before header widget area before site container.
 *
 * @since 1.0.0
 */
function daily_dish_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

add_filter( 'genesis_post_info', 'daily_dish_single_post_info_filter' );
/**
 * Customize entry meta in entry header.
 *
 * @param string $post_info The entry meta.
 * @since 1.0.0
 *
 * @return string Modified entry meta.
 */
function daily_dish_single_post_info_filter( $post_info ) {

	$post_info = '[post_author_posts_link] &middot; [post_date] &middot; [post_comments] [post_edit]';

	return $post_info;

}

add_filter( 'genesis_author_box_gravatar_size', 'daily_dish_author_box_gravatar' );
/**
 * Modify size of the Gravatar in author box.
 *
 * @param int $size Current size.
 * @since 1.0.0
 *
 * @return int Modified size.
 */
function daily_dish_author_box_gravatar( $size ) {

	return 85;

}

add_filter( 'genesis_comment_list_args', 'daily_dish_comments_gravatar' );
/**
 * Modify size of the Gravatar in entry comments.
 *
 * @param array $args The avatar arguments.
 *
 * @return mixed Modified avatar arguments.
 */
function daily_dish_comments_gravatar( $args ) {

	$args['avatar_size'] = 48;

	return $args;

}

add_action( 'genesis_before_footer', 'daily_dish_before_footer_widgets', 5 );
/**
 * Hook before footer widget area above footer.
 *
 * @since 1.0.0
 */
function daily_dish_before_footer_widgets() {

	genesis_widget_area( 'before-footer-widgets', array(
		'before' => '<div class="before-footer-widgets"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

add_action( 'genesis_after', 'daily_dish_after_footer' );
/**
 * Hook after footer widget after site container.
 *
 * @since 1.0.0
 */
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
	'name'        => __( 'Before Footer', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display before the footer widgets on every page.', 'daily-dish-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-footer',
	'name'        => __( 'After Footer', 'daily-dish-pro' ),
	'description' => __( 'Widgets in this section will display at the bottom of every page.', 'daily-dish-pro' ),
) );
