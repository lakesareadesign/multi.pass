<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'atmosphere', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'atmosphere' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Atmosphere Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/atmosphere/' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'atmosphere_scripts_styles' );
function atmosphere_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
	
	wp_enqueue_script( 'atmosphere-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'atmosphere' ),
		'subMenu'  => __( 'Menu', 'atmosphere' ),
	);
	wp_localize_script( 'atmosphere-responsive-menu', 'AtmosphereL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add screen reader class to archive description
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'Header Menu', 'atmosphere' ), 'secondary' => __( 'Footer Menu', 'atmosphere' ) ) );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'atmosphere_remove_genesis_metaboxes' );
function atmosphere_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Add Image Sizes
add_image_size( 'front-page-featured', 640, 640, TRUE );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 12 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'atmosphere_secondary_menu_args' );
function atmosphere_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

//* Remove skip link for primary navigation
add_filter( 'genesis_skip_links_output', 'atmosphere_skip_links_output' );
function atmosphere_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	return $links;

}

//* Remove sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove layout section from Theme Customizer
add_action( 'customize_register', 'atmosphere_customize_register', 16 );
function atmosphere_customize_register( $wp_customize ) {

	$wp_customize->remove_section( 'genesis_layout' );

}

//* Modify the entry title text
function atmosphere_title( $title ) {

	if ( genesis_get_custom_field( 'large_title' ) ) {
		$title = '<span class="atmosphere-large-text">' . genesis_get_custom_field( 'large_title' ) . '</span><span class="intro">' . $title . '</span>';
	}

	return $title;

}

//* Add entry title filter to posts and pages
add_action( 'genesis_entry_header', 'atmosphere_add_title_filter', 1 );
function atmosphere_add_title_filter() {

	if ( is_singular() ) {
		add_filter( 'the_title', 'atmosphere_title' );
	}

}

//* Remove post and page title filter after entry header
add_action( 'genesis_entry_header', 'atmosphere_remove_title_filter', 15 );
function atmosphere_remove_title_filter() {

	remove_filter( 'the_title', 'atmosphere_title' );

}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'atmosphere_content_limit_read_more_markup', 10, 3 );
function atmosphere_content_limit_read_more_markup( $output, $content, $link ) {	
	
	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'atmosphere_author_box_gravatar' );
function atmosphere_author_box_gravatar( $size ) {

	return 160;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'atmosphere_comments_gravatar' );
function atmosphere_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;
	return $args;

}

//* Remove the entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'atmosphere_remove_entry_footer' );
function atmosphere_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}

//* Setup widget counts
function atmosphere_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

//* Flexible widget classes
function atmosphere_widget_area_class( $id ) {

	$count = atmosphere_count_widgets( $id );

	$class = '';
	
	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {	
		$class .= ' widget-halves';
	}

	return $class;
	
}

//* Add support for 1-column footer widget
add_theme_support( 'genesis-footer-widgets', 1 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'atmosphere' ),
	'description' => __( 'This is the 1st section on the front page.', 'atmosphere' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'atmosphere' ),
	'description' => __( 'This is the 2nd section on the front page.', 'atmosphere' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'atmosphere' ),
	'description' => __( 'This is the 3rd section on the front page.', 'atmosphere' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'atmosphere' ),
	'description' => __( 'This is the 4th section on the front page.', 'atmosphere' ),
) );
