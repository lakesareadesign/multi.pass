<?php
/**
 * Theme functions
 *
 * @package   Cookd
 * @copyright Copyright (c) 2016, Shay Bocks
 * @license   GPL-2.0+
 * @link      http://www.feastdesignco.com/cookd/
 * @since     1.0.0
 */

defined( 'ABSPATH' ) || exit;

require_once untrailingslashit( get_template_directory() ) . '/lib/init.php';

define( 'CHILD_THEME_NAME', 'Cookd Pro Theme' );
define( 'CHILD_THEME_VERSION', '1.0.1' );
define( 'CHILD_THEME_URL', 'http://feastdesignco.com/cookd/' );
define( 'CHILD_THEME_DEVELOPER', 'Shay Bocks' );

$_cooked_dir = untrailingslashit( get_stylesheet_directory() );

require_once "{$_cooked_dir}/lib/compat.php";
require_once "{$_cooked_dir}/lib/helpers.php";
require_once "{$_cooked_dir}/lib/plugins.php";
require_once "{$_cooked_dir}/lib/class-widget-featured-posts.php";

if ( genesis_is_customizer() ) {
	require_once "{$_cooked_dir}/lib/customize.php";
}

if ( is_admin() ) {
	require_once "{$_cooked_dir}/lib/admin.php";
}

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

add_theme_support( 'genesis-connect-woocommerce' );

genesis_unregister_layout( 'content-sidebar-sidebar' );

genesis_unregister_layout( 'sidebar-sidebar-content' );

genesis_unregister_layout( 'sidebar-content-sidebar' );

genesis_register_sidebar( array(
	'id'          => 'recipe-index',
	'name'        => __( 'Recipe Index Sidebar', 'cookd' ),
	'description' => __( 'This is the sidebar for the recipe index.', 'cookd' ),
) );

genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home Top', 'cookd' ),
	'description' => __( 'This is the home top section.', 'cookd' ),
) );

genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home Middle', 'cookd' ),
	'description' => __( 'This is the home middle section.', 'cookd' ),
) );

genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home Bottom', 'cookd' ),
	'description' => __( 'This is the home bottom section.', 'cookd' ),
) );

add_action( 'after_setup_theme', 'cookd_content_width', 0 );
/**
 * Set the content width and allow it to be filtered directly.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cookd_content_width', 980 );
}

add_action( 'after_setup_theme', 'cookd_load_textdomain' );
/**
 * Load the child theme textdomain.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_load_textdomain() {
	load_child_theme_textdomain(
		'cookd',
		"{$GLOBALS['_cooked_dir']}/languages"
	);
}

add_action( 'init', 'cookd_register_image_sizes', 5 );
/**
 * Register custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_register_image_sizes() {
	add_image_size( 'cookd-large',     1170, 617, true );
	add_image_size( 'cookd-medium',     768, 405, true );
	add_image_size( 'cookd-small',      320, 169, true );
	add_image_size( 'cookd-grid',       580, 460, true );
	add_image_size( 'cookd-gridlarge', 1170, 800, true );
	add_image_size( 'cookd-vertical',  1000, 1477, true );
}

add_action( 'init', 'cookd_register_layouts' );
/**
 * Register additional theme layout options.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_register_layouts() {
	$dir = untrailingslashit( get_stylesheet_directory_uri() );

	genesis_register_layout( 'full-width-slim', array(
		'label' => __( 'Full Width Slim', 'cookd' ),
		'img'   => "{$dir}/images/layout-slim.gif",
	) );
	genesis_register_layout( 'alt-sidebar-content', array(
		'label' => __( 'Alt Sidebar/Content', 'cookd' ),
		'img'   => "{$dir}/images/layout-alt-sidebar-content.gif",
	) );
}

add_action( 'widgets_init', 'cookd_register_widgets', 10 );
/**
 * Unregister the default Genesis Featured Posts widget and register all of
 * our custom Cookd Pro widgets.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_register_widgets() {
	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Cookd_Featured_Posts' );
}

add_action( 'wp_enqueue_scripts', 'cookd_enqueue_syles' );
/**
 * Load styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_enqueue_syles() {
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style(
		'font-awesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css'
	);

	wp_enqueue_style(
		'cookd-google-fonts',
		'//fonts.googleapis.com/css?family=IM+Fell+Double+Pica:400,400italic|Source+Sans+Pro:300,300italic,400,400italic,600,600italic',
		array(),
		CHILD_THEME_VERSION
	);
}

add_action( 'wp_enqueue_scripts', 'cookd_enqueue_js' );
/**
 * Load all required JavaScript for the Foodie theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_enqueue_js() {
	wp_enqueue_script(
		'cookd-general',
	 	untrailingslashit( get_stylesheet_directory_uri() ) . '/js/general.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

// Add post navigation.
add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

// Move the main navigation before the header.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

// Move the post image into the entry header.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 6 );

// Move the post info before the post title.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header',  'genesis_post_info', 8 );

add_action( 'genesis_entry_footer' , 'cookd_remove_post_meta_pages', 0 );
/**
 * Remove the entry meta in the entry footer if not singular.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_remove_post_meta_pages() {
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

add_filter( 'genesis_post_meta', 'cookd_post_meta_filter' );
/**
 * Customize the entry meta in the entry.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cookd_post_meta_filter() {
	return sprintf( '[post_categories before="%s: "] [post_tags before="%s: "]',
		esc_html_x( 'Categories', 'post category label', 'cookd' ),
		esc_html_x( 'Tags', 'post tags label', 'cookd' )
	);
}

add_action( 'genesis_before_content_sidebar_wrap', 'cookd_single_post_image', 8 );
/**
 * Display Featured Image on top of the post.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_single_post_image() {
	if ( is_singular( 'post' ) ) {
		if ( get_theme_mod( 'enable_single_post_image', true ) ) {
			the_post_thumbnail( 'cookd-large' );
		}
	}
}

add_filter( 'genesis_search_button_text', 'cookd_search_button_text' );
/**
 * Customize search form input button text.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cookd_search_button_text() {
	return '&#xf002;';
}

add_filter( 'body_class', 'cookd_add_body_class', 10 );
/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 * @param  string $classes The existing body classes.
 * @return string $$classes Modified body classes.
 */
function cookd_add_body_class( $classes ) {
	$classes[] = 'cookd';
	return $classes;
}

add_action( 'genesis_before', 'cookd_before_header', 10 );
/**
 * Load an ad section before .site-inner.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_before_header() {
	genesis_widget_area( 'before-header', array(
		'before' => '<div id="before-header" class="before-header">',
		'after'  => '</div> <!-- end .before-header -->',
	) );
}

add_action( 'genesis_before_loop',  'cookd_blog_page_maybe_add_grid', 99 );
/**
 * Add the archive grid filter to the main loop.
 *
 * @since  1.0.0
 * @uses   genesis_is_blog_template()
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_blog_page_maybe_add_grid() {
	if ( genesis_is_blog_template() && cookd_is_grid_enabled() ) {
		cookd_maybe_add_grid();
	}
}

add_action( 'genesis_after_loop', 'cookd_blog_page_maybe_remove_grid', 5 );
/**
 * Remove the archive grid filter to ensure other loops are unaffected.
 *
 * @since  1.0.0
 * @uses   genesis_is_blog_template()
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_blog_page_maybe_remove_grid() {
	if ( genesis_is_blog_template() && cookd_is_grid_enabled() ) {
		cookd_maybe_remove_grid();
	}
}

add_action( 'genesis_before_entry', 'cookd_archive_maybe_add_grid', 10 );
/**
 * Add the archive grid filter to the main loop.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_archive_maybe_add_grid() {
	if ( cookd_is_blog_archive() ) {
		cookd_maybe_add_grid_main();
	}
}

add_action( 'genesis_before_entry', 'cookd_archive_maybe_remove_title', 10 );
/**
 * Remove the entry title if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_archive_maybe_remove_title() {
	if ( cookd_is_blog_archive() ) {
		cookd_grid_maybe_remove_title();
	}
}

add_action( 'genesis_before_entry', 'cookd_archive_maybe_remove_info', 10 );
/**
 * Remove the entry info if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_archive_maybe_remove_info() {
	if ( cookd_is_blog_archive() ) {
		cookd_grid_maybe_remove_info();
	}
}

add_action( 'genesis_before_entry', 'cookd_archive_maybe_remove_content', 10 );
/**
 * Remove the entry content if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_archive_maybe_remove_content() {
	if ( cookd_is_blog_archive() ) {
		cookd_grid_maybe_remove_content();
	}
}

add_filter( 'genesis_pre_get_option_image_size', 'cookd_archive_maybe_change_image_size' );
/**
 * Use the grid image size on pages where the grid layout is enabled.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @param  string $setting The current setting.
 * @return string $setting The modified setting,.
 */
function cookd_archive_maybe_change_image_size( $setting ) {
	if ( cookd_is_blog_archive() ) {
		return cookd_grid_get_image_size();
	}

	return $setting;
}

add_action( 'genesis_before_entry', 'cookd_archive_maybe_move_image', 10 );
/**
 * Move the post image if the user has changed the placement via the customizer.
 *
 * @since  1.0.0
 * @uses   cookd_is_blog_archive()
 * @return void
 */
function cookd_archive_maybe_move_image() {
	if ( cookd_is_blog_archive() ) {
		cookd_grid_maybe_move_image();
	}
}

add_filter( 'shortcode_atts_post_categories', 'cookd_limited_post_categories_atts', 10, 3 );
/**
 * Set a default attribute for the post categories limit.
 *
 * @since  1.0.0
 * @access public
 * @param  array $out The output array of shortcode attributes.
 * @param  array $pairs The supported attributes and their defaults.
 * @param  array $atts The user defined shortcode attributes.
 * @return array
 */
function cookd_limited_post_categories_atts( $out, $pairs, $atts ) {
	$out['limit'] = 1;

	if ( isset( $atts['limit'] ) ) {
		$out['limit'] = $atts['limit'];
	}

	return $out;
}

add_filter( 'genesis_post_categories_shortcode', 'cookd_limited_post_categories', 10, 2 );
/**
 * Filter the Genesis post categories shortcode to handle a limit attribute.
 *
 * @since  1.0.0
 * @access public
 * @param  string $output The default shortcode output.
 * @param  array  $atts The default shortcode attributes.
 * @return string
 */
function cookd_limited_post_categories( $output, $atts ) {
	if ( ! isset( $atts['limit'] ) ) {
		return $output;
	}

	$limit = absint( $atts['limit'] );
	$cats  = explode( $atts['sep'], $output );

	if ( $limit >= count( $cats ) ) {
		return $output;
	}

	$count = 0;

	foreach ( $cats as $key => $cat ) {
		$count++;
		if ( $limit < $count ) {
			unset( $cats[ $key ] );
		}
	}

	$output = implode( $atts['sep'], $cats );

	return apply_filters( 'cookd_limited_post_categories', $output, $atts );
}

add_filter( 'genesis_post_info', 'cookd_post_info_filter', 10 );
/**
 * Modify the Genesis post info.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified post info text.
 */
function cookd_post_info_filter() {
	$info = '[post_date] [post_categories before=""] [post_edit]';

	if ( function_exists( 'heart_this' ) ) {
		$info = "[heart_this] {$info}";
	}

	return $info;
}

/**
 * Return a "Read More" link wrapped in paragraph tags.
 *
 * @since  1.0.0
 * @access public
 * @return string Read more text.
 */
function cookd_get_read_more_link() {
	return sprintf( '<p><a class="more-link" href="%s">%s</a></p>',
		get_permalink(),
		apply_filters( 'cookd_read_more_text', __( 'Read More', 'cookd' ) )
	);
}

add_filter( 'excerpt_more', 'cookd_get_ellipsis' );
/**
 * Return an ellipsis to be used when truncating excerpts.
 *
 * @since  1.0.0
 * @access public
 * @return string an ellipsis.
 */
function cookd_get_ellipsis() {
	return '...';
}

add_filter( 'get_the_content_more_link', 'cookd_content_read_more_link' );
add_filter( 'the_content_more_link',     'cookd_content_read_more_link' );
/**
 * Modify the Genesis and WordPress content read more link.
 *
 * @since  1.0.0
 * @access public
 * @return string Modified read more text.
 */
function cookd_content_read_more_link() {
	return sprintf( '...</p>%s',
		cookd_get_read_more_link()
	);
}

add_filter( 'the_excerpt', 'cookd_excerpt_read_more_link' );
/**
 * Modify the WordPress excerpt by forcing a read more link to be appended.
 *
 * @since  1.0.0
 * @access public
 * @param  string $output the default excerpt output.
 * @return string $output Modified excerpt with a read more link added.
 */
function cookd_excerpt_read_more_link( $output ) {
	return $output . cookd_get_read_more_link();
}

add_action( 'genesis_after_loop', 'cookd_maybe_disable_sidebars', 10 );
/**
 * Disable the sidebars on custom layouts where they're not needed.
 *
 * @since  1.0.0
 * @access public
 * @uses   genesis_site_layout() Return the site layout for different contexts.
 * @return void
 */
function cookd_maybe_disable_sidebars() {
	$layout = genesis_site_layout();

	if ( in_array( $layout, array( 'full-width-slim', 'alt-sidebar-content' ), true ) ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	}

	if ( 'full-width-slim' === $layout ) {
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	}
}

add_filter( 'genesis_footer_creds_text', 'cookd_footer_creds_text', 10 );
/**
 * Customize the footer text
 *
 * @since  1.0.0
 * @access public
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function cookd_footer_creds_text( $creds ) {
	return sprintf( '[footer_copyright before="%s"] &middot; [footer_childtheme_link before=""] %s <a href="http://feastdesignco.com/">%s</a>',
		__( 'Copyright', 'cookd' ),
		__( 'by', 'cookd' ),
		CHILD_THEME_DEVELOPER
	);
}
