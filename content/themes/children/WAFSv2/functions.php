<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'lifestyle', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'lifestyle' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Lifestyle Pro Theme', 'lifestyle' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/lifestyle/' );
define( 'CHILD_THEME_VERSION', '3.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'lifestyle_load_scripts' );
function lifestyle_load_scripts() {
	
	wp_enqueue_script( 'lifestyle-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	// Remove Genesis Responsive Slider stylesheet
	remove_action( 'wp_print_styles', 'genesis_responsive_slider_styles' );
	// Add Genesis Responsive Slider stylesheet in CHILD THEME
	wp_enqueue_style( 'lad_genesis_slider', CHILD_URL . '/genesis-responsive-slider.css', array(), PARENT_THEME_VERSION );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Droid+Sans:400,700|Roboto+Slab:400,300,700', array(), CHILD_THEME_VERSION );
	
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
'header',
'nav',
'subnav',
'site-inner',
'footer-widgets',
'footer',
'header-image'
) ); 

// Don’t Strip HTML from Excerpts or Content Limit Teasers
add_filter('get_the_content_limit_allowedtags', 'lifestyle_custom_allowedtags');
function lifestyle_custom_allowedtags() {
return '<script>,<style>,<b>,<br>,<em>'; //add whatever tags you want to this string
}

//* Add new image sizes
add_image_size( 'home-large', 714, 360, TRUE );
add_image_size( 'home-small', 266, 160, TRUE );

// Set defaults image properties  [ ALIGN | LINK TYPE | SIZE | GZIP ]
add_action('admin_init', 'lad_image_defaults', 10);
function lad_image_defaults() {
	update_option('image_default_align', 'left');		//  file | post | custom | none
	update_option('image_default_link_type', 'none');	//  left | center | right | none
	update_option('image_default_size', 'medium');		//	thumbnail | full | medium | large
	update_option('gzipcompression', '1');				//	0 | 1
}

//* Remove the site title
//remove_action( 'genesis_site_title', 'genesis_seo_site_title' ); 
//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' ); 


//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'lifestyle-pro-brown'    => __( 'Brown', 'lifestyle' ),
	'lifestyle-pro-mustard'   => __( 'Brown 2', 'lifestyle' ),
	'lifestyle-pro-green'   => __( 'Green', 'lifestyle' ),
) );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'lifestyle_author_box_gravatar' );
function lifestyle_author_box_gravatar( $size ) {

	return 96;
		
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'lifestyle_comments_gravatar' );
function lifestyle_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'lifestyle_remove_comment_form_allowed_tags' );
function lifestyle_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// FOOTER AREA ***************************************

	add_action('wp_footer', 'go_to_top');
	function go_to_top() { ?>
	    <script type="text/javascript">
	        jQuery(function($) {
	            $('a.top').click(function() {
	                $('html, body').animate({scrollTop:0}, 'slow');
	                return false;
	            });
	        });
	    </script>
	<?php }

	add_filter( 'genesis_footer_output', 'lad_footer_output', 10, 3 );
	function lad_footer_output() {
		echo '<a href="#" class="top">Return to top of page</a>';
		echo '<p>';
		echo 'Copyright &copy; ';
		echo date('Y');
		echo ' &middot; <a href="http://www.lakesareadesign.com/" title="Willmar Area Food Shelf">Willmar Area Food Shelf</a>';
		echo '</p>';
		echo '<p>Design and hosting courtesy of <a href="http://www.lakesareadesign.com/" title="Lakes Area Design">Lakes Area Design</a></p>';
	}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'lifestyle' ),
	'description' => __( 'This is the top section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'lifestyle' ),
	'description' => __( 'This is the middle section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-left',
	'name'        => __( 'Home - Bottom Left', 'lifestyle' ),
	'description' => __( 'This is the bottom left section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-right',
	'name'        => __( 'Home - Bottom Right', 'lifestyle' ),
	'description' => __( 'This is the bottom right section of the homepage.', 'lifestyle' ),
) );


//* Add support for custom login
add_action('login_head', 'custom_login_css');
function custom_login_css() {
	wp_enqueue_style( 'login_head', get_stylesheet_directory_uri(). '/login/login-styles.css' );
}

function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Willmar Area Food Shelf';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

