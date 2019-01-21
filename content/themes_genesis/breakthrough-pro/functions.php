<?php
/**
 * Breakthrough Pro.
 *
 * This file adds functions to the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Breakthrough Pro' );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/breakthrough/' );
define( 'CHILD_THEME_VERSION', '1.1.0' );

add_action( 'after_setup_theme', 'breakthrough_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function breakthrough_localization_setup() {

	load_child_theme_textdomain( 'breakthrough-pro', CHILD_DIR . '/languages' );

}

// Sets up theme defaults.
require_once CHILD_DIR . '/lib/theme-defaults.php';

// Adds the theme helper functions.
require_once CHILD_DIR . '/lib/helper-functions.php';

// Adds image upload and color select to WordPress Theme Customizer.
require_once CHILD_DIR . '/lib/customize.php';

// Includes Customizer CSS.
require_once CHILD_DIR . '/lib/inline-styles.php';

// Adds WooCommerce support.
require_once CHILD_DIR . '/lib/woocommerce/woocommerce-setup.php';

// Includes the Customizer CSS for the WooCommerce plugin.
require_once CHILD_DIR . '/lib/woocommerce/woocommerce-inline-styles.php';

// Includes notice to install Genesis Connect for WooCommerce.
require_once CHILD_DIR . '/lib/woocommerce/woocommerce-notice.php';

// Moves page headers.
require_once CHILD_DIR . '/lib/headings.php';

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

add_action( 'wp_head', 'breakthrough_load_images' );
/**
 * Adjusts featured images.
 *
 * Defer loading until wp_head so that `get_theme_mod()` works for live previews in the Customizer.
 *
 * @since 1.0.0
 */
function breakthrough_load_images() {

	require_once CHILD_DIR . '/lib/images.php';

}

// Adds image sizes.
add_image_size( 'header-image', 1600, 420, true );
add_image_size( 'featured-image', 800, 440, true );
add_image_size( 'portfolio', 510, 650, true );
add_image_size( 'front-about', 590, 390, true );

add_action( 'wp_enqueue_scripts', 'breakthrough_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function breakthrough_enqueue_scripts_styles() {

	wp_enqueue_style( 'breakthrough-fonts', '//fonts.googleapis.com/css?family=Alegreya+Sans:400,400i,700|PT+Serif:400,400i,700,700i', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'breakthrough-responsive-menu', CHILD_URL . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'breakthrough-responsive-menu',
		'genesis_responsive_menu',
		array(
			'mainMenu'         => __( 'Menu', 'breakthrough-pro' ),
			'menuIconClass'    => 'ionicons-before ion-ios-drag',
			'subMenu'          => __( 'Submenu', 'breakthrough-pro' ),
			'subMenuIconClass' => 'ionicons-before ion-ios-arrow-down',
			'menuClasses'      => array(
				'others' => array(
					'.nav-primary',
				),
			),
		)
	);

	wp_enqueue_script(
		'breakthrough-match-height',
		CHILD_URL . '/js/jquery.matchHeight.min.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_add_inline_script(
		'breakthrough-match-height',
		"jQuery(document).ready( function() { jQuery( '.half-width-entries .content .entry, .flexible-widgets .entry, .pricing-table > div' ).matchHeight(); });"
	);

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

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of genesis header settings in the Customizer.
 *
 * @since 1.0.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Adds support for custom background.
add_theme_support(
	'custom-background', array(
		'default-color' => '4a4f9b',
	)
);

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary'   => __( 'Header Menu', 'breakthrough-pro' ),
		'secondary' => __( 'Footer Menu', 'breakthrough-pro' ),
	)
);

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

// Move breadcrumbs to below header.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

add_action( 'genesis_theme_settings_metaboxes', 'breakthrough_remove_genesis_metaboxes' );
/**
 * Removes navigation meta box.
 *
 * @since 1.0.0
 *
 * @param string $_genesis_theme_settings_pagehook The page hook name.
 */
function breakthrough_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', 'breakthrough_secondary_menu_args' );
/**
 * Reduces the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args The WP navigation menu arguments.
 * @return array The modified menu arguments.
 */
function breakthrough_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_skip_links_output', 'breakthrough_skip_links_output' );
/**
 * Removes skip link for primary navigation and adds skip link for footer widgets.
 *
 * @since 1.0.0
 *
 * @param array $links The list of skip links.
 * @return array $links The modified list of skip links.
 */
function breakthrough_skip_links_output( $links ) {

	unset( $links['genesis-nav-primary'] );
	unset( $links['genesis-content'] );

	$links['breakthrough-page-title'] = __( 'Skip to content', 'breakthrough-pro' );

	if ( is_active_sidebar( 'breakthrough-footer' ) ) {
		$links['footer'] = __( 'Skip to footer', 'breakthrough-pro' );
	}

	return $links;

}

add_filter( 'genesis_author_box_gravatar_size', 'breakthrough_author_box_gravatar' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function breakthrough_author_box_gravatar( $size ) {

	return 84;

}

add_filter( 'genesis_comment_list_args', 'breakthrough_comments_gravatar' );
/**
 * Modifies the size of the Gravatar in the entry comments.
 *
 * @since 1.0.0
 *
 * @param array $args The comment list arguments.
 * @return array Arguments with new avatar size.
 */
function breakthrough_comments_gravatar( $args ) {

	$args['avatar_size'] = 45;
	return $args;

}

add_filter( 'get_the_content_limit', 'breakthrough_content_limit_read_more_markup', 10, 3 );
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
function breakthrough_content_limit_read_more_markup( $output, $content, $link ) {

	if ( is_page_template( 'page_blog.php' ) || is_home() || is_archive() || is_search() ) {
		$link = sprintf( '<a href="%s" class="more-link button text">%s &#x2192;</a>', get_the_permalink(), genesis_a11y_more_link( __( 'Continue Reading', 'breakthrough-pro' ) ) );
	}

	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

add_filter( 'genesis_post_info', 'breakthrough_modify_post_info' );
/**
 * Modifies the meta information in the entry header.
 *
 * @since 1.0.0
 *
 * @param string $post_info Current post info.
 * @return string New post info.
 */
function breakthrough_modify_post_info( $post_info ) {

	global $post;

	setup_postdata( $post );
	$post_avatar = get_avatar( get_the_author_meta( 'email' ), 36 );

	if ( is_single() ) {
		$post_info = $post_avatar . '<i class="byline">by</i> [post_author_posts_link] <i>on</i> [post_date after=""]  [post_comments] [post_edit]';
	} else {
		$post_info = '<i class="byline">by</i> [post_author_posts_link] <i>on</i> [post_date]  [post_comments] [post_edit]';
	}

	return $post_info;

}

/**
 * Counts used widgets in given sidebar.
 *
 * @since 1.0.0
 *
 * @param string $id The sidebar ID.
 * @return int|void The number of widgets, or nothing.
 */
function breakthrough_count_widgets( $id ) {

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
function breakthrough_widget_area_class( $id ) {

	$count = breakthrough_count_widgets( $id );

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
 * Outputs class names based on widget count.
 *
 * @since 1.0.0
 *
 * @param string $id The widget ID.
 * @return string The class.
 */
function breakthrough_alternate_widget_area_class( $id ) {

	$count = breakthrough_count_widgets( $id );

	$class = '';

	if ( 1 === $count || 2 === $count ) {
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

genesis_register_sidebar(
	array(
		'id'          => 'front-page-1',
		'name'        => __( 'Front Page 1', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 1 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-2',
		'name'        => __( 'Front Page 2', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 2 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-3',
		'name'        => __( 'Front Page 3', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 3 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-4',
		'name'        => __( 'Front Page 4', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 4 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-5',
		'name'        => __( 'Front Page 5', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 5 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'front-page-6',
		'name'        => __( 'Front Page 6', 'breakthrough-pro' ),
		'description' => __( 'This is the front page 6 section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'above-footer-cta',
		'name'        => __( 'Above Footer CTA', 'breakthrough-pro' ),
		'description' => __( 'Above footer call to action section.', 'breakthrough-pro' ),
	)
);
genesis_register_sidebar(
	array(
		'id'          => 'breakthrough-footer',
		'name'        => __( 'Footer', 'breakthrough-pro' ),
		'description' => __( 'This is the footer section.', 'breakthrough-pro' ),
	)
);

add_action( 'genesis_before_footer', 'breakthrough_above_footer_cta' );
/**
 * Adds Footer CTA widget area.
 *
 * @since 1.0.0
 */
function breakthrough_above_footer_cta() {

	$footer_cta_image = get_theme_mod( 'breakthrough_footer_image', breakthrough_get_default_page_footer_image() );

	genesis_widget_area(
		'above-footer-cta', array(
			'before' => '<div id="above-footer-cta" class="above-footer-cta"><div class="flexible-widgets widget-area' . breakthrough_widget_area_class( 'above-footer-cta' ) . '"><div class="wrap">',
			'after'  => '</div></div></div>',
		)
	);

	if ( $footer_cta_image ) {
		$image_id  = attachment_url_to_postid( $footer_cta_image );
		$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		echo '<div class="full-width-image footer-cta-image"><img src="' . $footer_cta_image . '" alt="' . $image_alt . '" /></div>';
	}

}

add_action( 'genesis_before_footer', 'breakthrough_footer_widgets' );
/**
 * Adds the flexible footer widget area.
 *
 * @since 1.0.0
 */
function breakthrough_footer_widgets() {

	genesis_widget_area(
		'breakthrough-footer', array(
			'before' => '<div id="footer" class="footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">' . __( 'Footer', 'breakthrough-pro' ) . '</h2><div class="flexible-widgets widget-area ' . breakthrough_widget_area_class( 'breakthrough-footer' ) . '"><div class="wrap">',
			'after'  => '</div></div></div>',
		)
	);

}
