<?php
/**
 * Essence Pro.
 *
 * This file adds functions to the Essence Pro Theme.
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Essence Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/essence/' );
define( 'CHILD_THEME_VERSION', '1.1.0' );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'essence_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function essence_localization_setup() {

	load_child_theme_textdomain( 'essence-pro', get_stylesheet_directory() . '/languages' );

}

// Adds the theme helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds the theme title functions.
require_once get_stylesheet_directory() . '/lib/header-functions.php';

// Adds the theme title functions.
require_once get_stylesheet_directory() . '/lib/title-functions.php';

// Adds image upload and color select to WordPress Theme Customizer.
require_once get_stylesheet_directory() . '/lib/customizer/customize.php';

// Includes customizer CSS.
require_once get_stylesheet_directory() . '/lib/customizer/output.php';

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

add_action( 'wp_enqueue_scripts', 'essence_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function essence_enqueue_scripts_styles() {

	wp_enqueue_style(
		'essence-fonts',
		'//fonts.googleapis.com/css?family=Alegreya+Sans:400,400i,700|Lora:400,700',
		array(),
		CHILD_THEME_VERSION
	);

	wp_enqueue_style(
		'ionicons',
		'//unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css',
		array(),
		CHILD_THEME_VERSION
	);

	wp_enqueue_script(
		'essence-match-height',
		get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
	wp_add_inline_script(
		'essence-match-height',
		"jQuery(document).ready( function() { jQuery( '.half-width-entries .content .entry, .flexible-widgets .entry, .pricing-table > div' ).matchHeight(); });"
	);
	wp_add_inline_script(
		'essence-match-height',
		"jQuery(document).ready( function() { jQuery( '.content, .sidebar' ).matchHeight({ property: 'min-height' }); });"
	);

	wp_enqueue_script(
		'global-js',
		get_stylesheet_directory_uri() . '/js/global.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'essence-responsive-menu',
		get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
	wp_localize_script(
		'essence-responsive-menu',
		'genesis_responsive_menu',
		essence_responsive_menu_settings()
	);

}

/**
 * Defines the responsive menu settings.
 *
 * @since 1.0.0
 */
function essence_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'essence-pro' ),
		'menuIconClass'    => 'ionicons-before ion-ios-menu',
		'subMenu'          => __( 'Submenu', 'essence-pro' ),
		'subMenuIconClass' => 'ionicons-before ion-ios-arrow-down',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-off-screen',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds HTML5 markup structure.
add_theme_support(
	'html5', array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds Accessibility support.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds support for custom logo.
add_theme_support(
	'custom-logo', array(
		'flex-height'     => true,
		'flex-width'      => true,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'height'          => 160,
		'width'           => 600,
	)
);

// Displays custom logo in site title area.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Adds support for custom header.
add_theme_support(
	'custom-header', array(
		'default-image'    => essence_get_default_hero_background_image(),
		'header-text'      => false,
		'header-selector'  => '.header-hero',
		'flex-height'      => true,
		'flex-width'       => true,
		'height'           => 800,
		'width'            => 1600,
		'wp-head-callback' => 'essence_header_style',
	)
);

// Registers default header image.
register_default_headers(
	array(
		'child' => array(
			'url'           => essence_get_default_hero_background_image(),
			'thumbnail_url' => essence_get_default_hero_background_image(),
			'description'   => __( 'Essence Header Image', 'essence-pro' ),
		),
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds image sizes.
add_image_size( 'sidebar-featured-thumb', 70, 60, true );
add_image_size( 'featured-image', 800, 400, true );
add_image_size( 'header-hero', 1600, 800, true );

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

add_action( 'genesis_theme_settings_metaboxes', 'essence_remove_genesis_metaboxes' );
/**
 * Removes navigation meta box.
 *
 * @since 1.0.0
 *
 * @param string $_genesis_theme_settings The page hook name.
 */
function essence_remove_genesis_metaboxes( $_genesis_theme_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings, 'main' );

}

add_filter( 'genesis_skip_links_output', 'essence_content_skip_links_output' );
/**
 * Changes the target of the "Skip to content" skip link.
 *
 * @since 1.0.0
 *
 * @param array $links The list of skip links.
 * @return array $links The modified list of skip links.
 */
function essence_content_skip_links_output( $links ) {

	unset( $links['genesis-content'] );

	$new_links = $links;
	array_splice( $new_links, 1 );

	$new_links['hero-page-title'] = __( 'Skip to content', 'essence-pro' );

	return array_merge( $new_links, $links );

}

add_filter( 'genesis_skip_links_output', 'essence_skip_links_output' );
/**
 * Removes skip link for primary navigation and adds skip link for footer widgets.
 *
 * @since 1.0.0
 *
 * @param array $links The list of skip links.
 * @return array $links The modified list of skip links.
 */
function essence_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'after-content-featured' ) ) {
		$new_links['after-content-featured'] = __( 'Skip to footer', 'essence-pro' );
	}

	return array_merge( $new_links, $links );

}

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'    => __( 'Header Menu', 'essence-pro' ),
		'secondary'  => __( 'Footer Menu', 'essence-pro' ),
		'off-screen' => __( 'Off Screen', 'essence-pro' ),
	)
);

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 13 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', 'essence_secondary_menu_args' );
/**
 * Reduces the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args The WP navigation menu arguments.
 * @return array The modified menu arguments.
 */
function essence_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_search_text', 'essence_search_button_text' );
/**
 * Changes search form placeholder text.
 *
 * @since 1.0.0
 *
 * @param string $text The search form placeholder text.
 * @return string The modified search form placeholder text.
 */
function essence_search_button_text( $text ) {

	return esc_attr( 'Search' );

}

add_filter( 'get_the_content_limit', 'essence_content_limit_read_more_markup', 10, 3 );
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
function essence_content_limit_read_more_markup( $output, $content, $link ) {

	if ( is_page_template( 'page_blog.php' ) || is_home() || is_archive() || is_search() ) {
		$link = sprintf( '<a href="%s" class="more-link button text">%s</a>', get_the_permalink(), genesis_a11y_more_link( __( 'Continue Reading', 'essence-pro' ) ) );
	}

	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

add_filter( 'genesis_author_box_gravatar_size', 'essence_author_box_gravatar' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function essence_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'essence_comments_gravatar' );
/**
 * Modifies the size of the Gravatar in the entry comments.
 *
 * @since 1.0.0
 *
 * @param array $args The comment list arguments.
 * @return array Arguments with new avatar size.
 */
function essence_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// Moves image above post title.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Repositions the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 90 );

// Removes the entry footer.
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

add_filter( 'genesis_post_info', 'essence_modify_post_info' );
/**
 * Modifies the meta information in the entry header.
 *
 * @since 1.0.0
 *
 * @param string $post_info Current post info.
 * @return string New post info.
 */
function essence_modify_post_info( $post_info ) {

	global $post;

	setup_postdata( $post );

	if ( is_single() ) {
		$post_info = '[post_categories before="" after=" &#47;"] [post_date] <i class="byline">by</i> [post_author_posts_link] [post_comments before="&#47; "] [post_edit]';
	} else {
		$post_info = '[post_categories before=""]';
	}
	return $post_info;

}

add_filter( 'comment_author_says_text', 'essence_comment_author_says_text' );
/**
 * Modifies the author says text in comments.
 *
 * @since 1.0.0
 *
 * @return string New author says text.
 */
function essence_comment_author_says_text() {

	return '';

}

/**
 * Counts used widgets in given sidebar.
 *
 * @since 1.0.0
 *
 * @param string $id The sidebar ID.
 * @return int|void The number of widgets, or nothing.
 */
function essence_count_widgets( $id ) {

	$sidebars_widgets = wp_get_sidebars_widgets();

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Gives class name based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function essence_widget_area_class( $id ) {

	$count = essence_count_widgets( $id );

	$class = '';

	if ( 1 === $count ) {
		$class .= ' widget-full';
	} elseif ( 0 === $count % 3 ) {
		$class .= ' widget-thirds';
	} elseif ( 0 === $count % 4 ) {
		$class .= ' widget-fourths';
	} elseif ( 1 === $count % 2 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

/**
 * Helper function to handle outputting widget markup and classes.
 *
 * @since 1.0.0
 *
 * @param string $id The id of the widget area.
 */
function essence_do_widget( $id ) {

	$count   = essence_count_widgets( $id );
	$columns = essence_widget_area_class( $id );

	genesis_widget_area(
		$id, array(
			'before' => "<div id=\"$id\" class=\"$id\"><div class=\"flexible-widgets widget-area $columns\"><div class=\"wrap\">",
			'after'  => '</div></div></div>',
		)
	);

}

add_action( 'genesis_before_footer', 'essence_after_content_featured', 13 );
/**
 * Adds a flexible featured widget area above the footer.
 *
 * @since 1.0.0
 */
function essence_after_content_featured() {

	if ( is_active_sidebar( 'after-content-featured' ) ) {
		essence_do_widget( 'after-content-featured' );
	}

}


add_action( 'genesis_before_footer', 'essence_footer_cta', 17 );
/**
 * Adds the above footer widget area.
 *
 * @since 1.0.0
 */
function essence_footer_cta() {

	genesis_widget_area(
		'footer-cta', array(
			'before' => '<div id="footer-cta" class="footer-cta"><div class="wrap"><div class="widget-area">',
			'after'  => '</div></div></div>',
		)
	);

}

// Registers widget areas.
genesis_register_sidebar(
	array(
		'id'          => 'hero-section',
		'name'        => __( 'Hero Section', 'essence-pro' ),
		'description' => __( 'This is the Hero widget section on the front page (must be enabled in Customizer).', 'essence-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-1',
		'name'        => __( 'Front Page 1', 'essence-pro' ),
		'description' => __( 'This is the front page 1 section.', 'essence-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-2',
		'name'        => __( 'Front Page 2', 'essence-pro' ),
		'description' => __( 'This is the front page 2 section.', 'essence-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-featured',
		'name'        => __( 'Front Page Featured', 'essence-pro' ),
		'description' => __( 'This is the front page featured section.', 'essence-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'after-content-featured',
		'name'        => __( 'After Content Featured', 'essence-pro' ),
		'description' => __( 'This is the featured section that displays after the content area.', 'essence-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'footer-cta',
		'name'        => __( 'Footer CTA', 'essence-pro' ),
		'description' => __( 'This is the call to action section above the footer.', 'essence-pro' ),
	)
);
