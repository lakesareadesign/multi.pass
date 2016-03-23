<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'sixteen-nine', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'sixteen-nine' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'sixteen_nine_customizer' );
function sixteen_nine_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Sixteen Nine Pro Theme', 'sixteen-nine' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/sixteen-nine/' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Playfair Display and Roboto family of Google fonts
add_action( 'wp_enqueue_scripts', 'sixteen_nine_google_fonts' );
function sixteen_nine_google_fonts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Playfair+Display:300italic|Roboto:300,700|Roboto+Condensed:300,700|Roboto+Slab:300', array(), PARENT_THEME_VERSION );

}

//* Enqueue Backstretch script and prepare images for loading
add_action( 'wp_enqueue_scripts', 'sixteen_nine_enqueue_scripts' );
function sixteen_nine_enqueue_scripts() {

	wp_enqueue_script( 'sixteen-nine-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	$image = get_option( 'sixteen-nine-backstretch-image', sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ) );

	//* Load scripts only if custom backstretch image is being used
	if ( ! empty( $image ) ) {

		wp_enqueue_script( 'sixteen-nine-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'sixteen-nine-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'sixteen-nine-backstretch' ), '1.0.0' );

		wp_localize_script( 'sixteen-nine-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );
	
	}

}

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'admin-preview-callback' => 'sixteen_nine_admin_header_callback',
	'default-text-color'     => 'ffffff',
	'header-selector'        => '.site-header .site-avatar img',
	'height'                 => 224,
	'width'                  => 224,
	'wp-head-callback'       => 'sixteen_nine_header_callback',
	'header-text'            => true,
) );

function sixteen_nine_admin_header_callback() {
	echo get_header_image() ? '<img src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
}

function sixteen_nine_header_callback() {

    if ( ! get_header_textcolor() )
        return;

    printf( '<style  type="text/css">.site-title a { color: #%s; }</style>' . "\n", get_header_textcolor() );
}

//* Add body class if header text option unchecked
add_filter( 'body_class', 'sixteen_nine_header_text_class' );
function sixteen_nine_header_text_class( $classes ) {

	if ( 'blank' == get_header_textcolor() ) {
		$classes[] = 'no-header-text';
	}
	return $classes;

}

//* Unregister layout settings
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister primary/secondary navigation menus
remove_theme_support( 'genesis-menus' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Hook site avatar before site title
add_action( 'genesis_header', 'sixteen_nine_site_gravatar', 5 );
function sixteen_nine_site_gravatar() {

	$header_image = get_header_image() ? '<img alt="" src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
	
	printf( '<div class="site-avatar"><a href="%s">%s</a></div>', home_url( '/' ), $header_image );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'sixteen_nine_author_box_gravatar' );
function sixteen_nine_author_box_gravatar( $size ) {

	return 140;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'sixteen_nine_comments_gravatar' );
function sixteen_nine_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'sixteen_nine_remove_comment_form_allowed_tags' );
function sixteen_nine_remove_comment_form_allowed_tags( $defaults ) {
	
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
add_filter( 'genesis_footer_output', 'sixteen_nine_custom_footer' );
function sixteen_nine_custom_footer( $output ) {

	$output = sprintf( '<p>%s<a href="http://www.studiopress.com/">%s</a></p>',  __( 'Powered by ', 'sixteen-nine' ), __( 'Genesis', 'sixteen-nine' ) );
	return $output;

}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );
