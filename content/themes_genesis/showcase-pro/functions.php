<?php
/**
 * Showcase Pro
 *
 * This file adds functions to the Showcase Pro Theme.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */

add_action( 'genesis_setup', 'showcase_theme_setup', 15 );
function showcase_theme_setup() {

	// Child theme (do not remove)
	define( 'CHILD_THEME_NAME', 'Showcase Pro' );
	define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/showcase/' );
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Set up Theme Customizer
	require_once( get_stylesheet_directory() . '/inc/customize.php' );

	// Include Customizer CSS
	include_once( get_stylesheet_directory() . '/inc/output.php' );

	// Entry Grid Shortcode
	include_once( get_stylesheet_directory() . '/inc/entry-grid-shortcode.php' );

	// Add the required WooCommerce functions
	include_once( get_stylesheet_directory() . '/inc/woocommerce/woocommerce-setup.php' );

	// Include notice to install Genesis Connect for WooCommerce
	include_once( get_stylesheet_directory() . '/inc/woocommerce/woocommerce-notice.php' );

	// Enable shortcodes in text widgets
	add_filter('widget_text','do_shortcode');

	// Enqueue scripts and styles
	add_action( 'wp_enqueue_scripts', 'showcase_scripts_styles' );

	// Theme Setting Defaults
	add_filter( 'genesis_theme_settings_defaults', 'showcase_theme_defaults' );
	add_action( 'after_switch_theme', 'showcase_theme_setting_defaults' );

	// Simple Social Icon Defaults
	add_filter( 'simple_social_default_styles', 'showcase_social_default_styles' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Add accessibility support
	add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

	// Add Structural Wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'subnav',
		'site-inner',
		'footer-widgets',
		'footer'
	) );

	// Add screen reader class to archive description
	add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'width'           => 400,
		'height'          => 150,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'flex-height'     => true,
	) );

	// Add Image Sizes
	add_image_size( 'showcase_featured_posts', 600, 400, TRUE );
	add_image_size( 'showcase_archive', 900, 500, TRUE );
	add_image_size( 'showcase_entry_grid', 600, 800, TRUE );
	add_image_size( 'showcase_hero', 1600, 1050, TRUE );

	// Add Page Header
	add_action( 'genesis_after_header', 'showcase_page_header', 8 );

	// Add with-page-header body class
	add_filter( 'body_class', 'showcase_page_header_body_class' );

	// Rename primary and secondary navigation menus
	add_theme_support ( 'genesis-menus' , array (
		'primary' => __( 'Header Menu', 'showcase' )
		)
	);

	// Reduce secondary navigation menu to one level depth
	add_filter( 'wp_nav_menu_args', 'showcase_secondary_menu_args' );

	// Reposition primary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav', 12 );

	// Remove output of primary navigation right extras
	remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
	remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

	// Remove navigation meta box
	add_action( 'genesis_theme_settings_metaboxes', 'showcase_remove_genesis_metaboxes' );

	// Add support for shortcodes in widget areas
	add_filter('widget_text', 'do_shortcode');

	// Remove header right widget area
	unregister_sidebar( 'header-right' );

	// Remove secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	// Remove site layouts
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register widget areas
	genesis_register_sidebar( array(
		'id'          => 'front-page-1',
		'name'        => __( 'Front Page 1', 'showcase' ),
		'description' => __( 'This is the 1st section on the front page.', 'showcase' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'front-page-2',
		'name'        => __( 'Front Page 2', 'showcase' ),
		'description' => __( 'This is the 2nd section on the front page.', 'showcase' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'front-page-3',
		'name'        => __( 'Front Page 3', 'showcase' ),
		'description' => __( 'This is the 3rd section on the front page.', 'showcase' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'front-page-4',
		'name'        => __( 'Front Page 4', 'showcase' ),
		'description' => __( 'This is the 4th section on the front page.', 'showcase' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'front-page-5',
		'name'        => __( 'Front Page 5', 'showcase' ),
		'description' => __( 'This is the 5th section on the front page.', 'showcase' ),
	) );
	genesis_register_sidebar( array(
		'id'          => 'before-footer',
		'name'        => __( 'Before Footer', 'showcase' ),
		'description' => __( 'This is a widget area right before the footer on every page.', 'showcase' ),
	) );

	// Add the Before Footer Widget Area
	add_action( 'genesis_before_footer', 'showcase_before_footer_widget_area', 5 );

	// Add support for 4-column footer widget
	add_theme_support( 'genesis-footer-widgets', 4 );

	// Reposition entry meta in entry header
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

	// Customize entry meta in the entry header
	add_filter( 'genesis_post_info', 'showcase_entry_meta_header' );

	// Customize the content limit more markup
	add_filter( 'get_the_content_limit', 'showcase_content_limit_read_more_markup', 10, 3 );

	// Modify the Genesis content limit read more link
	add_filter( 'get_the_content_more_link', 'showcase_read_more_link' );

	// Customize author box title
	add_filter( 'genesis_author_box_title', 'showcase_author_box_title' );

	// Modify size of the Gravatar in the author box
	add_filter( 'genesis_author_box_gravatar_size', 'showcase_author_box_gravatar' );

	// Remove entry meta in the entry footer on category pages
	add_action( 'genesis_before_entry', 'showcase_remove_entry_footer' );

	// Add previous and next post links after entry
	add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav' );

}

/**
 * Global Enqueues
 *
 */
function showcase_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Hind:400,300,500,600,700', CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', CHILD_THEME_VERSION );

    wp_enqueue_script( 'showcase-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', time() );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'showcase-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, time() );
	wp_localize_script(
		'showcase-responsive-menu',
		'genesis_responsive_menu',
		showcase_responsive_menu_settings()
	);

}

/**
 * Responsive Menu Settings
 *
 */
function showcase_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'showcase-pro' ),
		'menuIconClass'    => 'ion ion-android-menu',
		'subMenu'          => __( 'Menu', 'showcase-pro' ),
		'subMenuIconClass' => 'ion ion-chevron-left',
		'menuClasses'      => array(
			'others' => array(
				'.nav-primary',
			),
		),
	);

	return $settings;

}

/**
 * Theme Setting Defaults
 *
 */

function showcase_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['image_size']                = 'showcase_archive';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

/**
 * After switching theme defaults
 *
 */
function showcase_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,
			'content_archive'           => 'full',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'showcase_archive',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 3 );

}

/**
 * Simple Social Icon Defaults
 *
 */
function showcase_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#1a1a1a',
		'background_color_hover' => '#1a1a1a',
		'border_color'           => '#1a1a1a',
		'border_color_hover'     => '#1a1a1a',
		'border_radius'          => 48,
		'border_width'           => 0,
		'icon_color'             => '#999999',
		'icon_color_hover'       => '#aaaaaa',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

/**
 * Page Header Class
 *
 */
function showcase_page_header_body_class( $classes ) {

	if( is_page() && has_post_thumbnail() )
    	$classes[] = 'with-page-header';

    return $classes;

}

/**
 * Page Header
 *
 */
function showcase_page_header() {
	$output = false;
	if( is_page() ) {

		$image = get_post_thumbnail_id();

		if( $image ) {

			// Remove the title since we'll add it later
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

			$image = wp_get_attachment_image_src( $image, 'showcase_hero' );
			$background_image_class = 'with-background-image';
			$title = the_title( '<h1>', '</h1>', false );

			$output .= '<div class="page-header bg-primary with-background-image" style="background-image: url(' . $image[0] . ');"><div class="wrap">';
			$output .= '<div class="header-content">' . $title . '</div>';
			$output .= '</div></div>';
		}
	}

	if( $output )
		echo $output;
}

/**
 * Unregister Superfish
 *
 */
function unregister_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

/**
 * Limit secondary menu to 1
 *
 */
function showcase_secondary_menu_args( $args ){
	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;
}

/**
 * Remove navigation settings metabox
 *
 */
function showcase_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}


/**
 * Setup widget counts
 *
 */
function showcase_count_widgets( $id ) {
	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Flexible widget class
 *
 */
function showcase_widget_area_class( $id ) {
	$count = showcase_count_widgets( $id );

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

/**
 * Widget area halves
 *
 */
function showcase_halves_widget_area_class( $id ) {

	$count = showcase_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves';
	} else {
		$class .= ' widget-halves uneven';
	}
	return $class;

}

/**
 * Before Footer widget area
 *
 */
function showcase_before_footer_widget_area() {
	if ( is_active_sidebar( 'before-footer' ) ) {
		genesis_widget_area( 'before-footer', array(
			'before' => '<div id="before-footer" class="before-footer"><div class="wrap"><div class="widget-area' . showcase_widget_area_class( 'before-footer' ) . '">',
			'after'  => '</div></div></div>',
		) );
	}
}

/**
 * Entry meta
 *
 */
function showcase_entry_meta_header($post_info) {
	$post_info = '[post_categories before="" after=" &middot;"] [post_date] [post_edit before=" &middot; "]';
	return $post_info;
}

/**
 * Read more markup
 *
 */
function showcase_content_limit_read_more_markup( $output, $content, $link ) {
	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );
	return $output;
}

/**
 * Read more text
 *
 */
function showcase_read_more_link() {
	return '<a class="button light more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

/**
 * Author box title
 *
 */
function showcase_author_box_title() {
	return '<span itemprop="name">' . get_the_author() . '</span>';
}

/**
 * Author gravatar size
 *
 */
function showcase_author_box_gravatar( $size ) {
	return 160;
}

/**
 * Remove entry footer on archives
 *
 */
function showcase_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	}

}