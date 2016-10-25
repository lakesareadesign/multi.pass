<?php

//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'hello_pro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'hello_pro' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Hello Pro', 'hello_pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/hello' );
define( 'CHILD_THEME_VERSION', '1.5.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Styles and Scripts
add_action( 'wp_enqueue_scripts', 'hello_pro_load_scripts' );
function hello_pro_load_scripts() {

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Comfortaa:400,700|Lato:400,300,300italic,400italic,700,700italic', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'hello-pro-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'hello-pro-debounce', get_stylesheet_directory_uri() . '/js/debounce.js', array( 'jquery' ), '1.0.0', true );

	if ( is_front_page() ) {
		wp_enqueue_script( 'theme-custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array( 'hello-pro-debounce' ), '1.0.0', true );
	}

}

//* Demo Functions
include_once( get_stylesheet_directory() . '/demo-functions.php' );

//* Theme Image Sizes
add_image_size( 'featured', 300, 100, true );
add_image_size( 'portfolio', 300, 200, true );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'hello-pro-green' => __( 'Hello Green', 'hello_pro' ),
	'hello-pro-orange'  => __( 'Hello Orange', 'hello_pro' ),
	'hello-pro-purple' => __( 'Hello Purple', 'hello_pro' ),
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Relocate the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Add CSS class if admin bar is visible
add_action( 'genesis_after_header', 'hello_pro_add_adminclass_js'  );
function hello_pro_add_adminclass_js() {

	if ( is_admin_bar_showing() ) {
		echo '<script type="text/javascript">'."\n";
		echo 'jQuery(document).ready(function($) {'."\n";
		echo '$(".site-header").addClass("admin-loggedin");'."\n";
		echo '});</script>'."\n";
	}

}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 320,
	'height'          => 110,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );

//* Sticky Navigation for Header Right Menu
add_action( 'wp_enqueue_scripts', 'hello_pro_add_sticky_nav_script' );
function hello_pro_add_sticky_nav_script() {

	global $wp_registered_sidebars;
	if ( isset( $wp_registered_sidebars['header-right'] ) ) {
		wp_enqueue_script( 'sticky-nav-script', get_stylesheet_directory_uri() . '/js/sticky-nav.js', array('hello-pro-debounce'), '1.0.0', true );
	}

}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'hello_pro_secondary_menu_args' );
function hello_pro_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Create Portfolio Type custom taxonomy
add_action( 'init', 'hello_pro_type_taxonomy' );
function hello_pro_type_taxonomy() {

	register_taxonomy( 'portfolio-type', 'portfolio',
		array(
			'labels' => array(
				'name'          => _x( 'Types', 'taxonomy general name', 'hello_pro' ),
				'add_new_item'  => __( 'Add New Portfolio Type', 'hello_pro' ),
				'new_item_name' => __( 'New Portfolio Type', 'hello_pro' ),
			),
			'exclude_from_search' => true,
			'has_archive'         => true,
			'hierarchical'        => true,
			'rewrite'             => array( 'slug' => 'portfolio-type', 'with_front' => false ),
			'show_ui'             => true,
			'show_tagcloud'       => false,
		)
	);

}

//* Create portfolio custom post type
add_action( 'init', 'hello_pro_portfolio_post_type' );
function hello_pro_portfolio_post_type() {

	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name'          => __( 'Portfolio', 'hello_pro' ),
				'singular_name' => __( 'Portfolio', 'hello_pro' ),
			),
			'has_archive'  => true,
			'hierarchical' => true,
			'menu_icon'    => get_stylesheet_directory_uri() . '/lib/icons/portfolio.png',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'portfolio', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
			'taxonomies'   => array( 'portfolio-type' ),

		)
	);

}

//* Add Portfolio Type Taxonomy to columns
add_filter( 'manage_taxonomies_for_portfolio_columns', 'hello_pro_portfolio_columns' );
function hello_pro_portfolio_columns( $taxonomies ) {

	$taxonomies[] = 'portfolio-type';
	return $taxonomies;

}

//* Change the number of portfolio items
add_action( 'pre_get_posts', 'hello_pro_portfolio_items' );
function hello_pro_portfolio_items( $query ) {

	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', '12' );
	}

}

//* Customize Portfolio post info and post meta
add_filter( 'genesis_post_info', 'hello_pro_portfolio_post_info_meta' );
add_filter( 'genesis_post_meta', 'hello_pro_portfolio_post_info_meta' );
function hello_pro_portfolio_post_info_meta( $output ) {

	 if( 'portfolio' == get_post_type() )
		return '';

	return $output;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-welcome',
	'name'        => __( 'Home - Welcome', 'hello_pro' ),
	'description' => __( 'Introduce yourself! Welcome visitors to your homepage by using a text widget in this space with up to 500 characters of establishing copy.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-image',
	'name'        => __( 'Home - Image', 'hello_pro' ),
	'description' => __( 'Show off your smile! Put your headshot here. We recommend a transparent PNG image 315px by 380px.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-cta',
	'name'        => __( 'Home - Call To Action', 'hello_pro' ),
	'description' => __( 'Engage your audience. Add your primary call to action text and opt-in form here. Think about what you value you can offer in exchange for their valuable email address.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-features',
	'name'        => __( 'Home - Features', 'hello_pro' ),
	'description' => __( 'This three-column widget area can display text, recent posts, or page excerpts. We recommend highlighting three services, products, or features of your business, practice, or organization.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-headline',
	'name'        => __( 'Home - Headline', 'hello_pro' ),
	'description' => __( 'Make a bold statement! Put up to 70 characters of text here.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-portfolio',
	'name'        => __( 'Home - Portfolio', 'hello_pro' ),
	'description' => __( 'Show off your work. Use featured images to pull 3, 6, or 9 portfolio items into this homepage feature area. Also works with posts or pages.', 'hello_pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-testimonial',
	'name'        => __( 'Home - Testimonial', 'hello_pro' ),
	'description' => __( 'Let others do the talking. Feature a client quote or testimonial in this space at the bottom of your homepage. You can also use to feature other content.', 'hello_pro' ),
) );
