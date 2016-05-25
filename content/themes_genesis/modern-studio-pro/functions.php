<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'modern-studio', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'modern-studio' ) );

//* Add Accent color to customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Modern Studio Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/modern-studio/' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'ms_scripts_styles' );
function ms_scripts_styles() {

	wp_enqueue_script( 'ms-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'ms-sticky-message', get_stylesheet_directory_uri() . '/js/sticky-message.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic|Montserrat', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background', array(
	'default-attachment' => 'fixed',
	'default-color'      => 'ffffff',
	'default-image'      => get_stylesheet_directory_uri() . '/images/bg.png',
	'default-repeat'     => 'repeat',
	'default-position-x' => 'left',
) );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'default-image'   => get_stylesheet_directory_uri() . '/images/logo.png',
	'width'           => 300,
	'height'          => 300,
	'flex-width'      => false,
	'flex-height'     => false,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Remove the secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Hook sticky message before site header
add_action( 'genesis_before', 'ms_sticky_message' );
function ms_sticky_message() {

	genesis_widget_area( 'sticky-message', array(
		'before' => '<div class="sticky-message">',
		'after'  => '</div>',
	) );

}

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Left Menu', 'modern-studio' ), 'secondary' => __( 'Right Menu', 'modern-studio' ) ) );

//* Hook menus
add_action( 'genesis_after_header', 'ms_menus_container' );
function ms_menus_container() {

	echo '<div class="navigation-container">';
	do_action( 'ms_menus' );
	echo '</div>';
	
}

//* Relocate Primary (Left) Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'ms_menus', 'genesis_do_nav' );

//* Relocate Secondary (Right) Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'ms_menus', 'genesis_do_subnav' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'ms_remove_genesis_metaboxes' );
function ms_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Hook welcome message widget area before content
add_action( 'genesis_before_loop', 'ms_welcome_message' );
function ms_welcome_message() {

	if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'welcome-message', array(
		'before' => '<div class="welcome-message widget-area">',
		'after'  => '</div>',
	) );

}

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'ms_entry_meta_header' );
function ms_entry_meta_header( $post_info ) {

	$post_info = '[post_date format="m.d.Y"] <span class="by">by</span> [post_author_posts_link] // [post_comments] [post_edit]';

	return $post_info;

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'ms_entry_meta_footer' );
function ms_entry_meta_footer( $post_meta ) {

	$post_meta = '[post_categories before="Categories // "] [post_tags before="Tags // "]';

	return $post_meta;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'ms_author_box_gravatar' );
function ms_author_box_gravatar( $size ) {

	return 160;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'ms_comments_gravatar' );
function ms_comments_gravatar( $args ) {

	$args['avatar_size'] = 110;

	return $args;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 5 );
add_action( 'genesis_after', 'genesis_do_footer' );
add_action( 'genesis_after', 'genesis_footer_markup_close', 15 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'sticky-message',
	'name'        => __( 'Sticky Message', 'modern-studio' ),
	'description' => __( 'Widgets in this section will display as a sticky message at the top of pages.', 'modern-studio' ),
) );
genesis_register_sidebar( array(
	'id'          => 'welcome-message',
	'name'        => __( 'Welcome Message', 'modern-studio' ),
	'description' => __( 'Widgets in this section will display above posts at the top of the home page.', 'modern-studio' ),
) );
