<?php
/**
 * Slush Pro.
 *
 * This file adds functions to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Starts the engine.
require_once( get_template_directory() . '/lib/init.php' );

// Sets Localization.
load_child_theme_textdomain( 'slush-pro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'slush-pro' ) );

// Includes bootstrap inclusion function.
include( get_stylesheet_directory() . '/include/bootstrap_class_inclusion.php' );

// Adds custom meta boxes.
require_once( get_stylesheet_directory() . '/include/cpt/super-cpt.php' );
require_once( get_stylesheet_directory() . '/include/cpt/zp_cpt.php' );

// Includes ZP custom loop.
require_once ( get_stylesheet_directory() . '/include/zp_custom_loop.php' );

// Includes additional theme functions.
require_once ( get_stylesheet_directory() . '/include/theme_functions.php' );

// Includes theme customizer.
require_once( get_stylesheet_directory() . '/include/customizer/customizer.php' );

// Includes widgets.
require_once( get_stylesheet_directory() . '/include/widgets/class-carousel-widget.php' );
require_once( get_stylesheet_directory() . '/include/widgets/class-post-box-widget.php' );
require_once( get_stylesheet_directory() . '/include/widgets/class-post-slider-widget.php' );

// Defines child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Slush' );
define( 'CHILD_THEME_URL', 'http://demo.zigzagpress.com/slush/' );
define( 'CHILD_THEME_VERSION', '1.2.0' );

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Adds title tag support.
add_theme_support( 'title-tag' );

// Adds mobile viewport support.
add_theme_support( 'genesis-responsive-viewport' );

// Adds support for custom background.
add_theme_support( 'custom-background', array(
	'default-color' => 'ffffff',
	'default-image' => get_stylesheet_directory_uri() . '/images/noise-bg.png',
) );

// Adds support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array( 'footer-widgets' ) );

// Adds support for post formats.
add_theme_support( 'post-formats', array( 'audio','gallery','link','quote','video', 'image') );

// Adds 3 footer widget areas.
add_theme_support( 'genesis-footer-widgets', 3 );

// Repositions Primary Navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

// Repositions Secondary Navigation.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );

// Adds secondary navigation wrapper open.
add_action( 'genesis_before_header', 'zp_secondary_nav_wrap_open', 9 );
function zp_secondary_nav_wrap_open() {

	if ( has_nav_menu( 'secondary' ) ) {
		echo '<div class="zp_secondary_nav_wrap navbar"><div class="container"><div class="row">';
	}

}

// Adds secondary navigation wrapper close.
add_action( 'genesis_before_header', 'zp_secondary_nav_wrap_close', 11 );
function zp_secondary_nav_wrap_close() {

	if ( has_nav_menu( 'secondary' ) ) {
		echo '</div></div></div>';
	}

}

// Unregisters secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Adds after entry widget area.
add_theme_support( 'genesis-after-entry-widget-area' ); 

// Unregisters layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Adds Tinymice Editor styles.
add_action( 'after_setup_theme', 'zp_add_editor_styles' );
function zp_add_editor_styles() {

	add_editor_style( get_stylesheet_directory_uri() . '/css/zp_editor_style.css' );

}

// Enqueues Google Font
add_action( 'wp_enqueue_scripts', 'zp_google_font', 5 );
function zp_google_font() {

	$fnt = '';
	$query_args = array();

	if ( get_theme_mod( 'body_font' ) ||  get_theme_mod( 'head_font' ) ) {

		$fnt = $fnt_wt = '';
		$font_option = array( 'body_font', 'head_font' );
		$font_weight_option = array( 'body_font_weight', 'head_font_weight' );
		$i = 0;

		while ( $i < count( $font_option ) ) {
			if ( get_theme_mod( $font_option[$i] ) ) {
				$font_family = str_replace( ' ', '+', get_theme_mod( $font_option[$i] ) );
				$font_style = ( get_theme_mod( $font_weight_option[$i] ) != '' ) ? get_theme_mod( $font_weight_option[$i] ) : '';

				if ( $i != 3 ) {
					$fnt = $fnt . $font_family . ':' . $font_style . '|';
				} else {
					$fnt = $fnt . $font_family . ':' . $font_style;
				}

			}
			$i++;
		}

		$query_args = array(
			'family' => $fnt,
		);
	}

	if ( get_theme_mod( 'body_font' ) ) {
		$query_args = $query_args;
	} elseif ( get_theme_mod( 'head_font' ) ) {
		$query_args = $query_args;
	} else {
		$query_args = array(
			'family' => apply_filters( 'zp_default_font', 'Playfair+Display:400,400i|Poppins:300,400,500' ),
		);
	}

	wp_enqueue_style( 'zp_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

}

// Adds additional stylesheets.
add_action( 'wp_enqueue_scripts', 'zp_print_styles' );
function zp_print_styles() {

	wp_enqueue_style( 'bootstrap_css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'fontawesome_css', get_stylesheet_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'magnific_popup', get_stylesheet_directory_uri() . '/css/magnific-popup.min.css' );
	wp_enqueue_style( 'app_css', get_stylesheet_directory_uri() . '/css/app.min.css' );
	wp_enqueue_style( 'dashicons' );
	wp_register_style( 'jquery-swiper', get_stylesheet_directory_uri() . '/css/swiper.min.css' );

	// Adds Mobile stylesheet.
	wp_register_style( 'mobile', get_stylesheet_directory_uri() . '/css/mobile.css' );
	wp_enqueue_style( 'mobile' );

	// Adds custom stylesheet.
	wp_register_style( 'custom', get_stylesheet_directory_uri() . '/custom.css' );
	wp_enqueue_style( 'custom' );

}

// Enqueues theme scripts.
add_action( 'wp_enqueue_scripts', 'zp_theme_js' );
function zp_theme_js() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap.min', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', '', '3.0', true );
	wp_enqueue_script( 'jquery.fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', '', '1.0.3', true );
	wp_enqueue_script( 'jquery_jplayer', get_stylesheet_directory_uri() . '/js/jquery.jplayer.min.js', '', '2.5.0' );
	wp_enqueue_script( 'jquery_scrollTo_js', get_stylesheet_directory_uri() . '/js/jquery.ScrollTo.min.js', '', '1.4.3.1', true );
	wp_enqueue_script( 'jquery.isotope.min', get_stylesheet_directory_uri() . '/js/jquery.isotope.min.js', '', '2.2.2', true  );
	wp_enqueue_script( 'magnific_popup', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.js', '', '1.0', true );
	wp_enqueue_script( 'imageloaded', get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js', '', '4.1.1', true );
	wp_enqueue_script( 'custom_js', get_stylesheet_directory_uri() . '/js/custom.js', '', '1.0', true );
	wp_register_script( 'zp_post_like', get_stylesheet_directory_uri() . '/js/zp_post_like.js', '', '1.0', true );
	wp_register_script( 'zp_post_load_more', get_stylesheet_directory_uri() . '/js/zp_post_load_more.js', '', time(), true );
	wp_register_script( 'jquery-swiper', get_stylesheet_directory_uri( ) . '/js/swiper.jquery.min.js' );

	if ( is_home() || is_archive() || is_single() || is_search() || is_date() ) {
		// Enqueues script.
		wp_enqueue_script( 'zp_post_like' );
		wp_localize_script( 'zp_post_like', 'zp_post_like', 
			array(
				'ajax_url' => admin_url('admin-ajax.php')
			)
		);
	}

}

// Adds Home Before Loop widget area.
add_action( 'genesis_before_loop', 'zp_home_top_widget_area', 5 );
function zp_home_top_widget_area() {

	if ( is_active_sidebar( 'home-before-loop' ) && is_home() ) {
		echo '<div class="home-before-loop">';
			dynamic_sidebar( 'home-before-loop' );
		echo '</div>';
	}

}

// Sets Jetpack Tiled Galleries width.
if ( ! isset( $content_width ) ) {
	$content_width = 702;
}

// Modifies footer credits.
add_filter( 'genesis_footer_creds_text', 'zp_footer_creds_text' );
function zp_footer_creds_text() {
	
	$cred_text = '<div class="creds"><p>' . __( 'Copyright', 'slush-pro' ) . ' &copy; ' . date('Y') . ' ' . get_bloginfo( 'name' ) . ' ' . get_bloginfo( 'description' ) . '</p></div>';

	// Modifies left footer area.
	$footer_logo_image = get_theme_mod( 'footer_logo' );
	if ( $footer_logo_image ) {
		$footer_logo = '<img src="' . $footer_logo_image . '" alt="' . get_bloginfo( 'name' ) . '"  />';
	} else {
		$footer_logo = '<h2 class="footer_logo">' . get_bloginfo() . '</h2>';
	}

	echo '<div class="zp_footer_left col-md-12">';
	echo '<div class="zp_footer_logo_area">' . apply_filters( 'zp_footer_logo', $footer_logo, $footer_logo_image ) . '</div>';
	echo '</div>';

	// Modifies right footer area.
	echo '<div class="zp_footer_right col-md-12">';
	if ( get_theme_mod( 'footer_text' ) ) {
		echo '<div class="creds">' . get_theme_mod( 'footer_text' ) . '</div>';
	} else {
		echo $cred_text;
	}
	echo '</div>';

}

// Enables shortcode in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

// Removes post images.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Adds theme logo support.
add_theme_support( 'custom-logo', array(
	'height' => 50,
	'width'  => 173,
) );

// Filters Genesis site title to enable logo.
add_action( 'get_header', 'zp_custom_logo_option' );
function zp_custom_logo_option() {

	if ( has_custom_logo() ) {
		// Removes site title and site description.
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		// Displays new custom logo.
		add_action( 'genesis_site_title', 'zp_custom_logo' );
	}

}

// Adds custom logo function.
function zp_custom_logo() {

	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

// Adds Mobile Nav inside <nav> primary.
remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
add_filter( 'wp_nav_menu', 'zp_mobile_nav', 10, 2 );
function zp_mobile_nav( $menu, $args ) {

	$output = '';
	if ( 'primary' == $args->theme_location ) {
		$output .= '<div class="mobile_menu navbar-default" role="navigation"><button type="button" class="navbar-toggle" >';
		$output .= '<span class="icon-bar icon-first"></span><span class="icon-bar icon-second"></span><span class="icon-bar icon-third"></span>';
		$output .= '</button><span class="mobile_menu_label">' . __( 'MENU', 'slush-pro' ) . '</span></div>';
	}

	return $output . $menu;

}

// Modifies read more text.
add_filter( 'excerpt_more', 'zp_read_more_link' );
add_filter( 'get_the_content_more_link', 'zp_read_more_link' );
add_filter( 'the_content_more_link', 'zp_read_more_link' );
function zp_read_more_link() {

	$readmore_text = get_theme_mod( 'read_more' );	
	$readmore_text = ( $readmore_text != '' ) ? $readmore_text : __( 'Read More ', 'slush-pro' ) . '&hellip;';		
    return '&hellip; <div><a class="more-link" href="' . get_permalink() . '">' . $readmore_text . '</a></div>';

}

// Modifies the post info.
add_filter( 'genesis_post_info', 'zp_custom_post_info' );
function zp_custom_post_info() {

	$blog_author = get_theme_mod( 'blog_author' );
	$blog_comment = get_theme_mod( 'blog_comment' );
	$blog_like = get_theme_mod( 'blog_like' );
	$blog_read = get_theme_mod( 'blog_read' );
	$blog_date = get_theme_mod( 'blog_date' );

	// Adds post info labels.
	$blog_author_label = get_theme_mod( 'blog_author_label' );
	$blog_comment_label = get_theme_mod( 'blog_comment_label' );
	$blog_read_label = get_theme_mod( 'blog_read_label' );
	$blog_date_label = get_theme_mod( 'blog_date_label' );

	$blog_author_label = ( $blog_author_label ) ? $blog_author_label : '';
	$blog_comment_label = ( $blog_comment_label ) ? $blog_comment_label : __( "Comments ", "slush" );
	$blog_read_label = (  $blog_read_label ) ? $blog_read_label : '';
	$blog_date_label = ( $blog_date_label ) ? $blog_date_label : '';

	$blog_author = 	( $blog_author ) ? '[post_author_posts_link before="' . $blog_author_label . ' "]' : '';
	$blog_comment = ( $blog_comment ) ? ' [post_comments before="' . $blog_comment_label . ' " more="(%)" one="(1)" zero="" ]' : '';
	$blog_like = ( $blog_like ) ? ' [zp_post_like]' : '';
	$blog_read = ( $blog_read ) ? ' [zp_post_read label="' . $blog_read_label . '"]' : '';
	$blog_date = ( $blog_date ) ? '[post_date before="' . $blog_date_label . '" ]' : '';

	return $blog_date . $blog_author . $blog_comment;

}

// Modifies post meta.
add_filter( 'genesis_post_meta','zp_custom_post_meta' );
function zp_custom_post_meta() {

	$blog_date = get_theme_mod( 'blog_date' );
	$blog_tag = get_theme_mod( 'blog_tags' );
	$blog_category = get_theme_mod( 'blog_categories' );
	$blog_like = get_theme_mod( 'blog_like' );
	$blog_read = get_theme_mod( 'blog_read' );

	// Adds post meta labels.
	$blog_date_label = get_theme_mod( 'blog_date_label' );
	$blog_read_label = get_theme_mod( 'blog_read_label' );

	$blog_date_label = ( $blog_date_label ) ? $blog_date_label : '';
	$blog_read_label = (  $blog_read_label ) ? $blog_read_label : '';

	$blog_date = ( $blog_date ) ? '[post_date before="<strong>' . $blog_date_label . '</strong>" ]' : '';
	$blog_category = ( $blog_category ) ? ' [post_categories before="" after="" sep=","]' : '';
	$blog_tag = ( $blog_tag ) ? '[post_tags before="" after="" sep=","]' : '';
	$blog_like = ( $blog_like ) ? ' [zp_post_like]' : '';
	$blog_read = ( $blog_read ) ? ' [zp_post_read label="' . $blog_read_label . '"]' : '';
	
	return '<span class="entry-footer-left">' . $blog_tag . $blog_category . '</span><span class="entry-footer-right">' . $blog_read . $blog_like . '</span>';	

}

// Repositions post info.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

// Adds Contact Form 7 shortcode support.
add_filter( 'wpcf7_form_elements', 'zp_wpcf7_form_elements' );
function zp_wpcf7_form_elements( $form ) {

	$form = do_shortcode( $form );
	return $form;

}

// Add image sizes.
add_image_size( 'blog_gallery', 786, 524, true );
add_image_size( 'col2' , 540 );
add_image_size( 'col3', 408 );
add_image_size( 'col4' , 255 );
add_image_size( 'related_col2' , 555 );
add_image_size( 'related_col3', 360 );
add_image_size( 'related_col4' , 262 );
add_image_size( 'related_post', 217, 217, true );
add_image_size( 'blog-archive', 863, 575, true );
add_image_size( 'post-box', 326, 245, true );
add_image_size( 'post-box-top', 703, 528, true );
add_image_size( 'post-small', 413, 275, true );
add_image_size( 'post-slider', 1200, 600, true );

// Adds Infinite Scroll support.
add_theme_support( 'infinite-scroll', array(
	'container'      => 'content_scrolling',
	'render'         => 'zp_blog_loop',
	'type'           => 'scroll',
	'footer_widgets' => false,
	'footer'         => 'zp-footer',
) );

// Removes post nav when infinite scroll is active.
add_action ( 'genesis_after_entry', 'zp_remove_pagination' );
function zp_remove_pagination() {

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
	}

}

// Adds Nav attributes.
add_filter( 'genesis_attr_sticky_nav', 'genesis_attributes_nav' );

// Adds Nav attributes to top link.
add_action( 'genesis_before_footer','zp_add_top_link' );
function zp_add_top_link(){

	echo '<a href="#top" id="top-link"><i class="fa fa-angle-up"></i></a>';

}

// Adds widget area after the header.
add_action( 'genesis_after_header', 'zp_widget_area_after_header' );
function zp_widget_area_after_header() {

	if ( is_home() ) {
		if ( is_active_sidebar( 'home-widget' ) ) {
			echo '<div class="home-widget"><div class="container"><div class="row">';
				dynamic_sidebar( 'home-widget' );
			echo '</div></div></div>';
		}
	}

}

// Adds Theme Support for WooCommerce.
add_theme_support( 'genesis-connect-woocommerce' );

// Removes related products.
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Changes number of products per row to 3.
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 3; // Defines 3 products per row.
	}
}

// Adds header layout body class.
add_filter( 'body_class', 'zp_header_layout_class' );
function zp_header_layout_class( $classes ) {

	$layout = get_theme_mod( 'zp_header_layout' );
	if ( $layout ) {
		return array_merge( $classes, array( $layout ) );
	} else {
		return $classes;
	}

}

// Sets a sidebar specific to shop and product pages.
add_action( 'get_header', 'zp_shop_sidebar' );
function zp_shop_sidebar() {

	if ( class_exists( 'Woocommerce' ) ) {
		if ( is_shop() || is_singular( 'product' ) || is_tax( 'product_cat' ) ) {
			remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
			add_action( 'genesis_after_content', 'zp_get_shop_sidebar' );
		}
	}

}

// Adds a sidebar for shop and product pages.
function zp_get_shop_sidebar() {

	$site_layout = genesis_site_layout();

	if ( 'content-sidebar' == $site_layout || 'sidebar-content' == $site_layout ) {
	?>
	<aside class="sidebar sidebar-primary widget-area" role="complementary" aria-label="Primary Sidebar" itemscope="" itemtype="http://schema.org/WPSideBar">
	<?php
		genesis_structural_wrap( 'sidebar' );
		do_action( 'genesis_before_sidebar_widget_area' );
		dynamic_sidebar( 'shop-sidebar' );
		do_action( 'genesis_after_sidebar_widget_area' );
		genesis_structural_wrap( 'sidebar', 'close' );
	?>
	</aside>
	<?php 
	}

}

// Replaces search text with icon.
add_filter( 'genesis_search_button_text', 'zp_search_button_icon' );
function zp_search_button_icon( $text ) {

	return esc_attr( '&#xf179;' );

}

// Displays 12 products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// Registers Widget Areas.
genesis_register_sidebar( array(
	'id'          => 'portfolio-sidebar',
	'name'        => __( 'Portfolio Sidebar', 'slush-pro' ),
	'description' => __( 'This is the sidebar for the portfolio single page.', 'slush-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'home-widget',
	'name'        => __( 'Home Widget', 'slush-pro' ),
	'description' => __( 'This is the homepage widget area.', 'slush-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'home-before-loop',
	'name'        => __( 'Home Before Loop', 'slush-pro' ),
	'description' => __( 'This is a widget area before loop in the homepage.', 'slush-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'shop-sidebar',
	'name'        => __( 'Shop Sidebar', 'slush-pro' ),
	'description' => __( 'This the sidebar for the shop and product pages.', 'slush-pro' ),
) );

/**
 * Includes Custom Theme Functions.
 *
 * Write all your custom functions in this file.
 */ 
require_once( get_stylesheet_directory() . '/include/custom_functions.php' );