<?php
/**
 * Academy Pro.
 *
 * This file adds functions to the Academy Pro Theme.
 *
 * @package Academy
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/academy/
 */

// Starts the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Sets up the Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Sets localization (do not remove).
add_action( 'after_setup_theme', 'academy_localization_setup' );
function academy_localization_setup(){

	load_child_theme_textdomain( 'academy-pro', get_stylesheet_directory() . '/languages' );

}

// Adds the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Adds image upload and color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customizer/customize.php' );

// Adds the theme image functions.
include_once( get_stylesheet_directory() . '/lib/featured-images.php' );

// Includes customizer CSS.
include_once( get_stylesheet_directory() . '/lib/customizer/output.php' );

// Adss the Grid Layout.
include_once( get_stylesheet_directory() . '/lib/grid-layout.php' );

// Adds WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Includes the customizer CSS for the WooCommerce plugin.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Includes notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Academy Pro' );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/academy/' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

add_action( 'wp_enqueue_scripts', 'academy_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function academy_enqueue_scripts_styles() {

	wp_enqueue_style( 'academy-fonts', '//fonts.googleapis.com/css?family=Merriweather:400,400i,700,700i|PT+Sans:400,700', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'academy-sp-icons', get_stylesheet_directory_uri() . '/css/sp-icons.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'academy-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'academy-match-height', "jQuery(document).ready( function() { jQuery( '.half-width-entries .content .entry, .academy-grid .content .entry').matchHeight(); });" );

	wp_enqueue_script( 'global-js', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'academy-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'academy-responsive-menu',
		'genesis_responsive_menu',
		academy_responsive_menu_settings()
	);

	// Sets up page if has top banner.
	if ( get_theme_mod( 'academy-top-banner-visibility', true ) ) {

		wp_enqueue_script( 'top-banner-js', get_stylesheet_directory_uri() . '/js/top-banner.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	}

}

add_action( 'body_class', 'academy_top_banner_classes' );
/**
* Adds top-banner body classes.
*
* @since 1.0.0
*
* @param array $classes Current classes.
* @return array $classes Updated class array.
*/
function academy_top_banner_classes( $classes ) {

	if ( get_theme_mod( 'academy-top-banner-visibility', true ) ) {

		$classes[] = 'top-banner-hidden';

		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}

	}

	return $classes;

}

add_filter( 'body_class', 'academy_half_width_entry_class' );
/**
 * Defines the half width entries body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Current classes.
 * @return array $classes Updated class array.
 */
function academy_half_width_entry_class( $classes ) {

	$site_layout = genesis_site_layout();

	if ( 'full-width-content' === $site_layout && ( is_home() || is_category() || is_tag() || is_author() || is_search() || genesis_is_blog_template() ) ) {
		$classes[] = 'half-width-entries';
	}

	return $classes;

}

// Defines the responsive menu settings.
function academy_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'academy-pro' ),
		'menuIconClass'    => 'sp-icon-menu',
		'subMenu'          => __( 'Submenu', 'academy-pro' ),
		'subMenuIconClass' => 'sp-icon-plus',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
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

// Relocates skip links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );
add_action ( 'genesis_before', 'genesis_skip_links', 5 );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 160,
	'width'           => 600,
) );

// Adds structural wrap to site-inner.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'site-inner',
	'footer-widgets',
	'footer',
) );

// Move breadcrumbs to bellow header
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds image sizes.
add_image_size( 'featured-image', 880, 360, TRUE );
add_image_size( 'large-portrait', 300, 350, TRUE );

add_filter( 'image_size_names_choose', 'academy_media_library_sizes' );
/**
 * Adds image sizes to Media Library.
 *
 * @since 1.0.0
 *
 * @param array $sizes Array of image sizes and their names.
 * @return array The modified list of sizes.
 */
function academy_media_library_sizes( $sizes ) {

	$sizes['large-portrait'] = __( 'Home - Large Portrait', 'academy-pro' );

	return $sizes;

}

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

add_action( 'genesis_theme_settings_metaboxes', 'academy_remove_genesis_metaboxes' );
/**
 * Removes navigation meta box.
 *
 * @since 1.0.0
 *
 * @param string $_genesis_theme_settings_pagehook The page hook name.
 */
function academy_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

add_filter( 'genesis_skip_links_output', 'academy_skip_links_output' );
/**
 * Removes skip link for primary navigation and adds skip link for footer widgets.
 *
 * @since 1.0.0
 *
 * @param array $links The list of skip links.
 * @return array $links The modified list of skip links.
 */
function academy_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;

	if ( is_active_sidebar( 'footer-cta' ) ) {
		$new_links['footer-cta'] = __( 'Skip to footer', 'academy-pro' );
	}

	return array_merge( $links, $new_links );

}

// Renames primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'academy-pro' ), 'secondary' => __( 'Footer Menu', 'academy-pro' ) ) );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', 'academy_secondary_menu_args' );
/**
 * Reduces the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args The WP navigation menu arguments.
 * @return array The modified menu arguments.
 */
function academy_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'academy_author_box_gravatar' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function academy_author_box_gravatar( $size ) {

	return 155;

}

add_filter( 'genesis_author_box', 'academy_author_box', 10, 6 );
/**
 * Adds a wrapper around the gravatar image on single posts and author pages.
 *
 * @since 1.0.0
 *
 * @param string $output The original author box HTML.
 * @param string $context Context.
 * @param string $pattern (s)printf pattern.
 * @param string $gravatar The gravatar.
 * @param string $title The title.
 * @param string $description The description.
 * @return string The new author box HTML.
 */
function academy_author_box( $output, $context, $pattern, $gravatar, $title, $description ) {

	$gravatar = sprintf( '<div class="gravatar-wrap">%s</div>', $gravatar );

	$output = sprintf( $pattern, $gravatar, $title, $description );

	return $output;

}

add_filter( 'genesis_comment_list_args', 'academy_comments_gravatar' );
/**
 * Modifies the size of the Gravatar in the entry comments.
 *
 * @since 1.0.0
 *
 * @param array $args The comment list arguments.
 * @return array Arguments with new avatar size.
 */
function academy_comments_gravatar( $args ) {

	$args['avatar_size'] = 62;

	return $args;

}

add_filter( 'comment_author_says_text', 'academy_comment_author_says_text' );
/**
 * Modifies the author says text in comments.
 *
 * @since 1.0.0
 *
 * @return string New author says text.
 */
function academy_comment_author_says_text() {

	return '';

}

add_filter( 'get_the_content_limit', 'academy_content_limit_read_more_markup', 10, 3 );
/**
 * Modifies the generic more link markup for posts.
 *
 * @since 1.0.0
 *
 * @param string $output The current full HTML.
 * @param string $content The content HTML.
 * @param string $link The link HTML.
 * @return string The new more link HTML.
 */
function academy_content_limit_read_more_markup( $output, $content, $link ) {

	if ( is_page_template( 'page_blog.php' ) || is_home() || is_archive() || is_search() ) {
		$link = sprintf( '<a href="%s" class="more-link button text">%s &#x2192;</a>', get_the_permalink(), genesis_a11y_more_link( __( 'Continue Reading', 'academy-pro' ) ) );
	}

	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

// Moves image above post title.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

// Sets up the widget counts.
function academy_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Outputs class names based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function academy_widget_area_class( $id ) {

	$count = academy_count_widgets( $id );

	$class = '';

	if ( 1 === $count ) {
		$class .= ' widget-full';
	} elseif ( 0 === $count % 3 ) {
		$class .= ' widget-thirds';
	} elseif ( 1 === $count % 2 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

/**
 * Outputs class names based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function academy_alternate_widget_area_class( $id ) {

	$count = academy_count_widgets( $id );

	$class = '';

	if ( 1 === $count || 2 === $count ) {
		$class .= ' widget-full';
	} elseif ( 1 === $count % 3 ) {
		$class .= ' widget-thirds';
	} elseif ( 0 === $count % 2 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

add_action( 'genesis_before_footer', 'academy_footer_cta' );
/**
 * AAdds the footer cta area.
 *
 * @since 1.0.0
 */
function academy_footer_cta() {

	genesis_widget_area( 'footer-cta', array(
		'before' => '<div id="footer-cta" class="footer-cta"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer CTA', 'academy-pro' ) . '</h2><div class="flexible-widgets widget-area ' . academy_widget_area_class( 'footer-cta' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

add_filter( 'genesis_post_info', 'academy_post_info_filter' );
/**
 * Modifies the meta information in the entry header.
 *
 * @since 1.0.0
 *
 * @param string $post_info Current post info.
 * @return string New post info.
 */
function academy_post_info_filter($post_info) {

	$post_info = 'posted on [post_date] [post_edit]';

	return $post_info;

}

add_action( 'genesis_meta', 'academy_move_page_titles' );
/**
 * Moves page title above content wrap.
 *
 * @since 1.0.0
 */
function academy_move_page_titles() {

	if ( is_page() && ! is_page_template( 'page_blog.php' ) && ! is_front_page() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title' );
	}

}

// Moves page and archive titles above the content wrap.
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_posts_page_heading' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_blog_template_heading' );

add_action( 'genesis_before', 'academy_do_top_banner' );
/**
 * Output the Top Banner if visible.
 *
 * @since 1.0.0
 */
function academy_do_top_banner() {

	if ( get_theme_mod( 'academy-top-banner-visibility', true ) ) {

		$button = sprintf( '<button id="academy-top-banner-close"><span class="sp-icon-x"></span><span class="screen-reader-text">%s</span></button>', __( 'Close Top Banner', 'academy-pro' ) );
		printf(
			'<div class="academy-top-banner">%s%s</div>',
			get_theme_mod( 'academy-top-banner-text', academy_get_default_top_banner_text() ),
			$button
		);

	}

}

// Registers widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'academy-pro' ),
	'description' => __( 'This is the front page 1 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'academy-pro' ),
	'description' => __( 'This is the front page 2 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'academy-pro' ),
	'description' => __( 'This is the front page 3 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'academy-pro' ),
	'description' => __( 'This is the front page 4 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'academy-pro' ),
	'description' => __( 'This is the front page 5 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'academy-pro' ),
	'description' => __( 'This is the front page 6 section.', 'academy-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'footer-cta',
	'name'        => __( 'Footer CTA', 'academy-pro' ),
	'description' => __( 'This is the bottom call to action section.', 'academy-pro' ),
) );
