<?php
/**
 * Outfitter Pro.
 *
 * This file adds functions to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

// Starts the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Sets up the theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

add_action( 'after_setup_theme', 'outfitter_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @return void
 */
function outfitter_localization_setup(){
	load_child_theme_textdomain( 'outfitter-pro', get_stylesheet_directory() . '/languages' );
}

// Adds the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Adds image upload and color selector to the WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Includes customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Adds WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Setup the header search icon menu.
include_once( get_stylesheet_directory() . '/lib/header-icon-menu.php' );

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Outfitter Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/outfitter/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Enqueues scripts and styles.
add_action( 'wp_enqueue_scripts', 'outfitter_enqueue_scripts_styles' );
function outfitter_enqueue_scripts_styles() {

	wp_enqueue_style( 'outfitter-fonts', '//fonts.googleapis.com/css?family=Prompt:500,700|Noto+Sans:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'outfitter-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), '0.5.2', true );
	wp_enqueue_script( 'outfitter-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'outfitter-match-height' ), '1.0.0', true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'outfitter-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script( 'outfitter-responsive-menu', 'genesis_responsive_menu', outfitter_responsive_menu_settings() );

}

// Defines the responsive menu settings.
function outfitter_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => '',
		'menuIconClass'    => 'ionicon-before ion-android-menu',
		'subMenu'          => __( 'Submenu', 'outfitter-pro' ),
		'subMenuIconClass' => 'ionicon-before ion-android-arrow-dropdown',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-off-screen',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Adds Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array( 'site-inner' ) );

// Adds support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 400,
) );

// Adds support for custom background.
add_theme_support( 'custom-background' );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds image sizes.
add_image_size( 'featured-image', 1280, 800 );
add_image_size( 'featured-image-widget', 530, 330 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Removes navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'outfitter_remove_genesis_metaboxes' );
function outfitter_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Remove unused sections from Theme Customizer
add_action( 'customize_register', 'outfitter_customize_register', 16 );
function outfitter_customize_register( $wp_customize ) {

	$wp_customize->remove_control( 'genesis_image_alignment' );

}

add_filter( 'genesis_skip_links_output', 'outfitter_skip_links_output' );
/**
 * Removes skip link for primary navigation and adds skip link for footer widgets.
 *
 * @param array $links
 * @return array
 *
 * @since 1.0.0
 */
function outfitter_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'outfitter-footer' ) ) {
		$new_links['footer'] = __( 'Skip to footer', 'outfitter-pro' );
	}

	return array_merge( $new_links, $links );

}

// Renames primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'outfitter-pro' ), 'secondary' => __( 'Footer Menu', 'outfitter-pro' ), 'off-screen' => __( 'Off-screen Menu', 'outfitter-pro' ) ) );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 13 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', 'outfitter_limit_menu_args' );
/**
 * Reduces the header and off screen navigation menus to one level depth.
 *
 * @param array $args
 * @return array $args
 *
 * @since 1.0.0
 */
function outfitter_limit_menu_args( $args ) {

	if ( 'off-screen' === $args['theme_location'] || 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_action( 'genesis_after_header', 'outfitter_off_screen_widget_area' );
/**
 * Adds off-screen content icon if widget area is active.
 *
 * @return void
 *
 * @since 1.0.0
 */
function outfitter_off_screen_widget_area() {

	// Exits early if no menu or widget.
	if ( ! is_active_sidebar( 'off-screen-content' ) && ! has_nav_menu( 'off-screen' ) ) {
		return;
	}
	?>

	<div class="off-screen-content off-screen-widget-area">
		<div class="off-screen-container">
			<div class="off-screen-wrapper">
				<div class="wrap">
					<?php
						genesis_nav_menu( array( 'theme_location' => 'off-screen' ) );
						genesis_widget_area( 'off-screen-content' );
					?>
				</div>
			</div>
			<button class="toggle-off-screen-widget-area close"><span class="screen-reader-text"><?php echo __( 'Hide Off-screen Content', 'outfitter-pro' ); ?></span> <span class="ionicons ion-android-close"></span></button>
		</div>
	</div>
	<?php

}

// Adds shortcode support for text widgets.
add_filter('widget_text', 'do_shortcode');

// Repositions default archive image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Filters the archive image markup.
add_filter( 'genesis_markup_entry-image-link_open', 'outfitter_custom_archive_image_open' );
add_filter( 'genesis_markup_entry-image-link_close', 'outfitter_custom_archive_image_close' );

// Sets classes for the Featured Image.
add_filter( 'genesis_attr_entry-image', 'outfitter_image_alignment' );
function outfitter_image_alignment( $attributes ) {

	$attributes['class'] = 'aligncenter post-image entry-image';
	$attributes['itemprop'] = 'image';

	return $attributes;

}

// Adds featured image above the entry content.
add_action( 'genesis_entry_header', 'outfitter_featured_image', 1 );
function outfitter_featured_image() {

	$add_single_image = get_theme_mod( 'outfitter_single_image_setting', outfitter_customizer_get_default_image_setting() );

	$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => 'featured-image',
			'context' => '',
			'attr'    => array ( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'aligncenter' ),
		) );

	if ( is_singular( 'post' ) && ( 1 === $add_single_image ) ) {
		if ( $image ) {
			printf( '<div class="featured-image">%s</div>', $image );
		}
	}

}

// Repositions the entry meta in the entry header.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

// Customizes the entry meta in the entry header.
add_filter( 'genesis_post_info', 'outfitter_post_info_filter' );
function outfitter_post_info_filter( $post_info ) {

	$post_info = '[post_date]';
	return $post_info;

}

// Customizes the entry meta in the entry footer.
add_filter( 'genesis_post_meta', 'outfitter_post_meta_filter' );
function outfitter_post_meta_filter( $post_meta ) {

	$post_meta = '[post_author_posts_link before="Article by<br />"] [post_comments before="Comments<br />"] [post_categories before="Category<br />"] [post_tags before="Tags<br />"] [post_edit]';
	return $post_meta;

}

// Repositions the entry footer and markup.
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
add_action( 'genesis_entry_header', 'genesis_post_meta', 52 );

// Reposition the author box on single posts.
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
add_action( 'genesis_entry_header', 'genesis_do_author_box_single', 51 );

add_action( 'genesis_before_entry', 'outfitter_entry_wrappers' );
/**
 * Adds wrappers to the entry.
 *
 * @return void
 *
 * @since 1.0.0
 */
function outfitter_entry_wrappers() {

	if ( ! is_page() ) {

		// Adds wrapper around the entry header and content, after the featured image.
		add_action( 'genesis_entry_header', 'outfitter_wrapper_open', 2 );
		add_action( 'genesis_entry_footer', 'outfitter_wrapper_close', 15 );

		// Adds wrapper around the author box and entry meta.
		add_action( 'genesis_entry_header', 'outfitter_wrapper_open', 50 );
		add_action( 'genesis_entry_header', 'outfitter_wrapper_close', 53 );

	}

	if ( ! is_archive() ) {
		// Adds wrapper around the after entry items.
		add_action( 'genesis_after_entry', 'outfitter_wrapper_open', 1 );
		add_action( 'genesis_after_entry', 'outfitter_wrapper_close', 100 );
	}

}

// Modifies the size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'outfitter_author_box_gravatar' );
function outfitter_author_box_gravatar( $size ) {

	return 90;

}

// Modifies the size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'outfitter_comments_gravatar' );
function outfitter_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// Sets up the widget counts.
function outfitter_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Calculates the widget count.
function outfitter_widget_area_class( $id ) {

	$count = outfitter_count_widgets( $id );

	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

// Adds the flexible footer widget area.
add_action( 'genesis_before_footer', 'outfitter_footer_widgets' );
function outfitter_footer_widgets() {

	genesis_widget_area( 'outfitter-footer', array(
		'before' => '<div id="footer" class="footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer', 'outfitter-pro' ) . '</h2><div class="flexible-widgets widget-area ' . outfitter_widget_area_class( 'outfitter-footer' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Registers widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'outfitter-pro' ),
	'description' => __( 'This is the front page 1 section.', 'outfitter-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'outfitter-pro' ),
	'description' => __( 'This is the front page 2 section.', 'outfitter-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'outfitter-pro' ),
	'description' => __( 'This is the front page 3 section.', 'outfitter-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'outfitter-footer',
	'name'        => __( 'Footer', 'outfitter-pro' ),
	'description' => __( 'This is the footer section.', 'outfitter-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'off-screen-content',
	'name'        => __( 'Off-Screen Content', 'outfitter-pro' ),
	'description' => __( 'This is the off-screen content section.', 'outfitter-pro' ),
) );
