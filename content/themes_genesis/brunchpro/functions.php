<?php
/**
 * Theme setup and initialization.
 *
 * @package   BrunchPro
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.0
 */

defined( 'WPINC' ) || die;

require_once get_template_directory() . '/lib/init.php';

define( 'CHILD_THEME_NAME', 'Brunch Pro Theme' );
define( 'CHILD_THEME_VERSION', '2.2.2' );
define( 'CHILD_THEME_URL', 'https://feastdesignco.com/product/brunch-pro/' );
define( 'CHILD_THEME_DEVELOPER', 'Feast Design Co.' );
define( 'BRUNCH_PRO_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'BRUNCH_PRO_URI', trailingslashit( get_stylesheet_directory_uri() ) );

add_theme_support( 'genesis-responsive-viewport' );

add_theme_support( 'html5' );

add_theme_support( 'custom-background' );

add_theme_support( 'genesis-accessibility', array(
	'headings',
	'search-form',
	'skip-links',
) );

add_theme_support( 'custom-header', array(
	'width'           => 640,
	'height'          => 300,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

add_theme_support( 'genesis-footer-widgets', 4 );

add_theme_support( 'genesis-after-entry-widget-area' );

genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'brunch-pro' ),
	'description' => __( 'This is the section before the header.', 'brunch-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Homepage: Above', 'brunch-pro' ),
	'description' => __( 'This section appears above the Homepage content and primary sidebar. It is 100% width. We recommend using the "Brunch Pro - Featured Posts" widget with one-third grid column setting, and the "Genesis: eNews Extended" widget.', 'brunch-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Homepage: Middle', 'brunch-pro' ),
	'description' => __( 'This is the homepage main content section, we recommend using the "Brunch Pro - Featured Posts" widget with a single post and the content displayed.', 'brunch-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Homepage:  Bottom', 'brunch-pro' ),
	'description' => __( 'This is the homepage bottom content section, which is designed for the "Brunch Pro - Featured Posts" widget, with a left-aligned image and an excerpt.', 'brunch-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'recipe-index',
	'name'        => __( 'Recipe Index Page Content', 'brunch-pro' ),
	'description' => __( 'This is the recipe index content section. We recommend using multiple "Brunch Pro - Featured Posts" widgets - one for each recipe category. The sidebar controls arae found in the "Secondary Sidebar" widget area.', 'brunch-pro' ),
) );

require_once BRUNCH_PRO_DIR . 'lib/helpers.php';
require_once BRUNCH_PRO_DIR . 'lib/compatibility.php';
require_once BRUNCH_PRO_DIR . 'lib/customize/init.php';

if ( is_admin() ) {
	require_once BRUNCH_PRO_DIR . 'lib/admin/functions.php';
}

add_action( 'after_setup_theme', 'brunch_pro_content_width', 0 );
/**
 * Set the content width and allow it to be filtered directly.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'brunch_pro_content_width', 980 );
}

add_action( 'after_setup_theme', 'brunch_pro_load_textdomain' );
/**
 * Load the child theme textdomain.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_load_textdomain() {
	load_child_theme_textdomain(
		'brunch-pro',
		trailingslashit( get_stylesheet_directory() ) . 'languages'
	);
}

add_action( 'init', 'brunch_pro_register_image_sizes', 5 );
/**
 * Register custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_image_sizes() {
	add_image_size( 'horizontal-thumbnail', 680, 450, true );
	add_image_size( 'vertical-thumbnail',   680, 900, true );
	add_image_size( 'square-thumbnail',     320, 320, true );
}

add_action( 'init', 'brunch_pro_register_layouts' );
/**
 * Register additional theme layout options.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_layouts() {
	genesis_register_layout( 'full-width-slim', array(
		'label' => __( 'Full Width Slim', 'brunch-pro' ),
		'img'   => trailingslashit( get_stylesheet_directory_uri() ) . 'images/layout-slim.gif',
	) );
	genesis_register_layout( 'alt-sidebar-content', array(
		'label' => __( 'Alt Sidebar/Content', 'brunch-pro' ),
		'img'   => trailingslashit( get_stylesheet_directory_uri() ) . 'images/layout-alt-sidebar-content.gif',
	) );
}

add_action( 'widgets_init', 'brunch_pro_register_widgets', 10 );
/**
 * Unregister the default Genesis Featured Posts widget and register all of
 * our custom Brunch Pro widgets.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_widgets() {
	if ( ! class_exists( 'Brunch_Pro_Featured_Posts', false ) ) {
		require_once BRUNCH_PRO_DIR . 'lib/widgets/featured-posts/widget.php';
	}

	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Brunch_Pro_Featured_Posts' );
}

add_action( 'wp_enqueue_scripts', 'brunch_pro_enqueue_js' );
/**
 * Load all required JavaScript for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_enqueue_js() {
	wp_enqueue_script(
		'brunch-pro-general',
	 	BRUNCH_PRO_URI . 'js/general.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

// Move main menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

add_filter( 'body_class', 'brunch_pro_add_body_class' );
/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 * @param  string $classes The existing body classes.
 * @return string $$classes Modified body classes.
 */
function brunch_pro_add_body_class( $classes ) {
	$classes[] = 'brunch-pro';
	return $classes;
}

add_action( 'genesis_before', 'brunch_pro_before_header' );
/**
 * Load an ad section before .site-inner.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_before_header() {
	genesis_widget_area( 'before-header', array(
		'before' => '<div id="before-header" class="before-header">',
		'after'  => '</div> <!-- end .before-header -->',
	) );
}

add_action( 'genesis_before_entry', 'brunch_pro_maybe_move_post_info', 0 );
/**
 * Relocate the post info if we're not on a blog archive.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_maybe_move_post_info() {
	if ( is_singular() ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_before_entry',  'genesis_post_info', 12 );
	}
}

add_action( 'genesis_after_loop', 'brunch_pro_maybe_disable_sidebars' );
/**
 * Disable the sidebars on custom layouts where they're not needed.
 *
 * @since  1.0.0
 * @access public
 * @uses   genesis_site_layout() Return the site layout for different contexts.
 * @return void
 */
function brunch_pro_maybe_disable_sidebars() {
	$layout = genesis_site_layout();
	if ( in_array( $layout, array( 'full-width-slim', 'alt-sidebar-content' ), true ) ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	}
	if ( 'full-width-slim' === $layout ) {
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	}
}

add_filter( 'genesis_post_info', 'brunch_pro_post_info_filter' );
/**
 * Modify the Genesis post info.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified post info text.
 */
function brunch_pro_post_info_filter() {
	return '[post_date] [post_edit]';
}

/**
 * Return a "Read More" link wrapped in paragraph tags.
 *
 * @since  1.0.0
 * @access public
 * @return string Read more text.
 */
function brunch_pro_get_read_more_link() {
	return sprintf( '<p><a class="more-link" href="%s">%s</a></p>',
		get_permalink(),
		apply_filters( 'brunch_pro_read_more_text', __( 'Read More', 'brunch-pro' ) )
	);
}

add_filter( 'excerpt_more', 'brunch_pro_get_ellipsis' );
/**
 * Return an ellipsis to be used when truncating excerpts.
 *
 * @since  1.0.0
 * @access public
 * @return string an ellipsis.
 */
function brunch_pro_get_ellipsis() {
	return '...';
}

add_filter( 'get_the_content_more_link', 'brunch_pro_content_read_more_link' );
add_filter( 'the_content_more_link', 'brunch_pro_content_read_more_link' );
/**
 * Modify the Genesis and WordPress content read more link.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified read more text.
 */
function brunch_pro_content_read_more_link() {
	return sprintf( '...</p>%s',
		brunch_pro_get_read_more_link()
	);
}

add_filter( 'the_excerpt', 'brunch_pro_excerpt_read_more_link' );
/**
 * Modify the WordPress excerpt by forcing a read more link to be appended.
 *
 * @since  1.0.0
 * @access public
 * @param  string $output the default excerpt output.
 * @return string $output Modified excerpt with a read more link added.
 */
function brunch_pro_excerpt_read_more_link( $output ) {
	return $output . brunch_pro_get_read_more_link();
}

add_filter( 'genesis_footer_creds_text', 'brunch_pro_footer_creds_text' );
/**
 * Customize the footer text
 *
 * @since  1.0.0
 * @access public
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function brunch_pro_footer_creds_text( $creds ) {
	return sprintf( '[footer_copyright before="%s"] &middot; [footer_childtheme_link before=""] %s <a href="https://feastdesignco.com/">%s</a>',
		__( 'Copyright', 'brunch-pro' ),
		__( 'by', 'brunch-pro' ),
		CHILD_THEME_DEVELOPER
	);
}
