<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds functions to the Smart Passive Income Pro.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'spi_localization_setup' );
function spi_localization_setup(){
	load_child_theme_textdomain( 'smart-passive-income-pro', get_stylesheet_directory() . '/languages' );
}

// Add theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Include the WooCommerce setup functions.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Include the WooCommerce customized CSS (if applicaple).
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Smart Passive Income Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/smart-passive-income/' );
define( 'CHILD_THEME_VERSION', '1.1.3' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'spi_enqueue_scripts_styles' );
function spi_enqueue_scripts_styles() {

	wp_enqueue_style( 'spi-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,400italic,700,900', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'spi-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'spi-responsive-menu',
		'genesis_responsive_menu',
		spi_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function spi_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'smart-passive-income-pro' ),
		'subMenu'     => __( 'Submenu', 'smart-passive-income-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Remove secondary sidebar and layouts.
unregister_sidebar( 'sidebar-alt' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 860,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for after entry widget and move it inside.
add_theme_support( 'genesis-after-entry-widget-area' );
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_entry_content', 'genesis_after_entry_widget_area', 15 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'smart-passive-income-pro' ), 'secondary' => __( 'Footer Menu', 'smart-passive-income-pro' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'spi_menu_args' );
function spi_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

// Add secondary-nav class if secondary navigation is used.
add_filter( 'body_class', 'spi_secondary_nav_class' );
function spi_secondary_nav_class( $classes ) {

	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $menu_locations['secondary'] ) ) {
		$classes[] = 'secondary-nav';
	}

	return $classes;

}

// Add menu description.
add_filter( 'walker_nav_menu_start_el', 'spi_header_menu_desc', 10, 4 );
function spi_header_menu_desc( $item_output, $item, $depth, $args ) {

	if( 'primary' == $args->theme_location && ! $depth && $item->description ) {
		$item_output = str_replace( '</a>', '<span itemprop="description">' . esc_html( $item->description ) . '</span></a>', $item_output );
	}

	return $item_output;

}

// Modify the entry info.
add_filter( 'genesis_post_info', 'spi_post_info' );
function spi_post_info( $post_info ) {

	$post_info = __( 'By [post_author_posts_link] on [post_date] [post_comments zero="0" one="1" more="%"][post_edit]', 'smart-passive-income-pro' );

	return $post_info;

}

// Remove entry footer.
remove_all_actions( 'genesis_entry_footer' );

// Remove default Genesis featured image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_content', 'genesis_do_post_image', 1 );

// Add featured image to posts/pages.
add_action( 'genesis_entry_content', 'spi_do_featured_image', 1 );
function spi_do_featured_image() {

	$show_image = get_theme_mod( 'spi_single_image_setting', true );

	$img = genesis_get_image( array(
		'format'  => 'html',
		'size'    => genesis_get_option( 'image_size' ),
		'context' => 'archive',
		'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
	) );

	if ( ! empty( $img ) && is_singular() && ( true === $show_image ) ) {
		echo $img;
	}

}

// Customize the search form placeholder text.
add_filter( 'genesis_search_text', 'spi_search_placeholder' );
function spi_search_placeholder( $text ) {
	return esc_attr( __( 'Search for...', 'smart-passive-income-pro' ) );
}

// Modify the Gravatar size in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'spi_author_gravatar_size' );
function spi_author_gravatar_size( $size ) {
	return '125';
}

// Setup widget counts.
function spi_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Function to set the flexible widget area class.
function spi_widget_area_class( $id ) {

	$count = spi_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 1 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

// Output the footer widgets area.
add_action( 'genesis_before_footer', 'spi_footer_widgets_area' );
function spi_footer_widgets_area() {

	genesis_widget_area( 'footer-widgets', array(
		'before' => '<div class="footer-widgets flexible-widgets ' . spi_widget_area_class( 'footer-widgets' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	));

}

// Output the footer banner widget area.
add_action( 'genesis_before_footer', 'spi_footer_banner_widget_area', 1 );
function spi_footer_banner_widget_area() {

	if ( is_active_sidebar( 'footer-banner' ) || has_nav_menu( 'secondary' ) ) {
		echo '<div class="footer-banner flexible-widgets color ' . spi_widget_area_class( 'footer-banner' ) . ' widget-area">';

		genesis_widget_area( 'footer-banner', array(
			'before' => '<div class="wrap">',
			'after'  => '</div>',
		));

		genesis_do_subnav();

		echo '</div>';
	}

}

// Add Front Page Template widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'smart-passive-income-pro' ),
	'description' => __( 'The first section on the front page.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'smart-passive-income-pro' ),
	'description' => __( 'The second section on the front page.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'front-page-3-a',
	'name'        => __( 'Front Page 3 - Top', 'smart-passive-income-pro' ),
	'description' => __( 'The top half of the third section on the front page.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'front-page-3-b',
	'name'        => __( 'Front Page 3 - Bottom', 'smart-passive-income-pro' ),
	'description' => __( 'The bottom half of the third section on the front page.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'smart-passive-income-pro' ),
	'description' => __( 'The fourth section on the front page.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'footer-banner',
	'name'        => __( 'Footer Banner', 'smart-passive-income-pro' ),
	'description' => __( 'A sitewide section just above the footer section.', 'smart-passive-income-pro' ),
));
genesis_register_sidebar( array(
	'id'          => 'footer-widgets',
	'name'        => __( 'Footer Widgets', 'smart-passive-income-pro' ),
	'description' => __( 'This is the footer section.', 'smart-passive-income-pro' ),
));
