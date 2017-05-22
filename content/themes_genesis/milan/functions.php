<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add accent color to customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Implement custom header feature
require_once( get_stylesheet_directory() . '/lib/custom-header.php' );

//* Jetpack compatibility file
require_once( get_stylesheet_directory() . '/lib/jetpack.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Milan Pro' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/milan/' );
define( 'CHILD_THEME_VERSION', '1.1.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'milan_fonts' );
function milan_fonts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic|Roboto:100,300italic,300,400italic,700,700italic', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
}

//* Enqueue JavaScript
add_action( 'wp_enqueue_scripts', 'milan_js' );
function milan_js() {

	//* Enqueue necessary JavaScript
	wp_enqueue_script( 'milan', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ), CHILD_THEME_VERSION );
	wp_enqueue_script( 'milan-navigation', get_stylesheet_directory_uri() . '/js/navigation.js', array(), CHILD_THEME_VERSION, true );

	//* Superfish is not used
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom logo
add_theme_support( 'custom-logo', array(
	'height'      => 118,
	'width'       => 118,
	'flex-height' => true,
	'flex-width'  => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add theme support for selective refresh for widgets.
add_theme_support( 'customize-selective-refresh-widgets' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'milan' ) ) );

//* Remove default primary nav output (we'll include it elsewhere)
remove_action( 'genesis_after_header', 'genesis_do_nav' );

//* Unregister unwanted layout settings and sidebars
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove unused page templates. Hat tip: http://www.billerickson.net/remove-genesis-page-templates/
add_filter( 'theme_page_templates', 'milan_page_templates' );
function milan_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

//* Remove unused Genesis admin meta boxes. Hat tip: https://thomasgriffin.io/remove-metaboxes-genesis-theme-seo-settings-pages/
add_action( 'genesis_admin_before_metaboxes', 'milan_remove_genesis_theme_metaboxes' );
function milan_remove_genesis_theme_metaboxes( $hook ) {
	remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );
	remove_meta_box( 'genesis-theme-settings-posts', $hook, 'main' );
	remove_meta_box( 'genesis-theme-settings-header', $hook, 'main' );
}

//* Featured image support
add_image_size( 'rectangle', 700, 350, true );
add_image_size( 'square', 350, 350, true );

//* Add menu toggle markup
add_action( 'genesis_header', 'milan_menu_toggle' );
function milan_menu_toggle() { ?>
	<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Primary Navigation Menu', 'milan' ); ?></span></button>
<?php }

//* Add slide out markup
add_action( 'genesis_after_header', 'milan_slide_out' );
function milan_slide_out() { ?>
	<div id="slide-menu" class="slide-menu">
		<?php if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		} ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</div><!-- #slide-menu -->
<?php }

//* Make sure JavaScript variables are translatable
add_action( 'genesis_after', 'milan_js_i18n' );
function milan_js_i18n() { ?>
	<script type='text/javascript'>
	/* <![CDATA[ */
	var js_i18n = {"next":"<?php echo esc_html_x( 'next', 'screen reader text for main menu subpages', 'milan' ); ?>","back":"<?php echo esc_html_x( 'Back', 'text to navigate from subpages', 'milan' ); ?>"};
	/* ]]> */
	</script>
<?php }

//* Remove entry footer sitewide, we place this information elsewhere
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Customize the blog entry meta
add_filter( 'genesis_post_info', 'milan_post_info' );
function milan_post_info( $post_info ) {

	if ( is_home() || is_search() ) {
		$post_info = '[post_date] [post_author_posts_link]';
	} elseif ( is_archive() ) {
		$post_info = '[post_date]';
	} elseif ( is_single() ) {
		$post_info = '';
	}

	return $post_info;
}

//* Open #article-wrap div
add_action( 'genesis_before_while', 'milan_open_article_wrap' );
function milan_open_article_wrap() {
  if ( is_home() || is_search() ) {
		echo '<div id="article-wrap">';
	}
}

//* Close #article-wrap div
add_action( 'genesis_after_endwhile', 'milan_close_article_wrap' );
function milan_close_article_wrap() {
  if ( is_home() || is_search() ) {
		echo '</div><!-- #article-wrap -->';
	}
}

//* Adjust markup of blog and search entries
add_action( 'genesis_entry_header', 'milan_open_article_div', 1 );
function milan_open_article_div() {
	if ( is_home() || is_search() ) {
		the_post_thumbnail( 'square' );
		echo '<div class="article-content">';
	}
}

add_action( 'genesis_entry_footer', 'milan_close_article_div', 1 );
function milan_close_article_div() {
	if ( is_home() || is_search() ) {
		echo '</div>';
	}
}

//* Force excerpts to display on blog index
add_action( 'genesis_before_loop', 'milan_force_excerpts' );
function milan_force_excerpts() {
  if ( is_home() || is_search() ) {
		add_filter( 'genesis_pre_get_option_content_archive', 'milan_show_excerpts' );
	}
}

function milan_show_excerpts() {
	return 'excerpts';
}

//* Limit word count on excerpts
add_filter( 'excerpt_length', 'milan_excerpt_length', 999 );
 function milan_excerpt_length( $length ) {
	return 30;
}

//* Alter search box text
add_filter( 'genesis_search_text', 'milan_search_text' );
function milan_search_text( $text ) {
	return esc_attr_x( 'Search &#x2026;', 'search placeholder text', 'milan' );
}

//* Replace search submit value with icon. Hat tip: https://gist.github.com/srikat/8099554
add_filter( 'genesis_search_button_text', 'milan_search_button_text' );
function milan_search_button_text( $text ) {
	return esc_attr( '&#xf002;' );
}

//* Alter previous text to remove double arrows
add_filter( 'genesis_prev_link_text', 'milan_prev_link_text' );
function milan_prev_link_text() {
	$prevlink = esc_html__( 'Previous', 'milan' );
	return $prevlink;
}

//* Alter next text to remove double arrows
add_filter( 'genesis_next_link_text', 'milan_next_link_text' );
function milan_next_link_text() {
	$nextlink = esc_html__( 'Next', 'milan' );
	return $nextlink;
}

//* Alter previous text to remove double arrows
add_filter( 'genesis_prev_comments_link_text', 'milan_prev_comments_link_text' );
function milan_prev_comments_link_text() {
	$prevlink = esc_html__( 'Older Comments', 'milan' );
	return $prevlink;
}

//* Alter next text to remove double arrows
add_filter( 'genesis_next_comments_link_text', 'milan_next_comments_link_text' );
function milan_next_comments_link_text() {
	$nextlink = esc_html__( 'Newer Comments', 'milan' );
	return $nextlink;
}

//* Alter comments header markup
add_filter( 'genesis_title_comments', 'milan_comments_title' );
function milan_comments_title() {
	$title_text = esc_html__( 'Comments', 'milan' );
	$title = '<div class="comments-header"><h3 class="comments-title">' . $title_text . '</h3></div>';
	return $title;
}

//* Add social menu after footer
add_action( 'genesis_footer', 'milan_social_footer', 10 );
function milan_social_footer() {
	if ( is_active_sidebar( 'social-footer' ) ) {
		echo '<div class="social-footer">';
			dynamic_sidebar( 'social-footer' );
		echo '</div>';
	}
}

//* Remove sidebar on certain pages
add_action( 'genesis_before_loop', 'milan_remove_archive_sidebar' );
function milan_remove_archive_sidebar() {
	if ( is_archive() || is_404() ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	}
}

//* Register Featured Content widget
register_sidebar( array(
	'name'          => __( 'Featured Content', 'milan' ),
	'id'            => 'featured-content',
	'description'   => __( 'This widget area is intended to house a two instances of the Genesis Featured Posts widget. It is displayed on the front page. If you are trying to use Jetpack Featured Content, please empty out this widget area first, as this takes precedence.', 'milan' ),
	'before_widget' => '<div id="%1$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<span class="screen-reader-text">',
	'after_title'   => '</span>',
) );

//* Register Social Footer widget area
register_sidebar( array(
	'name'          => __( 'Social Footer', 'milan' ),
	'id'            => 'social-footer',
	'description'   => __( 'This widget area is intended to house a single instance the Simple Social Icons widget. It is displayed in the footer sitewide.', 'milan' ),
	'before_widget' => '<div id="%1$s" class="%2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<span class="screen-reader-text">',
	'after_title'   => '</span>',
) );
