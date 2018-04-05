<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Pretty Chic' );
define( 'CHILD_THEME_URL', 'http://www.prettydarncute.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700|Playfair+Display:@import url(http://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic);', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//Woo Support
add_theme_support( 'genesis-connect-woocommerce' );

//* Add support for additional color styles
add_theme_support( 'genesis-style-selector', array(
	'prettychic-coral'   => __( 'Pretty Chic Coral', 'prettychic' ),
	'prettychic-pink'  => __( 'Pretty Chic Pink', 'prettychic' ),
	'prettychic-navy' => __( 'Pretty Chic Navy', 'prettychic' ),
	'prettychic-orchid' => __( 'Pretty Chic Orchid', 'prettychic' ),
	'prettychic-red' => __( 'Pretty Chic Red', 'prettychic' ),
	'prettychic-gray' => __( 'Pretty Chic Gray', 'prettychic' ),
) );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 132,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Position post info above post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] by [post_author_posts_link]';
	return $post_info;
}

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Enqueue Dashicons
add_action( 'wp_enqueue_scripts', 'enqueue_dashicons' );
function enqueue_dashicons() {

	wp_enqueue_style( 'dashicons' );

}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'prettychic_search_button_text' );
function prettychic_search_button_text( $text ) {

	return esc_attr( '&#xf179;' );

}

//* Add Support for Comment Numbering
add_action ('genesis_before_comment', 'afn_numbered_comments');
function afn_numbered_comments () {

    if (function_exists('gtcn_comment_numbering'))
    echo gtcn_comment_numbering($comment->comment_ID, $args);

}

// Responsive Menu
add_action( 'wp_enqueue_scripts', 'prettychic_enqueue_scripts' );
function prettychic_enqueue_scripts() {
	wp_enqueue_script( 'prettychic-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true ); 
 
}

/** Genesis Previous/Next Post Post Navigation */
add_action( 'genesis_before_comments', 'prettychic_prev_next_post_nav' );
 
function prettychic_prev_next_post_nav() {
  
	if ( is_single() ) {
 
		echo '<div class="prev-next-navigation">';
		previous_post_link( '<div class="previouspost">&#10094;&#10094; %link</div>', 'Previous Post' );
		next_post_link( '<div class="nextpost">%link &#10095; &#10095;</div>', 'Next Post' );
		echo '</div><!-- .prev-next-navigation -->';
	}
}

//* Add new featured image sizes
add_image_size( 'below content widget', 240, 240, TRUE );
add_image_size( 'sidebar featured', 100, 100, TRUE );
add_image_size( 'home-middle', 310, 200, true );
add_image_size( 'home-top', 700, 320, true );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'prettychic_secondary_menu_args' );
function prettychic_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;
}

//* Unregister Stuff
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
unregister_sidebar( 'sidebar-alt' );

//* Reposition Navigation Menus
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_footer', 'genesis_do_subnav' );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'prettychic' ),
	'description' => __( 'This is the top section of the homepage.', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'prettychic' ),
	'description' => __( 'This is the middle section of the homepage.', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'prettychic' ),
	'description' => __( 'This is the bottom section of the homepage.', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'prettychic' ),
	'description' => __( 'This is the after entry section.', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'            => 'below-content',
	'name'          => __( 'Below Content', 'prettychic' ),
	'description'   => __( 'This widget area appears on every page at the bottom', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'            => 'adspace',
	'name'          => __( 'AdSpace', 'prettychic' ),
	'description'   => __( 'The AdSpace Widget', 'prettychic' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-slider',
	'name'			=> __( 'Home Slider', 'prettychic' ),
	'description'	=> __( 'This is the slider widget area for your homepage.', 'prettychic' ),
) );

//* Hook Widget Areas
add_action( 'genesis_after_header', 'pdcd_adspace_widget' );
	function pdcd_adspace_widget() {
		genesis_widget_area( 'adspace', array(
			'before' => '<div class="adspace widget-area">',
			'after' => '</div>',
	) );
}
add_action( 'genesis_after_content', 'pdcd_every_page_widget' );
	function pdcd_every_page_widget() {
		genesis_widget_area( 'below-content', array(
			'before' => '<div class="below-content widget-area">',
			'after' => '</div>',
	) );
}
add_action( 'genesis_entry_footer', 'prettychic_after_entry_widget'  ); 
function prettychic_after_entry_widget() {

    if ( ! is_singular( 'post' ) )
    	return;

    genesis_widget_area( 'after-entry', array(
		'before' => '<div class="after-entry widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

}
add_action( 'genesis_before_loop', 'widget_before_loop');
function widget_before_loop() {
if ( is_home() && is_active_sidebar( 'home-slider' ) ) {
		genesis_widget_area( 'home-slider', array(
		'before' => '<div class="home-slider" class="widget-area">',
		'after'  => '</div>',
	) );
	}
}

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	?>
	<p><a href="https://prettydarncute.com/pretty-chic-wordpress-theme/">Pretty Chic Theme</a> By: <a href="https://prettydarncute.com/">Pretty Darn Cute Design</a></p>
	<?php
}