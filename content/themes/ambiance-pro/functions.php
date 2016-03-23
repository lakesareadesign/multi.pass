<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'ambiance', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'ambiance' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Ambiance Pro Theme', 'ambiance' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/ambiance/' );
define( 'CHILD_THEME_VERSION', '1.1.1' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'ambiance_load_scripts_styles' );
function ambiance_load_scripts_styles() {

	wp_enqueue_script( 'ambiance-effects', get_bloginfo( 'stylesheet_directory' ) . '/js/effects.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'ambiance-google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,900|Merriweather:400,700', array(), CHILD_THEME_VERSION );
	
	if ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() ) {

		wp_enqueue_script( 'ambiance-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'ambiance-backstretch-set', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch-set.js' , array( 'jquery', 'ambiance-backstretch' ), '1.0.0', true );
	
	}

}

//* Localize backstretch script
add_action( 'genesis_after', 'ambiance_set_background_image' );
function ambiance_set_background_image() {

	$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : '' );

	wp_localize_script( 'ambiance-backstretch-set', 'BackStretchImg', $image );

}

//* Add body class if no featured image
add_filter( 'body_class', 'ambiance_featured_img_body_class' );
function ambiance_featured_img_body_class( $classes ) {

	if ( is_singular( array( 'post', 'page' ) ) && ! has_post_thumbnail() ) {
		$classes[] = 'no-featured-image';
	}
	return $classes;

}

//* Hook entry background area
add_action( 'genesis_after_header', 'ambiance_entry_background' );
function ambiance_entry_background() {

	if ( is_singular( 'post' ) || ( is_singular( 'page' ) && has_post_thumbnail() ) ) {

		echo '<div class="entry-background"></div>';
	
	}

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add new featured image size
add_image_size( 'entry-image', 800, 450, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 360,
) );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'footer',
	'header',
	'site-inner',
	'subnav',
) );

//* Remove breadcrumb and navigation meta boxes
add_action( 'genesis_theme_settings_metaboxes', 'ambiance_remove_genesis_metaboxes' );
function ambiance_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Remove Content and Excerpt options from content archive metabox
add_filter( 'genesis_archive_display_options', 'ambiance_add_content_archive_display_option' );
function ambiance_add_content_archive_display_option( $options ) {
	unset( $options['full'] );
	unset( $options['excerpts'] );
	$options['nocontent'] = __( 'No Content', 'ambiance' );

	return $options;
}

//* Amend content archive toggles
add_filter( 'genesis_toggles', 'ambiance_amend_toggles' );
function ambiance_amend_toggles( $toggles ) {
	$toggles['content_archive'][2] = array_merge( (array) $toggles['content_archive'][2], array( 'nocontent' ) );
	
	return $toggles;
}

//* Remove unused sections from Theme Customizer
add_action( 'customize_register', 'ambiance_customize_register', 16 );
function ambiance_customize_register( $wp_customize ) {

	$wp_customize->remove_section( 'genesis_breadcrumbs' );
	$wp_customize->remove_control( 'genesis_content_archive' );
	$wp_customize->remove_control( 'genesis_content_archive_limit' );
	$wp_customize->remove_control( 'genesis_image_alignment' );
	
}

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reduce the primary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'ambiance_primary_menu_args' );
function ambiance_primary_menu_args( $args ){

	if( 'primary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'ambiance_secondary_menu_args' );
function ambiance_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Hook welcome message widget area before content
add_action( 'genesis_before_content_sidebar_wrap', 'ambiance_welcome_message' );
function ambiance_welcome_message() {

	if ( ! is_front_page() || get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'welcome-message', array(
		'before' => '<div class="welcome-message widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Customize the previous/older post navigation links
add_filter ( 'genesis_prev_link_text' , 'ambiance_prev_older_links_text' );
function ambiance_prev_older_links_text ( $text ) {

    return '&#x000AB;';

}

//* Customize the next/newer post navigation links
add_filter ( 'genesis_next_link_text' , 'ambiance_next_newer_links_text' );
function ambiance_next_newer_links_text ( $text ) {

    return '&#x000BB;';

}

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'ambiance_single_post_info_filter' );
function ambiance_single_post_info_filter( $post_info ) {

	$post_info = '[post_date] [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;

}

//* Output gravatar before entry title
add_action( 'genesis_entry_header', 'ambiance_gravatar', 7 );
function ambiance_gravatar() {

	if ( is_singular( 'post' ) ) {
		echo '<div class="entry-avatar">';
		echo get_avatar( get_the_author_meta( 'user_email' ), 240 );
		echo '</div>';
	}

}

//* Load entry navigation
add_action( 'genesis_after_entry', 'genesis_prev_next_post_nav', 9 );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'ambiance_author_box_gravatar' );
function ambiance_author_box_gravatar( $size ) {

	return 240;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'ambiance_comments_gravatar' );
function ambiance_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

//* Repositon the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 3 );

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'ambiance_remove_comment_form_allowed_tags' );
function ambiance_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'welcome-message',
	'name'        => __( 'Welcome Message', 'ambiance' ),
	'description' => __( 'This is the welcome message widget area.', 'ambiance' ),
) );
