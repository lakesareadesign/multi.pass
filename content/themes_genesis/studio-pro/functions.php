<?php
/**
 * Studio Pro.
 *
 * This file adds the default functionality to the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// Start the engine (do not remove).
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'studio-pro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'studio-pro' ) );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'studio-pro' );
define( 'CHILD_THEME_URL', 'http://www.seothemes.com/' );
define( 'CHILD_THEME_VERSION', '2.1.3' );

// Enable responsive viewport.
add_theme_support( 'genesis-responsive-viewport' );

// Enable automatic output of WordPress title tags.
add_theme_support( 'title-tag' );

// Enable selective refresh and Customizer edit icons.
add_theme_support( 'customize-selective-refresh-widgets' );

// Enable WooCommerce support.
add_theme_support( 'woocommerce' );

// Enable HTML5 markup structure.
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form',
) );

// Enable Accessibility support.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus' , array(
	'primary' => __( 'Header Menu', 'studio-pro' ),
) );

// Enable menu wrap only, using custom wraps for everything else.
add_theme_support( 'genesis-structural-wraps', array(
	'menu-primary',
	'footer-widgets',
	'footer',
) );

// Enable support for Genesis footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Enable support for front page widgets.
add_theme_support( 'front-page-widgets', 6 );

// Enable Logo option in Customizer > Site Identity.
add_theme_support( 'custom-logo', array(
	'height'      => 60,
	'width'       => 200,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Enable theme support for custom header background image.
add_theme_support( 'custom-header', array(
	'header-selector'  => '.hero',
	'header_image'     => get_stylesheet_directory_uri() . '/assets/images/hero.jpg',
	'header-text'      => false,
	'width'            => 1920,
	'height'           => 1080,
	'flex-height'      => true,
	'flex-width'       => true,
	'video'            => true,
) );

// Register default custom header image.
register_default_headers( array(
	'child' => array(
		'url'           => '%2$s/assets/images/hero.jpg',
		'thumbnail_url' => '%2$s/assets/images/hero.jpg',
		'description'   => __( 'Hero Image', 'studio-pro' ),
	),
) );

// Register front page widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'studio-pro' ),
	'description' => __( 'Front page 1 widget area.', 'studio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'studio-pro' ),
	'description' => __( 'Front page 2 widget area.', 'studio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'studio-pro' ),
	'description' => __( 'Front page 3 widget area.', 'studio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'studio-pro' ),
	'description' => __( 'Front page 4 widget area.', 'studio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'studio-pro' ),
	'description' => __( 'Front page 5 widget area.', 'studio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'studio-pro' ),
	'description' => __( 'Front page 6 widget area.', 'studio-pro' ),
) );

// Register before header widget area.
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'studio-pro' ),
	'description' => __( 'This is the before header section.', 'studio-pro' ),
) );

// Register before footer widget area.
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'studio-pro' ),
	'description' => __( 'This is the before footer section.', 'studio-pro' ),
) );

/**
 * Display before-header widget area.
 */
function studio_before_header_widget_area() {

	genesis_widget_area( 'before-header', array(
	    'before' => '<div class="before-header"><div class="wrap">',
	    'after'	 => '</div></div>',
	) );
}
add_action( 'genesis_header', 'studio_before_header_widget_area', 5 );

/**
 * Display before-footer widget area.
 */
function studio_before_footer_widget_area() {

	genesis_widget_area( 'before-footer', array(
	    'before' => '<div class="before-footer overlay">' . studio_custom_header_markup(),
	    'after'  => '</div>',
	) );
}
add_action( 'genesis_before_footer', 'studio_before_footer_widget_area', 5 );

// Enable support for portfolio custom headers.
add_post_type_support( 'portfolio', 'custom-header' );

// Enable shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Custom structural wraps.
add_action( 'genesis_header', 'studio_wrap_open', 6 );
add_action( 'genesis_header', 'studio_wrap_close', 13 );
add_action( 'genesis_content', 'studio_wrap_open', 6 );
add_action( 'genesis_content', 'studio_wrap_close', 13 );
add_action( 'genesis_before_content_sidebar_wrap', 'studio_wrap_open', 6 );
add_action( 'genesis_after_content_sidebar_wrap', 'studio_wrap_close', 13 );

// Remove unused templates and metaboxes.
add_filter( 'theme_page_templates', 'studio_remove_templates' );
add_action( 'genesis_admin_before_metaboxes', 'studio_remove_metaboxes' );

// Change order of main stylesheet to override plugin styles.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 99 );

// Display custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Remove content-sidebar-wrap.
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

// Add `ontouchstart` to body element.
add_filter( 'genesis_attr_body', 'studio_add_ontouchstart' );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Remove featured image from content.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'studio_featured_image' );

// Reposition comments.
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );
add_action( 'genesis_entry_footer', 'genesis_get_comments_template', 1 );
add_action( 'genesis_entry_footer', 'genesis_get_comments_template', 1 );

// Modify breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs', 5 );
add_filter( 'genesis_breadcrumb_args', 'studio_breadcrumb_args' );

// Accessible read more links.
add_filter( 'excerpt_more', 'studio_read_more' );
add_filter( 'the_content_more_link', 'studio_read_more' );
add_filter( 'get_the_content_more_link', 'studio_read_more' );

// Modify site header schema microdata.
add_filter( 'genesis_attr_title-area', 'studio_title_area' );
add_filter( 'genesis_attr_site-title', 'studio_site_title' );

// Add prev/next links to portfolio.
add_action( 'genesis_after_content_sidebar_wrap',   'studio_prev_next_post_nav_cpt', 999 );

// Modify footer credits.
add_filter( 'genesis_footer_creds_text', 'studio_footer_creds_filter' );

// Fix Simple Social Icons styles PIA.
add_action( 'wp_head', 'studio_simple_social_icons_css' );
add_action( 'wp_head', 'studio_remove_ssi_inline_styles', 1 );

/**
 * Enqueue scripts and styles.
 */
function studio_enqueue_scripts_styles() {

	// Google fonts.
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Muli:400,700|Montserrat:700', array(), CHILD_THEME_VERSION );

	// Enqueue scripts.
	wp_enqueue_script( 'studio-pro', get_stylesheet_directory_uri() . '/assets/scripts/min/studio-pro.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Remove sub-menu animation and delay.
	wp_deregister_script( 'superfish-args' );
	wp_dequeue_script( 'superfish-args' );

	// Remove Simple Social Icons stylesheet.
	wp_deregister_style( 'simple-social-icons-font' );
	wp_dequeue_style( 'simple-social-icons-font' );

	// Localize responsive menus script.
	wp_localize_script( 'studio-pro', 'genesis_responsive_menu', array(
		'mainMenu'         => __( 'Menu', 'studio-pro' ),
		'subMenu'          => __( 'Menu', 'studio-pro' ),
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
		),
	) );

}
add_action( 'wp_enqueue_scripts', 'studio_enqueue_scripts_styles', 99 );

// Load theme defaults, in order of front-end importance.
include_once( get_stylesheet_directory() . '/includes/helpers.php' );
include_once( get_stylesheet_directory() . '/includes/hero.php' );
include_once( get_stylesheet_directory() . '/includes/defaults.php' );
include_once( get_stylesheet_directory() . '/includes/plugins.php' );
include_once( get_stylesheet_directory() . '/includes/customize.php' );
include_once( get_stylesheet_directory() . '/includes/output.php' );
