<?php
/**
 * Theme setup
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined in the files included in this setup function or below.
 *
 */
add_action( 'genesis_setup', 'bbs_child_theme_setup', 15 );
function bbs_child_theme_setup() {

    //* Child theme (do not remove)
    define( 'CHILD_THEME_NAME', 'Gallery Pro' );
    define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/gallery/' );
    define( 'CHILD_THEME_VERSION', '1.0.0' );

    // Genesis Framework
    include_once( get_template_directory() . '/lib/init.php' );

    // Genesis Changes
    include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );

    // Theme Defaults
    include_once( get_stylesheet_directory() . '/inc/theme-defaults.php' );

    // Adds customizer support
    include_once( get_stylesheet_directory() . '/inc/customizer/customizer.php' );
    include_once( get_stylesheet_directory() . '/inc/customizer/output.php' );

    // Adds post options custom fields
    include_once( get_stylesheet_directory() . '/inc/post-options.php' );

    // Register Widgets
    include_once( get_stylesheet_directory() . '/inc/widgets.php' );

    // Add Genesis Connect for WooCommerce
    add_theme_support( 'genesis-connect-woocommerce' );

    // Global enqueues
    add_action( 'wp_enqueue_scripts', 'bbs_global_enqueues' );

    // Add Before Header Widget
    add_action( 'genesis_before_header', 'bbs_before_header_widget' );

    //* Add image sizes
    add_image_size( 'portfolio', 600, 800, TRUE );
    add_image_size( 'square', 500, 500, TRUE );
    add_image_size( 'rectangle-landscape', 900, 600, TRUE );
    add_image_size( 'rectangle-portrait', 600, 900, TRUE );

}


/**
 * Global enqueues
 *
 */
function bbs_global_enqueues() {

    // javascript
    wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), CHILD_THEME_VERSION );
    wp_enqueue_script( 'bbs-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'fitvids' ), CHILD_THEME_VERSION );
    wp_enqueue_script( 'bbs-headhesive', get_stylesheet_directory_uri() . '/js/headhesive.min.js', array( 'jquery' ), CHILD_THEME_VERSION );
    wp_enqueue_script( 'bbs-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION );

    // css
    wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Cormorant:400,400i,700,700i|Open+Sans:300,300i,600,600i,700,700i', array(), CHILD_THEME_VERSION );

}

/**
 * Dont Update the Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @author Bill Erickson
 * @link   http://www.billerickson.net/excluding-theme-from-updates
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
function ea_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) )
 		return $r; // Not a theme update request. Bail immediately.
 	$themes = json_decode( $r['body']['themes'] );
 	$child = get_option( 'stylesheet' );
	unset( $themes->themes->$child );
 	$r['body']['themes'] = json_encode( $themes );
 	return $r;
 }


/**
 * Header
 *
 */

// Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 800,
	'height'          => 340,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => false,
) );

// Add the before-header widget area before the Header
function bbs_before_header_widget() {
  genesis_widget_area( 'before-header', array(
    'before' => '<div class="before-header">',
    'after'  => '</div>',
  ) );
}


/**
* Navigation
*
*/

// Rename primary, secondary and tertiary navigation menus
add_theme_support ( 'genesis-menus' , array (
	'primary' 	=> __( 'Above Header Menu', 'bbs' ),
	'secondary' => __( 'Below Header Menu', 'bbs' ),
  'tertiary'  => __( 'Footer Menu', 'bbs' )
) );

//* Add Footer Menu
add_action( 'genesis_before_footer', 'bbs_add_footer_menu' );
function bbs_add_footer_menu() {

  if ( has_nav_menu( 'tertiary' ) ) {

    wp_nav_menu( array(
      'theme_location' => 'tertiary',
      'container_class' => 'genesis-nav-menu'
    ) );

  }

}


/**
* Blog
*
*/

add_action( 'genesis_entry_footer', 'bbs_add_excerpt_below_limited_content' );
function bbs_add_excerpt_below_limited_content() {

  $post = get_post( get_the_ID() );
  $excerpt = $post->post_excerpt;

  if ( is_singular() || empty( $excerpt ) )
		return;

  echo '<div class="manual-excerpt">' . $excerpt . '</div></div>';
}

/**
* Footer
*
*/

// Add footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


/**
* Helper Functions
*
*/

//* Change WooCommerce to display 8 products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 20 );

/**
 * Shortcut function for get_post_meta();
 *
 * @since 1.2.0
 * @param string $key
 * @param int $id
 * @param boolean $echo
 * @param string $prepend
 * @param string $append
 * @param string $escape
 * @return string
 */
function bbs_cf( $key = '', $id = '', $echo = false, $prepend = false, $append = false, $escape = false ) {
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

// Setup widget counts
function bbs_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Flexible widget classes
function bbs_widget_area_class( $id ) {

	$count = bbs_count_widgets( $id );

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
