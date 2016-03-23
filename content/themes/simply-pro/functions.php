<?php
/**
 * BloomBlogShop
 *
 * @package      BloomBlogShop
 * @since        1.0.0
 * @copyright    Copyright (c) 2015
 * @license      GPL-2.0+
 */

/**
 * Set up the content width value based on the theme's design.
 *
 */
if ( ! isset( $content_width ) )
    $content_width = 740;

/**
 * Theme setup
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */

function jt_child_theme_setup() {

    // Child Theme
    define( 'CHILD_THEME_NAME', 'Simply Pro Theme' );
    define( 'CHILD_THEME_VERSION', '1.0.0' );
    define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/simply/' );

    // Load Genesis
    require_once( get_template_directory() . '/lib/init.php' );

    // Genesis & Sensei Specific Changes
    include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );

    // Adds customizer support
    include_once( get_stylesheet_directory() . '/inc/customizer.php' );

    // Editor Styles
    add_editor_style( 'css/editor-style.css' );

    // Global enqueues
    add_action( 'wp_enqueue_scripts', 'jt_global_enqueues' );

    // Header
    add_theme_support( 'custom-header', array(
        'header-selector' => '.site-title',
        'height'          => 120,
        'width'           => 320,
        'header-text'     => false
    ) );

    // Register Widgets
    add_action( 'widgets_init', 'jt_register_widget_areas' );

    // Add Home Widgets
    add_action( 'genesis_before_content', 'jt_home_widgets', 5 );

    // Footer
    add_filter('genesis_footer_creds_text', 'jt_footer_creds_filter');
}
add_action( 'genesis_setup', 'jt_child_theme_setup', 15 );

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function jt_global_enqueues() {

    // javascript
    wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
    wp_enqueue_script( 'jt-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'fitvids' ), '1.0', true );
    wp_enqueue_script( 'headhesive', get_stylesheet_directory_uri() . '/js/headhesive.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'jt-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0', true );

    // css
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'fonts', 'http://fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic' );
}

/**
 * Register Widget Areas
 *
 */

function jt_register_widget_areas() {

    genesis_register_sidebar( array(
        'id'            => 'featured',
        'name'          => 'Featured',
        'description'   => 'This is the featured section on the home page.'
    ));
}

function jt_home_widgets() {
    if ( is_home() && is_front_page() ) {
        if ( is_active_sidebar( 'featured' ) ) {
            genesis_widget_area ( 'featured', array(
                'before' => '<div class="featured-widget">',
                'after'  => '</div>',
            ));
        }
    }
}

/**
 * Customize Footer
 *
 */
function jt_footer_creds_filter( $creds ) {
    $creds = '[footer_copyright before="Copyright "] &middot; [footer_childtheme_link before=""] by <a href="http://bloomblogshop.com/">Bloom Blog Shop</a>.';
    return $creds;
}
