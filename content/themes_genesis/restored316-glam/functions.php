<?php
/**
 * Glam.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */

//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Glam' );
define( 'CHILD_THEME_URL', 'http://restored316designs.com' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

//* Add Color Selection to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Widget Spaces
require_once( get_stylesheet_directory() . '/lib/widgets.php' );

//* Install Plugins
require_once( get_stylesheet_directory() . '/lib/plugins/tgm-plugin-activation/register-plugins.php' );

//* Enqueue Responsive Menu, Google fonts, Match Height script, and dashicons
add_action( 'wp_enqueue_scripts', 'glam_google_fonts' );
function glam_google_fonts() {
	wp_enqueue_script( 'glam-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Work+Sans:400,200,100,300,500,600,700,800,900|Arapey:400,400italic|Montserrat', array() );
	wp_enqueue_script( 'match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'match-height-init', get_stylesheet_directory_uri() . '/js/matchheight-init.js', array( 'match-height' ), '1.0.0', true );
	wp_enqueue_style( 'dashicons' );

}

//* Add new image sizes
add_image_size( 'blog-square-featured', 400, 400, TRUE );
add_image_size( 'blog-vertical-featured', 800, 1200, TRUE );
add_image_size( 'sidebar-featured', 125, 125, TRUE );
add_image_size( 'large-featured', 850, 475, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 900,
	'height'          => 400,
	'flex-width'      => false,
	'flex-height'     => false,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 1 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before', 'genesis_do_nav' );

//* Add search form to navigation
add_filter( 'wp_nav_menu_items', 'glam_primary_nav_extras', 10, 2 );
function glam_primary_nav_extras( $menu, $args ) {
	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu .= '<li class="right search">' . $search . '</li>';

	return $menu;
}

//* Customize search form input box text
add_filter( 'genesis_search_text', 'glam_search_text' );
function glam_search_text( $text ) {
	return esc_attr( 'Search...' );
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'glam_read_more_link' );
function glam_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">View Post</a>';
}

//* Add widget to secondary navigation
add_filter( 'genesis_nav_items', 'glam_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'glam_social_icons', 10, 2 );

function glam_social_icons($menu, $args) {
	$args = (array)$args;
	if ( 'primary' !== $args['theme_location'] )
		return $menu;
	ob_start();
	genesis_widget_area('nav-social-menu');
	$social = ob_get_clean();
	return $menu . $social;
}

//* Hooks widget area before content
add_action( 'genesis_before_content', 'glam_cta_widget', 2  );
function glam_cta_widget() {

    genesis_widget_area( 'cta-widget', array(
		'before' => '<div class="cta-widget widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}

//* Customize the Post Info Function
add_filter( 'genesis_post_info', 'glam_post_info_filter' );
function glam_post_info_filter( $post_info ) {

	$post_info = '[post_categories before="in "] on [post_date format="m/d/y"]';
    return $post_info;

}

//* Customize the Post Meta function
add_filter( 'genesis_post_meta', 'glam_post_meta_filter' );
function glam_post_meta_filter( $post_meta ) {

    $post_meta = '[post_comments zero="Add a Comment" one="1 Comment" more="% Comments"]';
    return $post_meta;

}

//* Load Entry Navigation
add_action( 'genesis_after_entry', 'genesis_prev_next_post_nav', 7 );

//* Add support for footer menu
add_theme_support ( 'genesis-menus' , array ( 
	'primary'   => 'Primary Navigation Menu', 
	'secondary' => 'Secondary Navigation Menu', 
	'footer'    => 'Footer Navigation Menu' 
) );

//* Hook menu in footer
add_action( 'genesis_after', 'glam_footer_menu', 13 );
function glam_footer_menu() {

	printf( '<nav %s>', genesis_attr( 'nav-footer' ) );

	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',		
		
	) );
	
	echo '</nav>';

}

//* Reposition the footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after', 'genesis_footer_widget_areas' );

//* Reposition the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 14 ); 

//* Setup widget count
function glam_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function glam_widget_area_class( $id ) {
	$count = glam_count_widgets( $id );

	$class = '';

	if( $count == 1 || $count < 9 ) {

		$classes = array(
			'zero',
			'one',
			'two',
			'three',
			'four',
			'five',
			'six',
			'seven',
			'eight',
		);

		$class = $classes[ $count ] . '-widget';
		$class = $count == 1 ? $class : $class . 's';

		return $class;

	} else {

		$class = 'widget-thirds';
		
		return $class;

	}

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'glam_comments_gravatar' );
function glam_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'glam_author_box_gravatar' );
function glam_author_box_gravatar( $size ) {

	return 125;

}

//* Add widget area between and after 3 posts
add_action( 'genesis_after_entry', 'glam_between_posts_area' );

function glam_between_posts_area() {
global $loop_counter;

$loop_counter++;

if( $loop_counter == 4 ) {


if ( is_active_sidebar( 'between-posts-area' ) ) {
    echo '<div class="between-posts-area widget-area"><div class="wrap">';
	dynamic_sidebar( 'between-posts-area' );
	echo '</div></div><!-- end .top -->';
	}

$loop_counter = 10;

}

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'glam_remove_comment_form_allowed_tags' );
function glam_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

//* Reposition Featured Images
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_before_entry', 'genesis_do_post_image', 9 );

//* Customize the credits 
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text() {
    echo '<div class="creds"><p>';
    echo 'Copyright &copy; ';
    echo date('Y');
    echo ' &middot; <a target="_blank" href="http://restored316designs.com/themes">glam theme</a> by <a target="_blank" href="http://www.restored316designs.com">Restored 316</a>';
    echo '</p></div>';

}

//* Add Theme Support for WooCommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//* Remove Add to Cart on Archives
add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
function remove_add_to_cart_buttons() {

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

}

//* Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

//* Display 12 products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

//* Add WooCommerce Gallery Options
add_action( 'after_setup_theme', 'glam_woo_gallery' );
function glam_woo_gallery() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}