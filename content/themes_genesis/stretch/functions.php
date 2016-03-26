<?php
/** Start the engine */
include_once( get_template_directory() . '/lib/init.php' );

/** Set Localization (do not remove) */
load_child_theme_textdomain( 'stretch', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'stretch' ) );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', __( 'Stretch Theme', 'stretch' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/stretch' );
define( 'CHILD_THEME_VERSION', '1.0.2' );

/** Add viewport meta tag for mobile browsers */
add_theme_support( 'genesis-responsive-viewport' );

/** Add support for custom header */
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '#title-area a',
	'header-text'     => false,
	'height'          => 48,
	'width'           => 220,
) );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array(
	'stretch-blue'		=>	__( 'Blue', 'stretch' ),
	'stretch-green'		=>	__( 'Green', 'stretch' ),
	'stretch-orange'	=>	__( 'Orange', 'stretch' ),
	'stretch-pink'		=>	__( 'Pink', 'stretch' ),
	'stretch-purple'	=>	__( 'Purple', 'stretch' ),
) );

/** Unregister primary/secondary navigation menus */
remove_theme_support( 'genesis-menus' );

/** Register default layout setting */
genesis_set_default_layout( 'full-width-content' );

/** Unregister layouts */
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/** Unregister sidebars */
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

/** Customize the previous/older post navigation links */
add_filter ( 'genesis_prev_link_text' , 'stretch_prev_older_links_text' );
add_filter ( 'genesis_older_link_text' , 'stretch_prev_older_links_text' );
function stretch_prev_older_links_text ( $text ) {
    return g_ent( '&#x000AB;' );
}

/** Customize the next/newer post navigation links */
add_filter ( 'genesis_next_link_text' , 'stretch_next_newer_links_text' );
add_filter ( 'genesis_newer_link_text' , 'stretch_next_newer_links_text' );
function stretch_next_newer_links_text ( $text ) {
    return g_ent( '&#x000BB;' );
}

/** Limit main query to one post */
add_action( 'pre_get_posts', 'stretch_set_main_posts_per_page' );
function stretch_set_main_posts_per_page( $query ) {

	if( $query->is_main_query() && ! is_admin() ) {
		$query->set( 'posts_per_page', '1' );
	}

}

/** Limit blog template to one post */
add_filter( 'genesis_pre_get_option_blog_cat_num', 'stretch_blog_cat_num' );
function stretch_blog_cat_num( $option ){
	return 1;
}

/** Add metabox for Strech default/fallback background image */
add_action( 'genesis_theme_settings_metaboxes', 'stretch_theme_settings_metaboxes', 10, 1 );
function stretch_theme_settings_metaboxes( $pagehook ) {

	add_meta_box( 'stretch-default-background-image', __( 'Stretch - Default Image', 'stretch' ), 'stretch_default_background_image_metabox', $pagehook, 'main', 'high' );

}

/** Content for the default/fallback image metabox */
function stretch_default_background_image_metabox() {

	printf( '<label for="%s[%s]" /><br />', GENESIS_SETTINGS_FIELD, 'stretch_default_image' );
	printf( '<input type="text" name="%1$s[%2$s]" id="%1$s[%1$s]" size="75" value="%3$s" />', GENESIS_SETTINGS_FIELD, 'stretch_default_image', genesis_get_option( 'stretch_default_image' ) );
	
}

/** Load Backstretch script and prepare images for loading */
add_action( 'wp_enqueue_scripts', 'stretch_enqueue_scripts' );
function stretch_enqueue_scripts() {

if ( ! genesis_get_option( 'stretch_default_image' ) && ! has_post_thumbnail() )
		return;

	wp_enqueue_script( 'stretch-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'stretch-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'stretch-backstretch' ), '1.0.0', true );
	
}

add_action( 'genesis_after_post', 'stretch_set_background_image' );
function stretch_set_background_image() {

	$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : genesis_get_option( 'stretch_default_image' ) );

	wp_localize_script( 'stretch-backstretch-set', 'BackStretchImg', $image );

}