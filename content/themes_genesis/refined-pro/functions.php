<?php
/**
 * This file adds all the functions to the Refined theme.
 *
 * @package      Refined
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

// Starts the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Add Color selections to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add Widget areas.
require_once( get_stylesheet_directory() . '/lib/widgets.php' );

// Install plugins.
require_once( get_stylesheet_directory() . '/lib/plugins/tgm-plugin-activation/register-plugins.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Refined' );
define( 'CHILD_THEME_URL', 'http://restored316designs.com' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

add_action( 'wp_enqueue_scripts', 'refined_enqueue_scripts' );
/**
 * Loads Responsive Menu, Google Fonts, Icons, and other scripts.
 *
 * @since 1.0.0
 */
function refined_enqueue_scripts() {

	// Load CSS.
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i|Lora:400,400i,700,700i|Montserrat:100,300,300i,400,400i,500,500i', array() );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	// Load JS.
	wp_enqueue_script( 'refined-global-script', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'refined-fadeup-script', get_stylesheet_directory_uri() . '/js/fadeup.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'match-height-init', get_stylesheet_directory_uri() . '/js/matchheight-init.js', array( 'match-height' ), '1.0.0', true );

	// Load responsive menu and arguments.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'refined-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'refined-responsive-menu',
		'genesis_responsive_menu',
		refined_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function refined_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'refined' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'refined' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
				'.nav-header-left',
				'.nav-header-right',
				'.nav-secondary',
			),
			'others'  => array(
				'.nav-footer',
			),
		),
	);

	return $settings;

}

// Add support for footer menu & rename menus.
add_theme_support( 'genesis-menus' , array (
	'primary'      => __( 'Above Header Menu', 'refined' ),
	'secondary'    => __( 'Below Header Menu', 'refined' ),
	'header-left'  => __( 'Header Left', 'refined' ),
	'header-right' => __( 'Header Right', 'refined' ),
	'footer'       => __( 'Footer Menu', 'refined' ),
));

// Add HTML5 markup structure.
add_theme_support( 'html5' );

// Add new featured image sizes.
add_image_size( 'square-entry-image', 400, 400, TRUE );
add_image_size( 'vertical-entry-image', 400, 600, TRUE );
add_image_size( 'horizontal-entry-image', 820, 550, TRUE );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background.
add_theme_support( 'custom-background', array(
	'default-image' => get_stylesheet_directory_uri() . '/images/bg.jpg',
	'default-color' => 'FAF7F2',
));

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 720,
	'height'          => 250,
	'header-selector' => '.site-title a',
	'header-text'     => false,
));

// Remove the site description.
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Unregister layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Reposition the primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav', 7 );

add_filter( 'wp_nav_menu_items', 'refined_primary_nav_extras', 10, 2 );
/**
 * Add search form to navigation.
 *
 * @since 1.0.0
 *
 * @param  string   $menu HTML string representing the menu items.
 * @param  stdClass $args An object containing menu arguments.
 * @return string   $menu Updated $menu string.
 */
function refined_primary_nav_extras( $menu, $args ) {

	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();

	$menu .= '<li class="right search">' . $search . '</li>';

	return $menu;

}

add_filter( 'genesis_nav_items', 'refined_social_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'refined_social_icons', 10, 2 );
/**
 * Add widget to primary navigation.
 *
 * @since 1.0.0
 *
 * @param  string   $menu HTML string representing the menu items.
 * @param  stdClass $args An object containing menu arguments.
 * @return string   $menu Updated $menu string.
 */
function refined_social_icons( $menu, $args ) {

	$args = (array) $args;

	if ( 'primary' !== $args['theme_location'] ) {
		return $menu;
	}

	ob_start();
	genesis_widget_area('nav-social-menu');
	$social = ob_get_clean();

	return $menu . $social;

}

add_action( 'genesis_header', 'refined_header_left_menu', 6 );
/**
 * Hook menu to left of logo.
 *
 * @since 1.0.0
 */
function refined_header_left_menu() {

	genesis_nav_menu( array(
        'theme_location' => 'header-left',
        'depth'          => 2,
    ));

}

add_action( 'genesis_header', 'refined_header_right_menu', 9 );
/**
 * Hook menu to right of logo.
 *
 * @since 1.0.0
 */
function refined_header_right_menu() {

    genesis_nav_menu( array(
        'theme_location' => 'header-right',
        'depth'          => 2,
    ));

}

add_action( 'genesis_before_footer', 'refined_footer_menu', 7 );
/**
 * Hook menu in footer.
 *
 * @since 1.0.0
 */
function refined_footer_menu() {

    genesis_nav_menu( array(
        'theme_location' => 'footer',
        'depth'          => 1,
    ));

}

// Reposition featured images.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

add_action( 'genesis_before_entry_content','refined_add_date' );
/**
 * Add the date to the before the entry content.
 *
 * @since 1.0.0
 */
function refined_add_date () {

  	if ( is_home() || is_single() ) { ?>
		<div class="custom-date">
			<span class="my-date-day"><?php echo do_shortcode("[post_date format='j']"); ?></span>
			<span class="my-date-month"><?php echo do_shortcode("[post_date format='M']"); ?></span>
		</div>
	<?php }

}

add_filter( 'genesis_post_info', 'refined_post_info_filter' );
/**
 * Customize the post info output.
 *
 * @since 1.0.0
 *
 * @param  string $post_info String to output in the post info.
 * @return string $post_info Updated string to output.
 */
function refined_post_info_filter( $post_info ) {

	$post_info = '[post_categories before="" sep="&middot;"]';
    return $post_info;

}

add_filter( 'genesis_post_meta', 'refined_post_meta_filter' );
/**
 * Customize the post meta output.
 *
 * @since 1.0.0
 *
 * @param  string $post_meta String to output in the post meta.
 * @return string $post_meta Updated string to output.
 */
function refined_post_meta_filter( $post_meta ) {

    $post_meta = '[post_comments before="<i class="icon ion-paintbucket"></i>" zero="Leave a Comment" one="1 Comment" more="% Comments"]';
    return $post_meta;

}

/**
 * Function to output widget counts.
 *
 * @since 1.0.0
 *
 * @param  string $id The widget area id.
 * @return int        Number of active widgets in the widget area.
 */
function refined_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Function to get the flexible widget area class.
 *
 * @since 1.0.0
 *
 * @param  string $id    The widget area id.
 * @return string $class The appropriate class for the amount of widgets.
 */
function refined_widget_area_class( $id ) {

	$count = refined_count_widgets( $id );

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

add_filter( 'genesis_comment_list_args', 'refined_comments_gravatar' );
/**
 * Modify the size of the Gravatar in the entry comments.
 *
 * @since 1.0.0
 *
 * @param  array $args Array of available arguments.
 * @return array $args Updated arguments array.
 */
function refined_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'refined_author_box_gravatar' );
/**
 * Modify the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param  int $size Default size of Gravatar.
 * @return int       New size of Gravatar.
 */
function refined_author_box_gravatar( $size ) {
	return 200;
}

add_filter( 'genesis_gravatar_sizes', 'refined_user_profile' );
/**
 * Modify the size of the Gravatar in the Genesis User Profile Widget.
 *
 * @since 1.0.0
 *
 * @param  array $sizes Array of available sizes.
 * @return array $sizes Updated array of available sizes.
 */
function refined_user_profile( $sizes ) {

	$sizes['XXLarge'] = 300;
	return $sizes;

}

add_filter( 'comment_form_defaults', 'refined_remove_comment_form_allowed_tags' );
/**
 * Remove comment form allowed tags.
 *
 * @since 1.0.0
 *
 * @param  array $defaults Default arguments array.
 * @return array $defaults The modified arguments array.
 */
function refined_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

add_filter( 'excerpt_more', 'refined_read_more_link' );
add_filter( 'get_the_content_more_link', 'refined_read_more_link' );
add_filter( 'the_content_more_link', 'refined_read_more_link' );
/**
 * Customize 'Read More' text with accessibility.
 *
 * @since 1.0.0
 *
 * @param  string $more String of HTML to output.
 * @return string       New string to output.
 */
function refined_read_more_link( $more ) {

	$new_a11y_read_more_title = sprintf( '<span class="screen-reader-text">%s %s</span>', __( 'about ', 'refined' ), get_the_title() );
	return sprintf( ' ... <a href="%s" class="more-link">%s %s</a>', get_permalink(), __( 'Read More', 'refined' ), $new_a11y_read_more_title );

}

add_action( 'genesis_before', 'refined_announcement_widget', 8 );
/**
 * Hooks Announcement Widget.
 *
 * @since 1.0.0
 */
function refined_announcement_widget() {

    genesis_widget_area( 'announcement-widget', array(
		'before' => '<div class="announcement-widget widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ));

}

add_action( 'genesis_before_footer', 'refined_site_wide_cta', 8 );
/**
 * Hooks Site Wide CTA widget after the content.
 *
 * @since 1.0.0
 */
function refined_site_wide_cta() {

	if ( ! is_home() ) {

	    genesis_widget_area( 'site-wide-cta', array(
			'before' => '<div class="site-wide-cta widget-area"><div class="wrap">',
			'after'  => '</div></div>',
	    ));

	}

}

add_action( 'genesis_before_footer', 'refined_footer_widgets', 10 );
/**
 * Add the flexible footer widget area.
 *
 * @since 1.0.0
 */
function refined_footer_widgets() {

	genesis_widget_area( 'flex-footer', array(
		'before' => '<div id="flex-footer" class="flex-footer"><div class="wrap"><div class="flexible-widgets widget-area' . refined_widget_area_class( 'flex-footer' ) . '">',
		'after'  => '</div></div></div>',
	));

}

add_action( 'genesis_before_footer', 'refined_widget_below_footer', 9 );
/**
 * Hooks a widget area below footer.
 *
 * @since 1.0.0
 */
function refined_widget_below_footer() {

    genesis_widget_area( 'widget-below-footer', array(
		'before' => '<div class="widget-below-footer widget-area">',
		'after'  => '</div>',
    ));

}

// Load entry navigation.
add_action( 'genesis_after_entry', 'genesis_prev_next_post_nav', 9 );

add_filter('genesis_footer_creds_text', 'refined_footer_creds_text');
/**
 * Customize the credits.
 *
 * @since 1.0.0
 *
 * @param  string $creds Default string of HTML to output.
 * @return string $creds Modified string of HTML to output.
 */
function refined_footer_creds_text( $creds ) {

    $creds = '<div class="creds">Copyright [footer_copyright] &middot; <a target="_blank" href="http://restored316designs.com/themes">Refined theme</a> by <a target="_blank" href="http://www.restored316designs.com">Restored 316</a></div>';
    return $creds;

}

// Add theme support for WooCommerce.
add_theme_support( 'genesis-connect-woocommerce' );

// Remove related products.
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter('loop_shop_columns', 'refined_loop_columns');
/**
 * Change number or products per row to 3.
 *
 * @since 1.0.0
 *
 * @return int Number of WooCommerce shop columns.
 */
function refined_loop_columns() {
	return 3;
}

add_action( 'after_setup_theme', 'refined_woo_gallery' );
/**
 * Add WooCommerce gallery options.
 *
 * @since 1.0.0
 */
function refined_woo_gallery() {

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
}
