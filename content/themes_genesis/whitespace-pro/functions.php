<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'whitespace', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'whitespace' ) );

//* Add Image upload to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Whitespace Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/whitespace/' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'whitespace_scripts_styles' );
function whitespace_scripts_styles() {

	wp_enqueue_script( 'mobile-first-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700|Neuton:400|Playfair+Display:400italic', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 250,
	'height'          => 60,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add new image sizes
add_image_size( 'entry-image', 720, 300, TRUE );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'whitespace' ), 'secondary' => __( 'After Header Menu', 'whitespace' ) ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'whitespace_remove_genesis_metaboxes' );
function whitespace_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove unused sections from Theme Customizer
add_action( 'customize_register', 'whitespace_customize_register', 16 );
function whitespace_customize_register( $wp_customize ) {

	$wp_customize->remove_control( 'genesis_posts_nav' );
	
	$wp_customize->remove_section( 'genesis_layout' );
	
}

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Add article-wrap
add_action( 'genesis_entry_header', 'whitespace_entry_wrap', 2 );
function whitespace_entry_wrap() {

	//* Remove if not single post
	if ( ! is_singular() ) {
		echo '<div class="article-wrap">';
	}
	
}

add_action( 'genesis_entry_footer', 'whitespace_entry_wrap_close', 16 );
function whitespace_entry_wrap_close() {

	//* Remove if not single post
	if ( ! is_singular() ) {
		echo '</div>';
	}
}

//* Reposition the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 7 );

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'whitespace_entry_meta_header' );
function whitespace_entry_meta_header( $post_info ) {

	if ( is_single() ) {	
		$post_info = '[post_date format="d M Y"] [post_edit]';	
	} else {	
		$post_info = '[post_date format="d M Y"]';	
	}
	return $post_info;
 
}

//* Remove entry meta in entry footer
add_action( 'genesis_before_entry', 'whitespace_remove_entry_meta' );
function whitespace_remove_entry_meta() {
	
	//* Remove if not single post
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}

}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'whitespace_read_more_link' );
function whitespace_read_more_link() {

	return '';
	
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'whitespace_author_box_gravatar' );
function whitespace_author_box_gravatar( $size ) {

	return 160;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'whitespace_comments_gravatar' );
function whitespace_comments_gravatar( $args ) {

	$args['avatar_size'] = 100;
	return $args;

}

//* Customize the next page link in the entry navigation
add_filter ( 'genesis_next_link_text' , 'whitespace_next_page_link' );
function whitespace_next_page_link ( $text ) {
 
    return '&raquo;';
 
}

//* Customize the previous page link in the entry navigation
add_filter ( 'genesis_prev_link_text' , 'whitespace_previous_page_link' );
function whitespace_previous_page_link ( $text ) {
 
    return '&laquo;';
 
}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Hook social widget area before site footer
add_action( 'genesis_footer', 'whitespace_social_widget_area', 7 );
function whitespace_social_widget_area() {
 
	genesis_widget_area( 'social', array(
		'before' => '<div class="social">',
		'after'  => '</div>',
	) );
 
}

//* Register welcome widget area
genesis_register_sidebar( array(
	'id'          => 'welcome',
	'name'        => __( 'Welcome', 'whitespace' ),
	'description' => __( 'This is the home welcome section.', 'whitespace' ),
) );

genesis_register_sidebar( array(
	'id'          => 'social',
	'name'        => __( 'Social', 'whitespace' ),
	'description' => __( 'This is the footer social section.', 'whitespace' ),
) );
