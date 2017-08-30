<?php
/**
 * Boss Pro
 *
 * This file adds functions to the Boss Pro Theme.
 *
 * @package Boss
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/boss/
 */

// Start the engine.
require_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Boss Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/boss/' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'boss_localization_setup' );
function boss_localization_setup(){
	load_child_theme_textdomain( 'boss-pro', get_stylesheet_directory() . '/languages' );
}

// Set up Theme Customizer.
require_once( get_stylesheet_directory() . '/inc/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/inc/output.php' );

// Entry Grid Shortcode.
include_once( get_stylesheet_directory() . '/inc/entry-grid-shortcode.php' );

// Add the required WooCommerce functions.
include_once( get_stylesheet_directory() . '/inc/woocommerce/woocommerce-setup.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/inc/woocommerce/woocommerce-notice.php' );

// Enable shortcodes in text widgets.
add_filter('widget_text','do_shortcode');

add_action( 'wp_enqueue_scripts', 'boss_scripts_styles' );
/**
 * Global Enqueues.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Playfair+Display:400,400i|Raleway:500,700|Roboto+Condensed:300,400', CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', CHILD_THEME_VERSION );

    wp_enqueue_script( 'boss-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', time() );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'boss-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, time() );
	wp_localize_script(
		'boss-responsive-menu',
		'genesis_responsive_menu',
		boss_responsive_menu_settings()
	);

}

/**
 * Responsive Menu Settings.
 *
 * @return array $settings
 *
 * @since 1.0.0
 */
function boss_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'boss-pro' ),
		'menuIconClass'    => 'ion ion-android-menu',
		'subMenu'          => __( 'Menu', 'boss-pro' ),
		'subMenuIconClass' => 'ion ion-chevron-left',
		'menuClasses'      => array(
			'others' => array(
				'.nav-primary',
			),
		),
	);

	return $settings;

}

add_filter( 'genesis_theme_settings_defaults', 'boss_theme_defaults' );
/**
 * Theme Setting Defaults.
 *
 * @param array $defaults
 * @return array $defaults
 *
 * @since 1.0.0
 */
function boss_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['image_size']                = 'boss_archive';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'boss_theme_setting_defaults' );
/**
 * After switching theme defaults.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,
			'content_archive'           => 'full',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'boss_archive',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 3 );

}

add_filter( 'simple_social_default_styles', 'boss_social_default_styles' );
/**
 * Simple Social Icon Defaults.
 *
 * @param array $defaults
 * @return array $args
 *
 * @since 1.0.0
 */
function boss_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#1a1a1a',
		'background_color_hover' => '#1a1a1a',
		'border_color'           => '#1a1a1a',
		'border_color_hover'     => '#1a1a1a',
		'border_radius'          => 48,
		'border_width'           => 0,
		'icon_color'             => '#999999',
		'icon_color_hover'       => '#aaaaaa',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

// Add Structural Wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'site-inner',
	'footer-widgets',
	'footer'
) );

// Add screen reader class to archive description.
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 400,
	'height'          => 150,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add Image Sizes.
add_image_size( 'boss_featured_posts', 600, 700, TRUE );
add_image_size( 'boss_archive', 900, 500, TRUE );
add_image_size( 'boss_entry_grid', 600, 800, TRUE );
add_image_size( 'boss_hero', 1200, 800, TRUE );
add_image_size( 'gts-thumbnail', 700, 700, true );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus' , array(
	'primary' => __( 'Header Menu', 'boss-pro' )
) );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'boss_remove_genesis_metaboxes' );
/**
 * Remove navigation settings metabox.
 *
 * @param mixed string|array|WP_Screen
 * @return void
 *
 * @since 1.0.0
 */
function boss_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Add support for shortcodes in widget areas.
add_filter('widget_text', 'do_shortcode');

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'boss-pro' ),
	'description' => __( 'This is the 1st section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'boss-pro' ),
	'description' => __( 'This is the 2nd section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'boss-pro' ),
	'description' => __( 'This is the 3rd section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'boss-pro' ),
	'description' => __( 'This is the 4th section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'boss-pro' ),
	'description' => __( 'This is the 5th section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'boss-pro' ),
	'description' => __( 'This is the 6th section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'boss-pro' ),
	'description' => __( 'This is the 7th section on the front page.', 'boss-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-blog',
	'name'        => __( 'Before Blog', 'boss-pro' ),
	'description' => __( 'This is a widget area right before the first post on every page of your blog.', 'boss-pro' ),
) );

add_action( 'genesis_before_loop', 'boss_before_blog_widget_area', 5 );
/**
 * Before Blog widget area.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_before_blog_widget_area() {

	if ( ( ( is_home() && ! is_front_page() ) || is_page_template( 'page_blog.php' ) ) && is_active_sidebar( 'before-blog' ) ) {
		genesis_widget_area( 'before-blog', array(
			'before' => '<div id="before-blog" class="before-blog">',
			'after'  => '</div>',
		) );
	}
}

/**
 * Setup widget counts
 *
 * @param int $id
 * @return int
 *
 * @since 1.0.0
 */
function boss_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Flexible widget class
 *
 * @param int $id
 * @return string $class
 *
 * @since 1.0.0
 */
function boss_widget_area_class( $id ) {

	$count = boss_count_widgets( $id );
	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves even';
	} else {
		$class .= ' widget-halves uneven';
	}

	return $class;

}

/**
 * Widget area halves
 *
 * @param int $id
 * @return string $class
 *
 * @since 1.0.0
 */
function boss_halves_widget_area_class( $id ) {

	$count = boss_count_widgets( $id );
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


// Add support for 4-column footer widget.
add_theme_support( 'genesis-footer-widgets', 4 );

add_filter( 'genesis_post_info', 'boss_entry_meta_header' );
/**
 * Customize the Entry meta.
 *
 * @param string $post_info
 * @return string $post_info
 *
 * @since 1.0.0
 */
function boss_entry_meta_header( $post_info ) {
	$post_info = '[post_date before="" after=""] <span>/</span> [post_author_posts_link before="by "] <span>/</span> [post_comments hide_if_off="false"]';
	return $post_info;
}

add_filter( 'get_the_content_limit', 'boss_content_limit_read_more_markup', 10, 3 );
/**
 * Read more markup.
 *
 * @param string $output
 * @param string $content
 * @param string $link
 *
 * @return string $output
 */
function boss_content_limit_read_more_markup( $output, $content, $link ) {
	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );
	return $output;
}

add_filter( 'get_the_content_more_link', 'boss_read_more_link' );
/**
 * Read more text.
 *
 * @return string
 *
 * @since 1.0.0
 */
function boss_read_more_link() {
	return '<a class="button more-link" href="' . get_permalink() . '">Read More</a>';
}

add_filter( 'genesis_author_box_title', 'boss_author_box_title' );
/**
 * Author box title.
 *
 * @return string
 *
 * @since 1.0.0
 */
function boss_author_box_title() {
	return '<span itemprop="name">' . get_the_author() . '</span>';
}

add_filter( 'genesis_author_box_gravatar_size', 'boss_author_box_gravatar' );
/**
 * Author gravatar size.
 *
 * @param int $size
 * @return int
 *
 * @since 1.0.0
 */
function boss_author_box_gravatar( $size ) {
	return 160;
}

add_action( 'genesis_before_entry', 'boss_remove_entry_footer' );
/**
 * Remove entry footer on archives.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

// Add previous and next post links after entry.
add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav' );
