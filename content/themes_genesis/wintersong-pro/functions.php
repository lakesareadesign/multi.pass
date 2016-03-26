<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'wintersong', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'wintersong' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Wintersong Pro Theme', 'wintersong' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/wintersong/' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts
add_action( 'wp_enqueue_scripts', 'wintersong_enqueue_scripts' );
function wintersong_enqueue_scripts() {

	wp_enqueue_script( 'wintersong-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_style( 'google-font-roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300|Roboto+Slab:300,400', array(), CHILD_THEME_VERSION );

}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'admin-preview-callback' => 'wintersong_admin_header_callback',
	'default-text-color'     => '000000',
	'header-selector'        => '.site-header .site-avatar img',
	'height'                 => 224,
	'width'                  => 224,
	'wp-head-callback'       => 'wintersong_header_callback',
) );

function wintersong_admin_header_callback() {
	echo get_header_image() ? '<img src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
}

function wintersong_header_callback() {

	if ( ! get_header_textcolor() )
		return;

	printf( '<style  type="text/css">.site-title a { color: #%s; }</style>' . "\n", get_header_textcolor() );

	if ( get_header_image() )
		return;

	if ( ! display_header_text() )
	add_filter( 'body_class', 'wintersong_header_image_body_class' );

}

//* Add custom body class for header-text
function wintersong_header_image_body_class( $classes ) {
	$classes[] = 'header-image';
	return $classes;
}

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'wintersong' ) ) );

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Hook site avatar before site title
add_action( 'genesis_header', 'wintersong_site_gravatar', 5 );
function wintersong_site_gravatar() {

	$header_image = get_header_image() ? '<img alt="" src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
	printf( '<div class="site-avatar"><a href="%s">%s</a></div>', home_url( '/' ), $header_image );

}

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'wintersong_author_box_gravatar_size' );
function wintersong_author_box_gravatar_size( $size ) {

	return '144';

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'wintersong_comments_gravatar' );
function wintersong_comments_gravatar( $args ) {

    $args['avatar_size'] = 112;
	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'wintersong_remove_comment_form_allowed_tags' );
function wintersong_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}


//* Reposition the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_header', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_header', 'genesis_do_footer', 12 );
add_action( 'genesis_header', 'genesis_footer_markup_close', 13 );

//* Customize the footer
add_filter( 'genesis_footer_output', 'wintersong_custom_footer' );
function wintersong_custom_footer( $output ) {

	$output = sprintf( '<p>%s<a href="http://www.studiopress.com/">%s</a></p>',  __( 'Powered by ', 'wintersong' ), __( 'Genesis', 'wintersong' ) );
	return $output;

}
