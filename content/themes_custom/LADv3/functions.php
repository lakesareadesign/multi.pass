<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'centric', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'centric' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Centric Theme', 'centric' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/centric/' );
define( 'CHILD_THEME_VERSION', '1.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'centric_load_scripts' );
function centric_load_scripts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,700|Spinnaker', array(), CHILD_THEME_VERSION );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_script( 'centric-global', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0', true );
	
}

//* Add new image sizes
add_image_size( 'featured-page', 960, 700, TRUE );
add_image_size( 'featured-post', 400, 300, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 360,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'centric-pro-charcoal' => __( 'Centric Charcoal', 'centric' ),
	'centric-pro-green'    => __( 'Centric Green', 'centric' ),
	'centric-pro-orange'   => __( 'Centric Orange', 'centric' ),
	'centric-pro-purple'   => __( 'Centric Purple', 'centric' ),
	'centric-pro-red'      => __( 'Centric Red', 'centric' ),
	'centric-pro-yellow'   => __( 'Centric Yellow', 'centric' ),
) );

//* Remove Unused User Settings
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
//* Remove Genesis SEO Settings menu link
remove_theme_support( 'genesis-seo-settings-menu' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'centric' ) ) );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//*========================
// Add Woo Projects Support
//*========================
//* Remove the default wrappers
remove_action( 'projects_before_main_content', 'projects_output_content_wrapper', 10 );
remove_action( 'projects_after_main_content', 'projects_output_content_wrapper_end', 10 );

//* Add the correct wrappers
add_action( 'projects_before_main_content', 'my_projects_output_content_wrapper', 10 );
add_action( 'projects_after_main_content', 'my_projects_output_content_wrapper_end', 10 );

function my_projects_output_content_wrapper() {
echo '<section class="content">';
}

function my_projects_output_content_wrapper_end() {
echo '</section>';
}

// //* Remove CSS by specific stylesheet
// add_action( 'wp_enqueue_scripts', 'jk_dequeue_projects_css', 999 );
// function jk_dequeue_projects_css() {
// 	wp_dequeue_style( 'projects-styles' ); // Disable general projects css
// 	wp_dequeue_style( 'projects-handheld' ); // Disable handheld projects css
// 	if ( is_project() ) {
// 		wp_dequeue_style( 'dashicons' ); // Disable dashicons
// 	}
// }
// //* Remove all styles regardless
// add_filter( 'projects_enqueue_styles', '__return_false' );

remove_action( 'projects_before_single_project_summary', 'projects_template_single_title', 10 );
add_filter( 'projects_show_page_title', false );
//*=================
// End Woo Projects
//*=================

//* Reposition Page Title
add_action( 'genesis_before', 'centric_post_title' );
function centric_post_title() {

	if ( is_page() && !is_page_template() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 );
		add_action( 'genesis_after_header', 'genesis_do_post_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif (is_page('journal') ) {
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'the_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_category() ) {
		// remove_action( 'genesis_before_loop', 'output_category_title' );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'single_cat_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_single()) {
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'single_post_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif (is_page('projects') || is_projects() ) {
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'projects_page_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif (is_page('project') || is_project() ) {
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'projects_template_single_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_search() ) {
        remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
        add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'genesis_do_search_title', 2 );
        add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
    }

}

function centric_open_post_title() {
	echo '<div class="page-title"><div class="wrap">';
	echo '<h1 class="entry-title" itemprop="headline">';
}

function centric_close_post_title() {
	echo '</h1>';
	echo '</div></div>';
}

// POST SPECIFIC FUNCTIONS 
//* adding POST format support  */
add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio' ));

//* adding support for POST format images */
add_theme_support( 'genesis-post-format-images' );

/** Customize the POST info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (!is_page()) {
    $post_info = '[post_date] by [post_author_posts_link] &middot; [post_comments] [post_edit]';
    return $post_info;
}}
//* Customize the POST meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if (!is_page()) {
    $post_meta = '[post_categories before="Filed Under: "] &middot; [post_tags before="Tagged: "]';
    return $post_meta;
}}

//* Prevent Page Scroll When Clicking the More Link
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );
function remove_more_link_scroll( $link ) {

	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'centric_author_box_gravatar_size' );
function centric_author_box_gravatar_size( $size ) {

	return 96;
	
}

//* Modify the size of the Gravatar in comments
add_filter( 'genesis_comment_list_args', 'centric_comment_list_args' );
function centric_comment_list_args( $args ) {

    $args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'centric_remove_comment_form_allowed_tags' );
function centric_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// add_filter( 'genesis_footer_creds_text', 'lad_footer_creds_text' );
// function lad_footer_creds() {
// }

add_filter( 'genesis_footer_output', 'lad_footer_output', 10, 3 );
function lad_footer_output() {
	echo '<a href="#" class="top">Return to top of page</a>';
	echo '<p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; <a href="http://www.lakesareadesign.com/" title="Lakes Area Design">Lakes Area Design</a>';
	echo '</p>';
}

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-widgets-1',
	'name'        => __( 'Home 1', 'centric' ),
	'description' => __( 'This is the first section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-2',
	'name'        => __( 'Home 2', 'centric' ),
	'description' => __( 'This is the second section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-3',
	'name'        => __( 'Home 3', 'centric' ),
	'description' => __( 'This is the third section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-4',
	'name'        => __( 'Home 4', 'centric' ),
	'description' => __( 'This is the fourth section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-5',
	'name'        => __( 'Home 5', 'centric' ),
	'description' => __( 'This is the fifth section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-6',
	'name'        => __( 'Home 6', 'centric' ),
	'description' => __( 'This is the sixth section of the home page.', 'centric' ),
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
return 'Zack Lieble for Mayor';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
