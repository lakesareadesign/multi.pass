<?php
/**
 * This file adds all the functions to the Market theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Color selections to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Add Widget Spaces
require_once( get_stylesheet_directory() . '/lib/widgets.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Market' );
define( 'CHILD_THEME_URL', 'http://restored316designs.com' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Loads Responsive Menu, Google Fonts, Icons, and other scripts
add_action( 'wp_enqueue_scripts', 'market_enqueue_scripts' );
function market_enqueue_scripts() {

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Gentium+Basic:400,400italic|Arimo:400,400italic|IM+Fell+English:400,400italic|EB+Garamond|Homemade+Apple', array() );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'global-script', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
	wp_enqueue_script( 'market-fadeup-script', get_stylesheet_directory_uri() . '/js/fadeup.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'match-height-init', get_stylesheet_directory_uri() . '/js/matchheight-init.js', array( 'match-height' ), '1.0.0', true );

}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add new featured image sizes
add_image_size( 'square-entry-image', 400, 400, TRUE );
add_image_size( 'vertical-entry-image', 400, 600, TRUE );
add_image_size( 'horizontal-entry-image', 600, 400, TRUE );
add_image_size( 'blog-entry-image', 820, 500, TRUE );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 800,
	'height'          => 400,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav', 7 );

//* Add widget to primary navigation
add_filter( 'genesis_nav_items', 'market_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'market_social_icons', 10, 2 );

function market_social_icons($menu, $args) {
	$args = (array)$args;
	if ( 'primary' !== $args['theme_location'] )
		return $menu;
	ob_start();
	genesis_widget_area('nav-social-menu');
	$social = ob_get_clean();
	return $menu . $social;
}

//* Add search form to navigation
add_filter( 'wp_nav_menu_items', 'market_primary_nav_extras', 10, 2 );
function market_primary_nav_extras( $menu, $args ) {
	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu .= '<li class="right search">' . $search . '</li>';

	return $menu;
}

//* Add support for footer menu & rename menus
add_theme_support ( 'genesis-menus' , array ( 
	'primary'   => 'Above Header Menu', 
	'secondary' => 'Below Header Menu', 
	'footer'    => 'Footer Menu' 
) );

//* Hook menu in footer
add_action( 'genesis_before_footer', 'market_footer_menu', 7 );
function market_footer_menu() {

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

//* Reduce the footer navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'market_footer_menu_args' );
function market_footer_menu_args( $args ){

	if( 'footer' != $args['theme_location'] ){
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}
    
//* Reposition Featured Images
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

//* Position post info above post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Customize the Post Info Function
add_filter( 'genesis_post_info', 'market_post_info_filter' );
function market_post_info_filter( $post_info ) {

	$post_info = '[post_categories before="in " sep=" &middot "]';
    return $post_info;

}

//* Customize the Post Meta Function
add_filter( 'genesis_post_meta', 'market_post_meta' );
function market_post_meta( $post_meta ) {
    // Return the existing post info for pages or when plugin is not active
    if ( is_page() || ! function_exists( 'genesis_share_get_icon_output' ) ) {
        return $post_meta;
    }

    global $Genesis_Simple_Share;

    $share =  genesis_share_get_icon_output( 'entry-meta', $Genesis_Simple_Share->icons );
    $post_meta = '[post_comments] [post_edit]' .
    '<span class="alignright">' . $share . '</span>';

    return $post_meta;
}

//* Setup widget counts
function market_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function market_widget_area_class( $id ) {

	$count = market_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {	
		$class .= ' widget-halves even';
	}
	return $class;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'market_comments_gravatar' );
function market_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'market_author_box_gravatar' );
function market_author_box_gravatar( $size ) {

	return 200;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'market_remove_comment_form_allowed_tags' );
function market_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add Home Slider Overlay below Header
add_action( 'genesis_after_header', 'market_home_slider' );
function market_home_slider() {
	if( ! ( is_home() || is_front_page() ) ) {
		return;
	}
	
	if ( get_query_var( 'paged' ) >= 2 )
		return;
		
	if( function_exists( 'soliloquy' ) ) {
		echo '<div class="home-slider-container"><div class="home-slider">';
			soliloquy( 'home-slider', 'slug' );
		echo '</div>';

		genesis_widget_area( 'home-slider-overlay', array(
			'before'	=> '<div class="home-slider-overlay widget-area"><div class="wrap">',
			'after'		=> '</div></div></div>',
		) );
	}
}

//* Hooks Widget Area Above Content
add_action( 'genesis_after_header', 'market_widget_above_content'  ); 
function market_widget_above_content() {

if ( !is_home() ) {

    genesis_widget_area( 'widget-above-content', array(
		'before' => '<div class="widget-above-content widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}}

//* Hooks Widget Area Below Footer
add_action( 'genesis_before_footer', 'market_widget_below_footer', 10 ); 
function market_widget_below_footer() {

    genesis_widget_area( 'widget-below-footer', array(
		'before' => '<div class="widget-below-footer widget-area">',
		'after'  => '</div>',
    ) );

}

//* Load Entry Navigation
add_action( 'genesis_after_entry', 'genesis_prev_next_post_nav', 9 );

//* Customize the credits
add_filter('genesis_footer_creds_text', 'market_footer_creds_text');
function market_footer_creds_text( $creds ) {
    $creds = '<div class="creds">Copyright [footer_copyright] &middot; <a target="_blank" href="http://restored316designs.com/themes">Market theme</a> by <a target="_blank" href="http://www.restored316designs.com">Restored 316</a></div>';
    return $creds;
}

//* Add Theme Support for WooCommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//* Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}
