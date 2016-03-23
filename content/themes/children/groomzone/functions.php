<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Groom Zone' );
define( 'CHILD_THEME_URL', 'http://www.groom-zone.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

// Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}

// Add HTML5 markup structure
add_theme_support( 'html5' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background
//add_theme_support( 'custom-background' );

// adding custom header support (change width if you change the width of the container)
// add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 90 ) );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array( 
	'header',
	'nav',
	'subnav',
	'inner',
	'footer-widgets',
	'footer'
));

// THEME SETUP TIME **************************************
	/*
	this is where we clean up wordpress and genesis and remove things we don't really need and add things
	like our stylesheets and javascript libraries. be very careful when editing this file
	*/
	include_once( CHILD_DIR . '/library/bones.php');
	
	/* 
	bones for genesis uses some custom comment markup and in order to keep this file minimal, we're moving
	it to another file. to edit comments, check out this file:
	*/
	include_once( CHILD_DIR . '/library/comments.php');
	
	/*
	if you're using custom post types, you can use this example to create your own. You can also use the example templates
	if you want to customize the look of your custom post type
	pages
	*/
	//include_once( CHILD_DIR . '/library/custom-post-types.php');
	
	/*
	if you want to customize the backend for your clients, use this admin file to keep your functions neat and clean.
	*/
	//include_once( CHILD_DIR . '/library/admin.php'); 
	
	// don't update theme (it's custom right? so you don't need updates)
	add_filter( 'http_request_args', 'lad_dont_update', 5, 2 );

	// SCRIPTS, STYLES, & WP_HEAD ************************
	// remove default stylesheet
	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
	// enqueue base scripts and styles
	add_action('wp_enqueue_scripts', 'lad_scripts_and_styles', 999);
	// ie conditional wrapper
	add_filter( 'style_loader_tag', 'bones_ie_conditional', 10, 2 );
	// who uses the rsd link anyway? axe it
	remove_action( 'wp_head', 'rsd_link' );                    
	// remove Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link' );                       
	// index link
	remove_action( 'wp_head', 'index_rel_link' );                         
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             
	// Links for Adjacent Posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 
	// remove WP version
	remove_action( 'wp_head', 'wp_generator' );  
	
	// cleaning up wordpress (it's pretty messy)
	// remove p around images
	add_filter('the_content', 'lad_filter_ptags_on_images');
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'lad_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action('wp_head', 'lad_remove_recent_comments_style', 1);
	// clean up gallery output in wp
	add_filter('gallery_style', 'lad_gallery_style');
		// Remove unnecessary versioning query tags from scripts & stylesheets in header
		function _remove_script_version( $src ){
		$parts = explode( '?', $src );
		return str_replace("http://maps.google.com/maps/api/js","http://maps.google.com/maps/api/js?sensor=false&ver=3.5.1", $parts[0]);
		return str_replace("http://maps.google.com/maps/api/js","", $parts[0]);
		}
		add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
		add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
		// Easy way to move JavaScript to footer
		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_enqueue_scripts', 5);
		add_action('wp_footer', 'wp_print_head_scripts', 5);
	
	// GENESIS SEO OPTIONS ***************************
	//* Remove Genesis in-post SEO Settings
	remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
	//* Remove Genesis SEO Settings menu link
	remove_theme_support( 'genesis-seo-settings-menu' );

	// CHILD THEME IMAGE SIZES ***************************
	add_image_size( 'home-featured', 280, 100, TRUE );
	add_image_size( 'home-other', 300, 250, TRUE );

	add_image_size( 'lad_large_img', 620, 240, TRUE );
	add_image_size( 'lad_medium_img', 225, 225, TRUE );
	add_image_size( 'lad_small_img', 45, 45, TRUE );
	/* 
	to add more sizes, simply copy a line from above and change the dimensions & name. As long as you
	upload a "featured image" as large as the biggest set width or height, all the other sizes will be
	auto-cropped.
	
	To call a different size, simply change the text inside the thumbnail function.
	
	For example, to call the 225 x 225 sized image, we would use the function:
	<?php the_post_thumbnail( 'lad_medium_img' ); ?>
	
	You can change the names and dimensions to whatever you like.
	*/
		
	// SIDEBARS AND ASIDES *******************************
	/*
	if you want to remove sidebars, you can use the functions below. to add a sidebar, you can just register another.
	*/
	// unregister_sidebar( 'sidebar' );
	// unregister_sidebar( 'sidebar-alt' );
	
	/* 
	to register another sidebar you can use a function similar to the one below.
	// register a sidebar for a specific page
	genesis_register_sidebar(array(
		'name'=>'Sidebar Special',
		'id' => 'sidebar-special',
		'description' => 'An Example Special Sidebar.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>"
	));
	*/
	
	// FOOTER AREA ***************************************

	//* Reposition the footer
	remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
	add_action( 'genesis_header', 'genesis_footer_markup_open', 11 );
	add_action( 'genesis_header', 'genesis_do_footer', 12 );
	add_action( 'genesis_header', 'genesis_footer_markup_close', 13 );

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
	function lad_footer_output( $creds ) {
		$creds ='<p>Copyright © 2014 <br/> <a href="http://www.groom-zone.com/" title="Groom Zone">Groom Zone</a></p>';
	return $creds;
	}

	// if you want widgets in the footer, you can use this 
	//add_theme_support( 'genesis-footer-widgets', 3 );
	
	// COMMENTS & PINGBACKS ******************************
	// custom comment layout
	add_filter( 'genesis_comment_form_args','lad_custom_comment_form' );
	// trackback argument & layout
	add_filter( 'genesis_ping_list_args', 'lad_ping_list_args' );
	// comments & trackbacks
	add_filter( 'genesis_comment_list_args', 'lad_comment_list_args' );

	// CUSTOMIZING GENESIS *******************************
	/*
	you can unregister layouts if your child theme will mantain
	the same layout on every page and you don't want to offer
	your clients the option to change.
	*/
	genesis_unregister_layout( 'content-sidebar' );
	genesis_unregister_layout( 'sidebar-content' );
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	// genesis_unregister_layout( 'full-width-content' );
	
	//* Unregister secondary navigation menu
	add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'wintersong' ) ) );

	//* Unregister sidebars
	unregister_sidebar( 'sidebar' );
	unregister_sidebar( 'sidebar-alt' );

	//* Force full-width-content layout setting
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	//* Reposition the primary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

	// UNREGISTER GENESIS WIDGETS ****************************
	/*
	if you want to remove some of the default widgets that come
	with genesis, you can use this function.
	*/
	add_action( 'widgets_init', 'remove_genesis_widgets', 20 );
	/*
	to use this function, make sure to uncomment it out in 
	the theme setup function above.
	*/
	function remove_genesis_widgets() {
	    unregister_widget( 'Genesis_eNews_Updates' );
	    //unregister_widget( 'Genesis_Featured_Page' );
	    unregister_widget( 'Genesis_User_Profile_Widget' );
	    unregister_widget( 'Genesis_Menu_Pages_Widget' );
	    unregister_widget( 'Genesis_Widget_Menu_Categories' );
	    //unregister_widget( 'Genesis_Featured_Post' );
	    unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	}


// CUSTOM CHILD THEME FUNCTIONS /***********************
/*
Here's where you can add your functions for you child theme. remember to add / remove your actions
up top in the theme setup function so we can keep things organized.
*/

/******************************************
      MUST KEEP
******************************************/

/* My custom background addition */
//add_action('wp_footer', 'add_bg_images_div');
function add_bg_images_div () {
  echo '<div id="wave"></div>','<div id="low-bg"></div>';
}

/* Set Genesis Responsive Slider defaults */
add_filter( 'genesis_responsive_slider_settings_defaults', 'lad_responsive_slider_defaults' );
function lad_responsive_slider_defaults( $defaults ) {
	$defaults['slideshow_height'] = '300';
	$defaults['slideshow_width'] = '940';
	return $defaults;
}

/** Ecommerce -- Add product post type support for Geneiss layouts */
//add_theme_support( 'genesis-connect-woocommerce' );
//add_post_type_support( 'product', 'genesis-layouts' );

// Editor Styles
add_editor_style( /*'editor-style.css'*/ ); //Pulls from the child theme styles.css unless otherwise stated

/** Remove the page titles */
//add_action( 'get_header', 'child_remove_page_titles' );
function child_remove_page_titles() {
    if ( is_page() && ! is_page_template( 'page_blog.php' ) )
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

// Remove Unused User Settings and Add Custom Contact Methods
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );

/**
 * Customize Contact Methods
 */
add_filter( 'user_contactmethods', 'lad_contactmethods' );
function lad_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );
	
	return $contactmethods;
}

/** Register widget areas 
genesis_register_sidebar( array(
	'id'			=> 'home-welcome',
	'name'			=> __( 'Home: Welcome', 'lad' ),
	'description'	=> __( 'This is the welcome section of the homepage.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-slider',
	'name'			=> __( 'Home: Slider', 'lad' ),
	'description'	=> __( 'This is the slider section of the homepage.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-1',
	'name'			=> __( 'Home: Top One', 'lad' ),
	'description'	=> __( 'This is homepage content container 1.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-2',
	'name'			=> __( 'Home: Top Two', 'lad' ),
	'description'	=> __( 'This is homepage content container 2.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-left',
	'name'			=> __( 'Home: Left', 'lad' ),
	'description'	=> __( 'This is the left section of the homepage.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle',
	'name'			=> __( 'Home: Middle', 'lad' ),
	'description'	=> __( 'This is the middle section of the homepage.', 'lad' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-right',
	'name'			=> __( 'Home: Right', 'lad' ),
	'description'	=> __( 'This is the right section of the homepage.', 'lad' ),
) );
*/

/******************************************
 	NOT SURE ABOUT THESE
******************************************/

/*
 * Modify TinyMCE editor to remove unused items.
 * http://www.tinymce.com/wiki.php/TinyMCE3x:Buttons/controls*/

add_filter('tiny_mce_before_init', 'customformatTinyMCE' );
function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,pre,h1,h2,h3,h4';
	$init['theme_advanced_disable'] = 'strikethrough,underline,forecolor,justifyfull';

	return $init;
}

// Reposition Genesis Metaboxes
/**
 * Register a new meta box to the post / page edit screen, so that the user can set SEO options on a per-post or per-page basis.
 *
 * @category Genesis
 * @package Admin
 * @subpackage Inpost-Metaboxes
 *
 * @since 0.1.3
 *
 * @see genesis_inpost_seo_box() Generates the content in the meta box
 */
//remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
//add_action( 'admin_menu', 'lad_add_inpost_seo_box' );
function lad_add_inpost_seo_box() {

	if ( genesis_detect_seo_plugins() )
		return;
		
	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-seo' ) )
			add_meta_box( 'genesis_inpost_seo_box', __( 'Theme SEO Settings', 'genesis' ), 'genesis_inpost_seo_box', $type, 'normal', 'default' );
	}

}

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @category Genesis
 * @package Admin
 * @subpackage Inpost-Metaboxes
 *
 * @since 0.2.2
 *
 * @see genesis_inpost_layout_box() Generates the content in the boxes
 *
 * @return null Returns null if Genesis layouts are not supported
 */
//remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );
//add_action( 'admin_menu', 'lad_add_inpost_layout_box' );
function lad_add_inpost_layout_box() {

	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) )
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'default' );
	}

}

// POST SPECIFIC FUNCTIONS 
/** adding POST format support  */
add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio' ));
/** adding support for POST format images */
add_theme_support( 'genesis-post-format-images' );

/** Customize the POST info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (!is_page()) {
    $post_info = '[post_date] by [post_author_posts_link] &middot; [post_comments] [post_edit]';
    return $post_info;
}}
/** Customize the POST meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if (!is_page()) {
    $post_meta = '[post_categories before="Filed Under: "] &middot; [post_tags before="Tagged: "]';
    return $post_meta;
}}
/** Modify the size of the Gravatar in the author box */
add_filter( 'genesis_author_box_gravatar_size', 'lad_author_box_gravatar_size' );
function lad_author_box_gravatar_size($size) {
    return '78';
} 

/******************************************
	HOW TO USE HOOKS AND FILTERS
******************************************/

// USING GENESIS HOOKS /**********************************
/*
The Genesis Framework uses hooks to move content around.
Instead of listing them all out, I'll show you a quick example
so you can get a quick idea of how they work.

In this example, we're going to move the nav from underneath the
header to above the header. A very common practice. 

First we identify the element or function we want to move. We can
view a list of all the hooks here:
http://dev.studiopress.com/hook-reference

Once we identify the one we want to target, we remove the action:

remove_action( 'genesis_after_header', 'genesis_do_nav' ); 

Great, now it's gone. But we want it to display somewhere else. So
let's add it back in before the header:

add_action('genesis_before_header', 'genesis_do_nav'); 

That's it. reload your page and you should see it in it's new 
position. For an easier visual look of all the hooks in action,
check out this page:
http://www.nothingcliche.com/genesis-theme-framework-visual-hook-reference/

Here's an example function with an alert. Try to add this
example function in different spots to see where they land
in your child theme. It can help you visualize better.

 

//function genesis_do_example() {
	// enter your function here
?>	<div class="alert help">
		<p>This is an example function. Please replace this with your own custom function.</p>
	</div>
<?php }
*/

/*
To add it, just use the above example and replace the last function
with "genesis_do_example". So to add this example above the header,
you would use:

add_action('genesis_before_header', 'genesis_do_example'); 


// USING GENESIS FILTERS /******************************

Aside from hooks, Genesis uses filters to replace the 
content contained inside functions. While not as
flexible as hooks, filters can add an extra layer of
detail to your child themes.

You can find a list of all the filters here:
http://dev.studiopress.com/filter-reference

Let's use a live example to show how filters work. We're
going to change the attribution text as well as the 
"Back to Top" link located in the footer.
*/

// USING ANOTHER FOOTER CREDIT METHOD ABOVE /******************************

// changing the footer attribution
//add_filter('genesis_footer_creds_text', 'lad_footer_cred');
function lad_footer_cred($lad_ft) {
    $lad_ft = '&copy; ' . date("Y") . ' ' . get_bloginfo("name") .' &middot; Built by <a href="http://www.lakesareadesign.com/" title="Lakes Area Design">Lakes Area Design</a>.';
    return $lad_ft;
}

// customizing text from back to top link
//add_filter( 'genesis_footer_backtotop_text', 'lad_backtotop_text' );
	function lad_footer_backtotop_text($backtotop) {
		$backtotop = '[footer_backtotop text="Return to Top"]';
	return $backtotop;
}

/*
We added the add_filter function to the after theme setup 
function up top. 

That's it. It's way more complex than using hooks and sometimes
it can be pretty darn confusing to be quite honest. Luckily,
you can get by using mostly hooks.*/

