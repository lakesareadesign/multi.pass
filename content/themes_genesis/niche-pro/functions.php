<?php
/**
 * Niche Pro.
 *
 * This file adds functions to the Niche Pro Theme.
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/niche/
 */

// Start the engine.
require_once get_template_directory() . '/lib/init.php';

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Niche Pro' );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/niche/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'bloom_localization_setup' );
function bloom_localization_setup() {
	load_child_theme_textdomain( 'niche-pro', get_stylesheet_directory() . '/languages' );
}

// Set up Theme Customizer.
require_once get_stylesheet_directory() . '/inc/customize.php';

// Include Customizer CSS.
require_once get_stylesheet_directory() . '/inc/output.php';

// Add the required WooCommerce functions.
require_once get_stylesheet_directory() . '/inc/woocommerce/woocommerce-setup.php';

// Include notice to install Genesis Connect for WooCommerce.
require_once get_stylesheet_directory() . '/inc/woocommerce/woocommerce-notice.php';


/**
 * Global Enqueues.
 */
add_action( 'wp_enqueue_scripts', 'bloom_scripts_styles' );
function bloom_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Halant:300,400,600|Poppins:400,400i,700,700i', CHILD_THEME_VERSION );
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', CHILD_THEME_VERSION );

	wp_enqueue_script( 'bloom-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', time() );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'bloom-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, time() );
	wp_localize_script(
		'bloom-responsive-menu',
		'genesis_responsive_menu',
		bloom_responsive_menu_settings()
	);

}

/**
 * Responsive Menu Settings.
 */
function bloom_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'niche-pro' ),
		'menuIconClass'    => 'ion ion-android-menu',
		'subMenu'          => __( 'Menu', 'niche-pro' ),
		'subMenuIconClass' => 'ion ion-chevron-down',
		'menuClasses'      => array(
			'others' => array(
				'.nav-primary',
			),
		),
	);

	return $settings;

}

/**
 * Theme Setting Defaults.
 */
add_filter( 'genesis_theme_settings_defaults', 'bloom_theme_defaults' );
function bloom_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 4;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 250;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'bloom_portrait';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

/**
 * After switching theme defaults.
 */
add_action( 'after_switch_theme', 'bloom_theme_setting_defaults' );
function bloom_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings(
			array(
				'blog_cat_num'              => 4,
				'content_archive'           => 'full',
				'content_archive_limit'     => 250,
				'content_archive_thumbnail' => 1,
				'image_alignment'           => 'alignleft',
				'image_size'                => 'bloom_portrait',
				'posts_nav'                 => 'prev-next',
				'site_layout'               => 'content-sidebar',
			)
		);

	}

	update_option( 'posts_per_page', 4 );

}

/**
 * Simple Social Icon Defaults.
 */
add_filter( 'simple_social_default_styles', 'bloom_social_default_styles' );
function bloom_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#ffffff',
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_radius'          => 0,
		'border_width'           => 0,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#999999',
		'size'                   => 23,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}


/**
 * Genesis Responsive Slider Default Settings.
 */
add_filter( 'genesis_responsive_slider_settings_defaults', 'bloom_responsive_slider_defaults' );
function bloom_responsive_slider_defaults( $defaults ) {

	$defaults = array(
		'post_type'                       => 'post',
		'orderby'                         => 'date',
		'slideshow_timer'                 => 4000,
		'slideshow_delay'                 => 800,
		'slideshow_arrows'                => 0,
		'slideshow_pager'                 => 1,
		'slideshow_loop'                  => 1,
		'slideshow_height'                => 400,
		'slideshow_width'                 => 1000,
		'slideshow_effect'                => 'fade',
		'slideshow_excerpt_content'       => 'excerpt',
		'slideshow_excerpt_content_limit' => 150,
		'slideshow_more_text'             => 'Read More',
		'slideshow_excerpt_show'          => 0,
		'location_vertical'               => 'bottom',
		'location_horizontal'             => 'right',
		'slideshow_hide_mobile'           => 1,
	);

	return $defaults;

}

/**
 * Shortcut function for get_post_meta();
 */
function bloom_cf( $key = '', $id = '', $echo = false, $prepend = false, $append = false, $escape = false ) {
	$id    = ( empty( $id ) ? get_the_ID() : $id );
	$value = get_post_meta( $id, $key, true );
	if( $escape )
		$value = call_user_func( $escape, $value );
	if( $value && $prepend )
		$value = $prepend . $value;
	if( $value && $append )
		$value .= $append;

	if ( $echo ) {
		echo $value;
	} else {
		return $value;
	}
}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

// Add Structural Wraps.
add_theme_support(
	'genesis-structural-wraps', array(
		'header',
		'menu-primary',
		'footer-widgets',
		'footer',
	)
);

// Add screen reader class to archive description.
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support(
	'custom-header', array(
		'width'           => 2000,
		'height'          => 300,
		'header-selector' => '.site-title a',
		'header-text'     => false,
	)
);

// Add Image Sizes.
add_image_size( 'bloom_landscape', 1024, 800, true );
add_image_size( 'bloom_portrait', 800, 1024, true );
add_image_size( 'bloom_featured', 500, 665, true );
add_image_size( 'bloom_blog', 200, 300, true );
add_image_size( 'bloom_hometwo', 325, 380, true );
add_image_size( 'bloom_square', 300, 300, true );

// Rename primary and/or secondary navigation menus.
add_theme_support(
	'genesis-menus', array(
		'primary' => __( 'Header Menu', 'niche-pro' ),
	)
);

/**
 * Navigation Menus
 */

// Reposition the primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

add_filter( 'wp_nav_menu_items', 'bloom_menu_extras', 10, 2 );
/**
 * Filter menu items, appending either a search form or today's date.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function bloom_menu_extras( $menu, $args ) {

	// Change 'primary' to 'secondary' to add extras to the secondary navigation menu.
	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu  .= '<li class="right search">' . $search . '</li>';

	return $menu;

}

/**
 * Layouts
 */

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

/**
 * Widget Areas
 */

// Add support for shortcodes in widget areas.
add_filter( 'widget_text', 'do_shortcode' );

// Remove header right widget area.
unregister_sidebar( 'header-right' );

// Page Index.
genesis_register_sidebar(
	array(
		'id'          => 'page-index',
		'name'        => __( 'Index Page', 'niche-pro' ),
		'description' => __( 'This is the widget area on the "index" page template. It\'s perfect for a portfolio or an index of your categories.', 'niche-pro' ),
	)
);

// Page Instagram.
genesis_register_sidebar(
	array(
		'id'          => 'page-instagram',
		'name'        => __( 'Instagram Landing Page', 'niche-pro' ),
		'description' => __( 'This is the widget area on the "instagram" page template. It\'s perfect for a adding links and info about your site and brand.', 'niche-pro' ),
	)
);

// Home Page 1.
genesis_register_sidebar(
	array(
		'id'          => 'home-page-1',
		'name'        => __( 'Home Page 1', 'niche-pro' ),
		'description' => __( 'This is the first widget area on the home page.', 'niche-pro' ),
	)
);

// Home Page 2.
genesis_register_sidebar(
	array(
		'id'          => 'home-page-2',
		'name'        => __( 'Home Page 2', 'niche-pro' ),
		'description' => __( 'This is the second widget area on the home page.', 'niche-pro' ),
	)
);

// Home Page 3.
genesis_register_sidebar(
	array(
		'id'          => 'home-page-3',
		'name'        => __( 'Home Page 3', 'niche-pro' ),
		'description' => __( 'This is the third widget area on the home page.', 'niche-pro' ),
	)
);

// Between Posts Area.
genesis_register_sidebar(
	array(
		'id'          => 'between-posts-area',
		'name'        => __( 'Between Posts Area', 'niche-pro' ),
		'description' => __( 'This widget area shows up after the 2nd post.', 'niche-pro' ),
	)
);

// Footer Social Links.
genesis_register_sidebar(
	array(
		'id'          => 'footer-social-links',
		'name'        => __( 'Footer Social links', 'niche-pro' ),
		'description' => __( 'This widget area in the bottom left which is optimized to show your social media icons.', 'niche-pro' ),
	)
);

// Add Full width Instagram feed to the theme.
genesis_register_sidebar(
	array(
		'id'          => 'instagram',
		'name'        => __( 'Instagram Feed', 'niche-pro' ),
		'description' => __( 'This is the Instagram feed widget', 'niche-pro' ),
	)
);

// Add support for footer widget areas.
add_theme_support( 'genesis-footer-widgets', 3 );

/**
 * Between Posts Widget Area.
 */

// Add widget area after the 2nd post.
add_action( 'genesis_after_entry', 'bloom_between_posts_area' );
function bloom_between_posts_area() {

	if ( ! is_active_sidebar( 'between-posts-area' ) ) {
		return;
	}

	global $loop_counter;

	$loop_counter++;

	if ( $loop_counter === 2 ) {

		if ( is_active_sidebar( 'between-posts-area' ) ) {
			echo '<div class="between-posts-area widget-area">';
				dynamic_sidebar( 'between-posts-area' );
			echo '</div>';
		}
	}

}

/**
 * Footer Social Links.
 */

// Add widget area for the footer social links.
add_action( 'genesis_footer', 'bloom_between_footer_social_links', 5 );
function bloom_between_footer_social_links() {

	if ( is_active_sidebar( 'footer-social-links' ) ) {

		echo '<div class="footer-social-links widget-area">';
			dynamic_sidebar( 'footer-social-links' );
		echo '</div>';

	}

}

// Add Home Page 1, 2 and 3.
// Add front widget area on the home page.
add_action( 'genesis_before_content_sidebar_wrap', 'home_widget_areas' );
function home_widget_areas() {

	if ( is_front_page() && ! is_paged() ) {

		if ( is_active_sidebar( 'home-page-1' ) ) {

			echo '<div class="home-page-1 widget-area"><div class="wrap">';
				dynamic_sidebar( 'home-page-1' );
			echo '</div></div>';
		}

		if ( is_active_sidebar( 'home-page-2' ) ) {
			echo '<div class="home-page-2 widget-area"><div class="wrap">';
				dynamic_sidebar( 'home-page-2' );
			echo '</div></div>';
		}

		if ( is_active_sidebar( 'home-page-3' ) ) {
			echo '<div class="home-page-3 widget-area"><div class="wrap">';
				dynamic_sidebar( 'home-page-3' );
			echo '</div></div>';
		}
	}
}

// Entry Meta.
add_filter( 'genesis_post_info', 'bloom_entry_meta_header' );
function bloom_entry_meta_header( $post_info ) {
	$post_info = '[post_categories before="" after=" &middot;"] [post_date before="" after=""]';
	return $post_info;
}

// Position post info above post title.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

// Customize the entry meta in the entry footer.
add_filter( 'genesis_post_meta', 'bloom_post_meta_filter' );
function bloom_post_meta_filter( $post_meta ) {
	$post_meta = ' ';
	return $post_meta;
}


// Read more markup.
add_filter( 'get_the_content_limit', 'bloom_content_limit_read_more_markup', 10, 3 );
function bloom_content_limit_read_more_markup( $output, $content, $link ) {
	$output = sprintf( '<p>%s &#x02026;</p><p>%s</p>', $content, str_replace( '&#x02026;', '', $link ) );
	return $output;
}

// Shop the post custom field.
function bloom_shop_the_post() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page_template( 'page_blog.php' ) ) {

		$stp_code = bloom_cf( 'bloom-shop-the-post' );

		if ( !empty( $stp_code ) ) {
			return '<div class="shop-the-post"><h6>Featured Items</h6>'. do_shortcode( $stp_code ) .'</div>';
		}
	}
}

// Read more text.
add_filter( 'get_the_content_more_link', 'bloom_read_more_link' );
function bloom_read_more_link() {
	$output = '<a class="button more-link" href="' . get_permalink() . '">'. __('Read More', 'niche-pro') .'</a>';
	if ( function_exists( 'bloom_shop_the_post' ) ) {
		$output .= bloom_shop_the_post();
	}
	return $output;
}

// Add previous and next post links after entry.
add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav' );

// Change the footer text.
add_filter( 'genesis_footer_creds_text', 'bloom_footer_creds_filter' );
function bloom_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] ' . get_bloginfo( 'name' ) . ' &middot; <a href="https://designbybloom.co">Design By Bloom</a>';
	return $creds;
}

// Add Read More Link for Custom Excerpts.
function excerpt_read_more_link( $output ) {
	global $post;
	return $output . '<a href="' . get_permalink( $post->ID ) . '"> <div class="readmorelink"><div class="rmtext">'. __( 'Read More', 'niche-pro' ) .'</div></div></a>';
}
add_filter( 'the_excerpt', 'excerpt_read_more_link' );
add_filter( 'excerpt_more', '__return_false' );

// Reposition featured images (display post title to right of featured image on blog content archives).
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

add_action( 'genesis_before_header', 'instagram', 3 );
function instagram() {
	genesis_widget_area(
		'instagram', array(
			'before' => '<div class=instagram widget-area">',
			'after'  => '</div>',
		)
	);
}

// Add class for screen readers to site description.
add_filter( 'genesis_attr_site-description', 'genesis_attributes_screen_reader_class' );
