<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'the-411', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'the-411' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'the_411_customizer' );
function the_411_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'The 411 Pro Theme', 'the-411' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/the-411/' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'the_411_google_fonts' );
function the_411_google_fonts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400|Roboto+Slab:300,400', array(), CHILD_THEME_VERSION );

}

//* Enqueue Backstretch script and prepare images for loading
add_action( 'wp_enqueue_scripts', 'the_411_enqueue_scripts' );
function the_411_enqueue_scripts() {

	wp_enqueue_script( 'the-411-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	$image = get_option( 'the-411-backstretch-image', sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ) );
	
	//* Load scripts only if custom backstretch image is being used
	if ( ! empty( $image ) ) {

		wp_enqueue_script( 'the-411-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'the-411-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'the-411-backstretch' ), '1.0.0' );

		wp_localize_script( 'the-411-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );
	
	}

}

//* Add support for custom background
add_theme_support( 'custom-background' ); 

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 200,
	'height'          => 60,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for post formats
add_theme_support( 'post-formats', array(
	'quote',
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister sidebars
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove breadcrumb and navigation meta boxes
add_action( 'genesis_theme_settings_metaboxes', 'the_411_remove_genesis_metaboxes' );
function the_411_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'the_411_secondary_menu_args' );
function the_411_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove elements with post formats
add_action( 'genesis_before_entry', 'the_411_remove_elements' );
function the_411_remove_elements() {
	
	//* Remove if post has format
	if ( get_post_format() ) {
	
		add_filter( 'genesis_pre_get_option_content_archive', 'the_411_format_content' );
		add_filter( 'genesis_pre_get_option_content_archive_limit', 'the_411_content_limit' );
		add_filter( 'genesis_pre_get_option_content_archive_thumbnail', '__return_false' );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		
	}
	//* Add back, as post has no format
	else {
	
		remove_filter( 'genesis_pre_get_option_content_archive', 'the_411_format_content' );
		remove_filter( 'genesis_pre_get_option_content_archive_limit', 'the_411_content_limit' );
		remove_filter( 'genesis_pre_get_option_content_archive_thumbnail', '__return_false' );
		add_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		add_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		add_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		add_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		add_action( 'genesis_entry_footer', 'genesis_post_meta' );
		
	}

}

function the_411_format_content() {
	return 'full';
}

function the_411_content_limit() {
	return '0';
}

//* Hook social icons and click here widget areas
add_action( 'genesis_after_header', 'the_411_extras' );
function the_411_extras() {

	if ( is_active_sidebar( 'social-icons' ) || is_active_sidebar( 'click-here' ) ) {

 		echo '<div class="site-extras">';

 		genesis_widget_area( 'social-icons', array(
			'before'	=> '<div class="social-icons">',
			'after'		=> '</div>'
		) );

		genesis_widget_area( 'click-here', array(
			'before'	=> '<div class="click-here">',
			'after'		=> '</div>'
		) );

		echo '</div>';

	}

}

//* Hook welcome message widget area before content
add_action( 'genesis_before_loop', 'the_411_welcome_message' );
function the_411_welcome_message() {

	if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'welcome-message', array(
		'before' => '<div class="welcome-message widget-area">',
		'after'  => '</div>',
	) );

}

//* Remove entry meta in entry footer
add_action( 'genesis_before_entry', 'the_411_remove_entry_meta' );
function the_411_remove_entry_meta() {
	
	//* Remove if not single post
	if ( ! is_single() ) {
	
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		
	}

}

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'the_411_read_more' );
function the_411_read_more() {

	return '<a class="more-link" href="' . get_permalink() . '">' . __( 'Continue Reading', 'the-411' ) . '</a>';

}

//* Modify the content limit read more link
add_action( 'genesis_before_loop', 'the_411_more' );
function the_411_more() {

	add_filter( 'get_the_content_more_link', 'the_411_read_more' );
	
}

add_action( 'genesis_after_loop', 'the_411_remove_more' );
function the_411_remove_more() {

	remove_filter( 'get_the_content_more_link', 'the_411_read_more' );
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'the_411_remove_comment_form_allowed_tags' );
function the_411_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'the_411_author_box_gravatar' );
function the_411_author_box_gravatar( $size ) {

	return 140;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'the_411_comments_gravatar' );
function the_411_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'welcome-message',
	'name'        => __( 'Welcome Message', 'the-411' ),
	'description' => __( 'This is the welcome message widget area.', 'the-411' ),
) );
genesis_register_sidebar( array(
	'id'          => 'social-icons',
	'name'        => __( 'Social Icons', 'the-411' ),
	'description' => __( 'This is the social icons widget area.', 'the-411' ),
) );
genesis_register_sidebar( array(
	'id'          => 'click-here',
	'name'        => __( 'Click Here', 'the-411' ),
	'description' => __( 'This is the click here widget area.', 'the-411' ),
) );
