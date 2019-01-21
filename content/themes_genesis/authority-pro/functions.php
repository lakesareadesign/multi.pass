<?php
/**
 * Authority Pro.
 *
 * This file adds functions to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Authority Pro' );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/authority/' );
define( 'CHILD_THEME_VERSION', '1.1.0' );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'authority_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function authority_localization_setup() {
	load_child_theme_textdomain( 'authority-pro', get_stylesheet_directory() . '/languages' );
}

// Adds the theme helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to WordPress Theme Customizer.
require_once get_stylesheet_directory() . '/lib/customizer/customize.php';

// Includes customizer CSS.
require_once get_stylesheet_directory() . '/lib/customizer/output.php';

// Includes the featured image markup if required.
require_once get_stylesheet_directory() . '/lib/featured-images.php';

// Includes subtitle markup and filters.
require_once get_stylesheet_directory() . '/lib/subtitles.php';

// Adds the grid layout.
require_once get_stylesheet_directory() . '/lib/grid-layout.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Includes the customizer CSS for the WooCommerce plugin.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Includes notice to install Genesis Connect for WooCommerce.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * Allows plugins to remove support if required.
 *
 * @since 1.1.0
 */
function genesis_child_gutenberg_support() {

	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';

}

add_action( 'wp_enqueue_scripts', 'authority_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function authority_enqueue_scripts_styles() {

	wp_enqueue_style( 'authority-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:600,700,900|Libre+Baskerville:400,400italic,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'authority-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script( 'authority-responsive-menu', 'genesis_responsive_menu', authority_responsive_menu_settings() );

	// Setup page if has top banner.
	if ( get_theme_mod( 'authority-top-banner-visibility', true ) ) {

		wp_enqueue_script( 'top-banner-js', get_stylesheet_directory_uri() . '/js/top-banner.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	}

}

add_action( 'body_class', 'authority_top_banner_classes' );
/**
 * Adds top-banner body classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Current classes.
 * @return array The new classes.
 */
function authority_top_banner_classes( $classes ) {

	if ( get_theme_mod( 'authority-top-banner-visibility', true ) ) {

		$classes[] = 'top-banner-hidden';

		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}
	}

	return $classes;

}

/**
 * Defines the responsive menu settings.
 *
 * @since 1.0.0
 */
function authority_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'authority-pro' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'authority-pro' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-social',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Adds Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds support for custom header.
add_theme_support(
	'custom-header', array(
		'flex-height'     => true,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'height'          => 160,
		'width'           => 600,
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds image sizes.
add_image_size( 'single-featured-image', 1200, 385, true );
add_image_size( 'blog-featured-image', 680, 290, true );
add_image_size( 'home-featured', 380, 570, true );

add_filter( 'image_size_names_choose', 'authority_media_library_sizes' );
/**
 * Adds image sizes to Media Library.
 *
 * @since 1.0.0
 *
 * @param array $sizes Array of image sizes and their names.
 * @return array The modified list of sizes.
 */
function authority_media_library_sizes( $sizes ) {

	$sizes['home-featured'] = __( 'Home - Featured Image', 'authority-pro' );

	return $sizes;

}

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );


add_action( 'genesis_theme_settings_metaboxes', 'authority_remove_genesis_metaboxes' );
/**
 * Removes navigation meta box.
 *
 * @since 1.0.0
 *
 * @param string $_genesis_theme_settings_pagehook The page hook name.
 */
function authority_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

// Relocates skip links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );
add_action( 'genesis_before', 'genesis_skip_links', 5 );

add_filter( 'genesis_skip_links_output', 'authority_skip_links_output' );
/**
 * Removes skip link for primary navigation and adds skip link for footer widgets.
 *
 * @since 1.0.0
 *
 * @param array $links The list of skip links.
 * @return array $links The modified list of skip links.
 */
function authority_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'authority-footer' ) ) {
		$new_links['footer'] = __( 'Skip to footer', 'authority-pro' );
	}

	return array_merge( $new_links, $links );

}

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'authority-pro' ),
		'secondary' => __( 'Footer Menu', 'authority-pro' ),
		'social'    => __( 'Social Menu', 'authority-pro' ),
	)
);

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'genesis_attr_nav-social', 'authority_social_menu_atts' );
/**
 * Adds appropriate attributes to social nav.
 *
 * @since 1.0.0
 *
 * @param array $atts The navigation element attributes.
 * @return array The modified navigation element attributes.
 */
function authority_social_menu_atts( $atts ) {

	$atts['aria-labelledby'] = 'additional-menu-label';
	$atts['id']              = 'genesis-nav-social';
	$atts['itemscope']       = true;
	$atts['itemtype']        = 'https://schema.org/SiteNavigationElement';

	return $atts;

}

add_action( 'genesis_before_header', 'authority_do_social_menu', 9 );
/**
 * Output the social menu.
 *
 * @since 1.0.0
 */
function authority_do_social_menu() {

	echo '<h2 id="additional-menu-label" class="screen-reader-text">' . __( 'Additional menu', 'authority-pro' ) . '</h2>';

	genesis_nav_menu(
		array(
			'theme_location' => 'social',
			'depth'          => 1,
		)
	);

}

add_filter( 'wp_nav_menu_args', 'authority_secondary_menu_args' );
/**
 * Reduces the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args The WP navigation menu arguments.
 * @return array The modified menu arguments.
 */
function authority_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_post_info', 'authority_modify_post_info' );
/**
 * Modifies the meta information in the entry header.
 *
 * @since 1.0.0
 *
 * @param string $post_info Current post info.
 * @return string New post info.
 */
function authority_modify_post_info( $post_info ) {

	$post_info = 'posted on [post_date]';

	return $post_info;

}

add_filter( 'get_the_content_limit', 'authority_content_limit_read_more_markup', 10, 3 );
/**
 * Modifies the generic more link markup for posts.
 *
 * @since 1.0.0
 *
 * @param string $output The current full HTML.
 * @param string $content The content HTML.
 * @param string $link The link HTML.
 * @return string The new more link HTML.
 */
function authority_content_limit_read_more_markup( $output, $content, $link ) {

	if ( is_page_template( 'page_blog.php' ) || is_home() || is_archive() || is_search() ) {
		$link = sprintf( '<a href="%s">%s &#x2192;</a>', get_the_permalink(), genesis_a11y_more_link( __( 'Continue Reading', 'authority-pro' ) ) );
	}

	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

add_filter( 'genesis_author_box_gravatar_size', 'authority_author_box_gravatar' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function authority_author_box_gravatar( $size ) {

	return 124;

}

add_filter( 'genesis_comment_list_args', 'authority_comments_gravatar' );
/**
 * Modifies the size of the Gravatar in the entry comments.
 *
 * @since 1.0.0
 *
 * @param array $args The comment list arguments.
 * @return array Arguments with new avatar size.
 */
function authority_comments_gravatar( $args ) {

	$args['avatar_size'] = 35;

	return $args;

}

/**
 * Counts used widgets in given sidebar.
 *
 * @since 1.0.0
 *
 * @param string $id The sidebar ID.
 * @return int|void The number of widgets, or nothing.
 */
function authority_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Gives odd or even class name based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function authority_widget_area_class( $id ) {

	$count = authority_count_widgets( $id );

	if ( 0 === $count % 2 ) {
		$class = 'widget-even';
	} else {
		$class = 'widget-odd';
	}

	return $class;

}

/**
 * Outputs class names based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function authority_alternate_widget_area_class( $id ) {

	$count = authority_count_widgets( $id );

	$class = '';

	if ( 1 === $count || 2 === $count ) {
		$class .= ' widget-full';
	} elseif ( 1 === $count % 3 ) {
		$class .= ' widget-thirds';
	} elseif ( 1 === $count % 4 ) {
		$class .= ' widget-fourths';
	} elseif ( 0 === $count % 2 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

add_action( 'genesis_before_footer', 'authority_footer_widgets' );
/**
 * Adds the flexible footer widget area.
 *
 * @since 1.0.0
 */
function authority_footer_widgets() {

	$widget_count = authority_count_widgets( 'authority-footer' );
	$classes      = authority_widget_area_class( 'authority-footer' );

	// If only two widgets, configure featured layout via class.
	if ( 2 === $widget_count ) {
		$classes .= ' featured-footer-layout';
	}

	// Removes subitle.
	remove_filter( 'the_title', 'authority_title' );

	genesis_widget_area(
		'authority-footer', array(
			'before' => '<div id="footer" class="footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer', 'authority-pro' ) . '</h2><div class="flexible-widgets widget-area ' . $classes . '"><div class="wrap">',
			'after'  => '</div></div></div>',
		)
	);

}

add_action( 'genesis_before', 'authority_do_top_banner' );
/**
 * Output the Top Banner if visible.
 *
 * @since 1.0.0
 */
function authority_do_top_banner() {

	if ( get_theme_mod( 'authority-top-banner-visibility', true ) ) {

		$button = sprintf( '<button id="authority-top-banner-close"><span class="dashicons dashicons-no-alt"></span><span class="screen-reader-text">%s</span></button>', __( 'Close Top Banner', 'authority-pro' ) );
		printf(
			'<div class="authority-top-banner">%s%s</div>',
			get_theme_mod( 'authority-top-banner-text', authority_get_default_top_banner_text() ),
			$button
		);

	}

}

// Registers widget areas.
genesis_register_sidebar(
	array(
		'id'          => 'hero-section',
		'name'        => __( 'Hero Section', 'authority-pro' ),
		'description' => __( 'This is the widget area for the Hero Section (must be enabled in Customizer).', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-1',
		'name'        => __( 'Front Page 1', 'authority-pro' ),
		'description' => __( 'This is the front page 1 section.', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-2',
		'name'        => __( 'Front Page 2', 'authority-pro' ),
		'description' => __( 'This is the front page 2 section.', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-3',
		'name'        => __( 'Front Page 3', 'authority-pro' ),
		'description' => __( 'This is the front page 3 section.', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-4',
		'name'        => __( 'Front Page 4', 'authority-pro' ),
		'description' => __( 'This is the front page 4 section.', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-5',
		'name'        => __( 'Front Page 5', 'authority-pro' ),
		'description' => __( 'This is the front page 5 section.', 'authority-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'authority-footer',
		'name'        => __( 'Footer', 'authority-pro' ),
		'description' => __( 'This is the footer section.', 'authority-pro' ),
	)
);
