<?php
/**
 * Custom amendments for the theme.
 *
 * @package   FoodiePro
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.1
 */

defined( 'WPINC' ) || die;

require_once trailingslashit( get_template_directory() ) . 'lib/init.php';

define( 'CHILD_THEME_NAME', 'Foodie Pro Theme' );
define( 'CHILD_THEME_VERSION', '3.1.4' );
define( 'CHILD_THEME_URL', 'https://feastdesignco.com/product/foodie-pro/' );
define( 'CHILD_THEME_DEVELOPER', 'Feast Design Co.' );
define( 'FOODIE_PRO_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'FOODIE_PRO_URI', trailingslashit( get_stylesheet_directory_uri() ) );

add_theme_support( 'genesis-responsive-viewport' );

add_theme_support( 'html5' );

add_theme_support(
	'genesis-accessibility',
	array(
		'headings',
		'search-form',
		'skip-links',
	)
);

add_theme_support( 'custom-header', array(
	'width'           => 640,
	'height'          => 340,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

add_theme_support( 'custom-background' );
add_theme_support( 'genesis-connect-woocommerce' );
add_theme_support( 'genesis-after-entry-widget-area' );
add_theme_support( 'genesis-footer-widgets', 4 );

genesis_register_sidebar( array(
	'id'			=> 'before-header',
	'name'			=> __( 'Before Header: Newsletter', 'foodiepro' ),
	'description'	=> __( 'This is for the "Genesis: eNews Extended" widget.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-top',
	'name'			=> __( 'Homepage: Top', 'foodiepro' ),
	'description'	=> __( 'This is the homepage top section, designed for the "Foodie Pro - Featured Posts" widget with full-width setting and 1 post.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle',
	'name'			=> __( 'Homepage: Middle', 'foodiepro' ),
	'description'	=> __( 'This is the homepage middle section, designed for the "Genesis: eNews Extended" widget.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom',
	'name'			=> __( 'Homepage: Bottom', 'foodiepro' ),
	'description'	=> __( 'This is the homepage bottom section, designed for the "Foodie Pro - Featured Posts" widget with as many posts displayed in any configuration you like.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'recipe-index-search',
	'name'			=> __( 'Recipe Index: Search', 'foodiepro' ),
	'description'	=> __( 'This is the recipe index search area, designed for the Categories, Archive, and Search widgets.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'recipe-index-featured-posts',
	'name'			=> __( 'Recipe Index: Featured Posts', 'foodiepro' ),
	'description'	=> __( 'This is the recipe index posts area, designed for the "Foodie Pro - Featured Posts" widgets.', 'foodiepro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'nav-social-menu',
	'name'        => __( 'Navigation Menu: Social Icons', 'foodiepro' ),
	'description' => __( 'This area is for the "Simple Social Icons" widget, and appears in the top navigation area.', 'foodiepro' ),
) );

require_once FOODIE_PRO_DIR . 'lib/helpers.php';
require_once FOODIE_PRO_DIR . 'lib/customize/init.php';

if ( is_admin() ) {
	require_once FOODIE_PRO_DIR . 'lib/admin/functions.php';
}

add_action( 'after_setup_theme', 'foodie_pro_content_width', 0 );
/**
 * Set the content width and allow it to be filtered directly.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function foodie_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'foodie_pro_content_width', 610 );
}

add_action( 'after_setup_theme', 'foodie_pro_load_textdomain' );
/**
 * Loads the child theme textdomain.
 *
 * @since  2.1.0
 * @return void
 */
function foodie_pro_load_textdomain() {
	load_child_theme_textdomain( 'foodiepro', FOODIE_PRO_DIR . 'languages' );
}

add_action( 'init', 'foodie_pro_register_image_sizes', 5 );
/**
 * Register custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function foodie_pro_register_image_sizes() {
	add_image_size( 'horizontal-thumbnail', 680, 450, true );
	add_image_size( 'horizontal-thumbnail-small', 340, 225, true );
	add_image_size( 'vertical-thumbnail', 680, 900, true );
	add_image_size( 'vertical-thumbnail-small', 340, 450, true );
	add_image_size( 'square-thumbnail', 320, 321, true );
}

add_action( 'widgets_init', 'foodie_pro_register_widgets', 11 );
/**
 * Unregister the default Genesis Featured Posts widget and register all of
 * our custom Foodie Pro widgets.
 *
 * @since  2.0.0
 */
function foodie_pro_register_widgets() {
	require_once FOODIE_PRO_DIR . 'lib/widgets/featured-posts/widget.php';

	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Foodie_Pro_Featured_Posts' );
}

add_action( 'wp_enqueue_scripts', 'foodie_pro_enqueue_js' );
/**
 * Load all required JavaScript for the Foodie theme.
 *
 * @since   1.0.1
 * @return  void
 */
function foodie_pro_enqueue_js() {
	wp_enqueue_script(
		'foodie-pro-general',
		FOODIE_PRO_URI . 'js/general.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

add_filter( 'body_class', 'foodie_pro_add_body_class' );
/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 * @param  array $classes Current body classes.
 * @return array $classes Modified body classes.
 */
function foodie_pro_add_body_class( $classes ) {
	$classes[] = 'foodie-pro';
	return $classes;
}

add_action( 'genesis_before', 'foodie_pro_before_header' );
/**
 * Load an ad section before .site-inner.
 *
 * @since  1.0.0
 * @return void
 */
function foodie_pro_before_header() {
	genesis_widget_area( 'before-header', array(
		'before' => '<div id="before-header" class="before-header">',
		'after'  => '</div> <!-- end .before-header -->',
	) );
}

add_filter( 'wp_nav_menu_items', 'foodie_pro_primary_nav_menu_social', 10, 2 );
/**
 * Append a social widget area to the primary menu.
 *
 * @since  3.0.0
 * @param  string $menu The current menu output.
 * @param  array  $args The args used for displaying the current menu.
 * @return string $menu The modified menu output.
 */
function foodie_pro_primary_nav_menu_social( $menu, $args ) {
	if ( 'primary' !== $args->theme_location || ! is_active_sidebar( 'nav-social-menu' ) ) {
		return $menu;
	}

	ob_start();
	genesis_widget_area( 'nav-social-menu' );
	$widget_area = ob_get_clean();

	$menu .= sprintf( '<li id="foodie-social" class="foodie-social menu-item">%s</li>',
		$widget_area
	);

	return $menu;
}

add_filter( 'wp_nav_menu_items', 'foodie_pro_primary_nav_menu_search', 12, 2 );
/**
 * Append a search box to the primary menu.
 *
 * @since  3.0.0
 * @param  string $menu The current menu output.
 * @param  array  $args The args used for displaying the current menu.
 * @return string $menu The modified menu output.
 */
function foodie_pro_primary_nav_menu_search( $menu, $args ) {
	if ( 'primary' !== $args->theme_location || genesis_get_option( 'nav_extras' ) ) {
		return $menu;
	}

	$menu .= sprintf( '<li id="foodie-search" class="foodie-search menu-item">%s</li>',
		genesis_search_form( false )
	);

	return $menu;
}

add_filter( 'genesis_search_text', 'foodie_pro_search_text' );
/**
 * Customize search form input box text.
 *
 * @since  3.0.0
 * @return string Modified Shay Bocks credits.
 */
function foodie_pro_search_text() {
	return esc_html__( 'Search', 'foodiepro' );
}

add_filter( 'excerpt_more', 'foodie_pro_read_more_link' );
add_filter( 'get_the_content_more_link', 'foodie_pro_read_more_link' );
add_filter( 'the_content_more_link', 'foodie_pro_read_more_link' );
/**
 * Modify the Genesis read more link.
 *
 * @since  1.0.0
 * @return string Modified read more text.
 */
function foodie_pro_read_more_link() {
	return sprintf( '...</p><p><a class="more-link" href="%s">%s</a></p>',
		get_permalink(),
		esc_html__( 'Read More', 'foodiepro' )
	);
}

add_filter( 'genesis_comment_form_args', 'foodie_pro_comment_form_args' );
/**
 * Modify the speak your mind text.
 *
 * @since  1.0.0
 * @param  array $args the default comment reply text.
 * @return array $args the modified comment reply text.
 */
function foodie_pro_comment_form_args( $args ) {
	$args['title_reply'] = esc_html__( 'Comments', 'foodiepro' );
	return $args;
}

// Add post navigation.
add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

// Modify the author says text in comments.
add_filter( 'comment_author_says_text', '__return_empty_string' );

add_filter( 'genesis_footer_creds_text', 'foodie_pro_footer_creds_text' );
/**
 * Customize the footer text
 *
 * @since  1.0.0
 *
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function foodie_pro_footer_creds_text( $creds ) {
	return '[footer_copyright before="Copyright "] &middot; <a href="https://feastdesignco.com/product/foodie-pro/">Foodie Pro</a> & <a href="https://www.studiopress.com/">The Genesis Framework</a>';
}
