<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'lean-kickstart', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'lean-kickstart' ) );

// Add plugin related functions
require_once( get_stylesheet_directory() . '/lib/plugin-settings.php' );

// Add color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Kickstart Pro' );
define( 'CHILD_THEME_URL', 'http://demo.leanthemes.co/kickstart' );
define( 'CHILD_THEME_VERSION', '1.3.6' );

add_action( 'wp_enqueue_scripts', 'kickstart_fonts_scripts' );
// Enqueue fonts
function kickstart_fonts_scripts() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.6.3' );
	wp_enqueue_style( 'google-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'kickstart-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	$output = array(
		'mainMenu' => __( 'Menu', 'no-sidebar' ),
		'subMenu'  => __( 'Menu', 'no-sidebar' ),
	);
	wp_localize_script( 'kickstart-responsive-menu', 'KickstartL10n', $output );
}

add_action( 'wp_enqueue_scripts', 'kickstart_enqueue_backstretch_scripts' );
// Enqueue Backstretch script and prepare images for loading
function kickstart_enqueue_backstretch_scripts() {

	// Load scripts only if custom background or featured image is being used

	// If we're on a page with no featured image or background image, leave
	if ( is_page() && ! has_post_thumbnail() && ! get_background_image() ) {
		return;
	}

	// If we're not on a page and there's no background image, leave
	if ( ! is_page() && ! get_background_image() ) {
		return;
	}

	wp_enqueue_script( 'kickstart-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.js', array( 'jquery' ), '2.0.4' );
	wp_enqueue_script( 'kickstart-backstretch-set', get_stylesheet_directory_uri() . '/js/backstretch-set.js' , array( 'kickstart-backstretch' ), CHILD_THEME_VERSION );

	wp_localize_script( 'kickstart-backstretch-set', 'KickstartBackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );

	if ( is_home() ) {
		wp_localize_script( 'kickstart-backstretch-set', 'KickstartBackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );
	}
	else if ( has_post_thumbnail() ) {
		$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : '' );
		wp_localize_script( 'kickstart-backstretch-set', 'KickstartBackStretchImg', $image );
	}
	else {
		wp_localize_script( 'milton-backstretch-set', 'KickstartBackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );
	}

}

// Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

// Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background
add_theme_support( 'custom-background', array( 'wp-head-callback' => 'kickstart_background_callback' ) );

// Move menu to Header Right and remove the wrap div
remove_action( 'genesis_after_header','genesis_do_nav' ) ;
add_action( 'genesis_header_right','genesis_do_nav' );
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

// Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

// Unregister alternate layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Add custom background callback for background color
function kickstart_background_callback() {
    if ( ! get_background_color() ) {
        return;
    }
    printf( '<style>body { background-color: #%s; }</style>' . "\n", get_background_color() );
}

// Add support for 5-column footer widgets
add_theme_support( 'genesis-footer-widgets', 5 );

// Add post formats
add_theme_support( 'post-formats', array( 'aside', 'status', 'quote' ) );

// Add excerpt support for pages, because pages deserve excerpts too
add_post_type_support( 'page', 'excerpt' );

// Image sizes
add_image_size( 'post_featured', 480, 290, true );
add_image_size( 'post_medium', 400, 218, true );
add_image_size( 'post_large', 573, 285, true );

// Allow shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'the_content_more_link', 'kickstart_read_more_link' );
// Modify the WordPress read more link
function kickstart_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'lean-kickstart' ) . '</a>';
}

// Unregister sidebars
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );

// Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home Top', 'lean-kickstart' ),
	'description' => __( 'This is the top section of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top-slider',
	'name'        => __( 'Home Top (Slider)', 'lean-kickstart' ),
	'description' => __( 'Add a slider (if you must).', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top-callout',
	'name'        => __( 'Home Top (Callout)', 'lean-kickstart' ),
	'description' => __( '(Optional) text in the top right of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top-news',
	'name'        => __( 'Home Top (News Row)', 'lean-kickstart' ),
	'description' => __( 'Widget area for the Home Top (News) row.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row1-left',
	'name'        => __( 'Home Row #1 (Left)', 'lean-kickstart' ),
	'description' => __( 'This is the first row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row1-right',
	'name'        => __( 'Home Row #1 (Right)', 'lean-kickstart' ),
	'description' => __( 'This is the first row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row2',
	'name'        => __( 'Home Row #2', 'lean-kickstart' ),
	'description' => __( 'This is the second row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row3-left',
	'name'        => __( 'Home Row #3 (Left)', 'lean-kickstart' ),
	'description' => __( 'This is the third row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row3-right1',
	'name'        => __( 'Home Row #3 (Right #1)', 'lean-kickstart' ),
	'description' => __( 'This is the third row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row3-right2',
	'name'        => __( 'Home Row #3 (Right #2)', 'lean-kickstart' ),
	'description' => __( 'This is the third row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row4',
	'name'        => __( 'Home Row #4', 'lean-kickstart' ),
	'description' => __( 'This is the fourth row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row5',
	'name'        => __( 'Home Row #5', 'lean-kickstart' ),
	'description' => __( 'This is the fifth row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row6',
	'name'        => __( 'Home Row #6', 'lean-kickstart' ),
	'description' => __( 'This is the sixth row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'lean-newsletter',
	'name'        => __( 'Home Row Newsletter', 'lean-kickstart' ),
	'description' => __( 'Put your Genesis - eNews Extended widget here.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-row7',
	'name'        => __( 'Home Row #7', 'lean-kickstart' ),
	'description' => __( 'This is the seventh row of the homepage.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'blog-top',
	'name'        => __( 'Archive / Blog Page (Top)', 'lean-kickstart' ),
	'description' => __( 'The before content area on Archives (e.g. Category, Tag) and for the Blog page template.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'kickstart-contact-map',
	'name'        => __( 'Contact Page (Map)', 'lean-kickstart' ),
	'description' => __( 'Widget area for the Contact page top section map.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'kickstart-contact-box',
	'name'        => __( 'Contact Page (Box)', 'lean-kickstart' ),
	'description' => __( 'Widget area for the Contact page top section box.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'lean-pricing',
	'name'        => __( 'Pricing Page (Top)', 'lean-kickstart' ),
	'description' => __( 'Widget area for the Pricing page top section.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer Widgets (Twitter)', 'lean-kickstart' ),
	'description' => __( 'Works well with the Genesis Latest Tweets plugin.', 'lean-kickstart' ),
) );
genesis_register_sidebar( array(
	'id'          => 'footer-social',
	'name'        => __( 'After Footer Widgets (Social)', 'lean-kickstart' ),
	'description' => __( 'Designed to work with the Simple Social Icons widget.', 'lean-kickstart' ),
) );

// Move post info above the post title
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

add_action( 'genesis_before_entry', 'kickstart_remove_elements' );
// Remove elements with post formats
function kickstart_remove_elements() {
	// Remove if post has format
	if ( get_post_format() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}
	// Add back, as post has no format
	else {
		add_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}
}

add_action ( 'genesis_before_footer', 'kickstart_before_footer', 5 );
// Add the 'before footer' widget area (before the erm, footer)
function kickstart_before_footer() {
	genesis_widget_area( 'before-footer', array(
		'before' => '<section class="before-footer"><div class="wrap">',
		'after'  => '</div></section>',
	) );
}

add_action ( 'genesis_before_footer', 'kickstart_footer_social', 15 );
// Add the 'footer social' widget area
function kickstart_footer_social() {
	genesis_widget_area( 'footer-social', array(
		'before' => '<section class="footer-social"><div class="wrap">',
		'after'  => '</div></section>',
	) );
}

add_action( 'genesis_after_header', 'kickstart_blog_top' );
// Add Blog top area
function kickstart_blog_top() {
	// Don't show this widget area on a 'static' / widgetised Front page or the default fallback 'your latest posts' page)
	if ( is_front_page() ) {
		return;
	}
	// Only show on an archive page or a specifically set 'Posts page' or the Genesis blog page template
	if ( ! is_archive() && ! is_home() && ! is_page_template( 'page_blog.php' ) ) {
		return;
	}
	genesis_widget_area( 'blog-top', array(
		'before' => '<div id="blog-top" class="blog-top widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

add_filter( 'genesis_search_text', 'kickstart_search_text' );
// Customize search form input box text
function kickstart_search_text( $text ) {
	$search_text = __( 'Search', 'lean-kickstart' );

	return $search_text;
}

add_filter( 'genesis_search_button_text', 'kickstart_search_button_text' );
// Customize search form input button text
function kickstart_search_button_text( $text ) {
	$searchbutton_text = __( 'Go', 'lean-kickstart' );

	return $searchbutton_text;
}

add_action( 'genesis_after_entry', 'kickstart_single_next_prev', 5 );
// Next / previous post links
function kickstart_single_next_prev() {
	// Only show on single pages
	if( !is_single() ) {
		return;
	}

	$previouspost_text =  __( 'Previous Post', 'lean-kickstart' );
	$nextpost_text     =  __( 'Next Post', 'lean-kickstart' );

	echo '<div class="archive-pagination pagination">';
		previous_post_link( '<div class="pagination-previous alignleft">%link</div>', $previouspost_text );
		next_post_link( '<div class="pagination-next alignright">%link</div>', $nextpost_text );
	echo '</div>';
}
