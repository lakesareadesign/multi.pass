<?php
/**
 * BloomBlogShop
 *
 * @package      BloomBlogShop
 * @since        1.0.0
 * @copyright    Copyright (c) 2015
 * @license      GPL-2.0+
 */

function jt_customizer_setup($wp_customize) {


    /**
     * Header
     *
     */

    $colors[] = array(
        'slug'      => 'jt_header_background',
        'default'   => '#ffffff',
        'label'     => 'Header Background'
    );

    $colors[] = array(
        'slug'      => 'jt_site_title',
        'default'   => '#333333',
        'label'     => 'Site Title'
    );

    $colors[] = array(
        'slug'      => 'jt_nav',
        'default'   => '#999999',
        'label'     => 'Header Navigation'
    );

    $colors[] = array(
        'slug'      => 'jt_nav_hover',
        'default'   => '#333333',
        'label'     => 'Header Navigation Hover'
    );

    /**
     * Links
     *
     */

   $colors[] = array(
        'slug'      => 'jt_link',
        'default'   => '#999999',
        'label'     => 'Link'
    );

    $colors[] = array(
        'slug'      => 'jt_link_hover',
        'default'   => '#333333',
        'label'     => 'Link Hover'
    );

    $colors[] = array(
        'slug'      => 'jt_link_visited',
        'default'   => '#333333',
        'label'     => 'Visited Link'
    );


    /**
     * Buttons
     *
     */

    $colors[] = array(
        'slug'      => 'jt_button_text',
        'default'   => '#333333',
        'label'     => 'Button Text'
    );

    $colors[] = array(
        'slug'      => 'jt_button_background',
        'default'   => '#ffffff',
        'label'     => 'Button Background'
    );

    $colors[] = array(
        'slug'      => 'jt_button_border',
        'default'   => '#333333',
        'label'     => 'Button Border'
    );

    $colors[] = array(
        'slug'      => 'jt_button_hover',
        'default'   => '#333333',
        'label'     => 'Button Hover'
    );


    /**
     * Footer
     *
     */

    $colors[] = array(
        'slug'      => 'jt_footer_background',
        'default'   => '#ffffff',
        'label'     => 'Footer Background'
    );

    $colors[] = array(
        'slug'      => 'jt_footer_text',
        'default'   => '#333333',
        'label'     => 'Footer Text'
    );

    foreach( $colors as $color ) {

        // SETTINGS
        $wp_customize->add_setting(
            $color['slug'], array(
                'default' => $color['default'],
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );

        // CONTROLS
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                $color['slug'],
                array(
                    'label' => $color['label'],
                    'section' => 'colors',
                    'settings' => $color['slug']
                )
            )
        );
    }

}

add_action('customize_register', 'jt_customizer_setup');


function jt_customizer_css() {

    $headerBackground = get_theme_mod('jt_header_background');
    $siteTitle = get_theme_mod('jt_site_title');
    $headerNav = get_theme_mod('jt_nav');
    $headerNavHover = get_theme_mod('jt_nav_hover');

    $link = get_theme_mod('jt_link');
    $linkHover = get_theme_mod('jt_link_hover');
    $linkVisited = get_theme_mod('jt_link_visited');

    $buttonText = get_theme_mod('jt_button_text');
    $buttonBackground = get_theme_mod('jt_button_background');
    $buttonBorder = get_theme_mod('jt_button_border');
    $buttonHover = get_theme_mod('jt_button_hover');

    $footerBackground = get_theme_mod('jt_footer_background');
    $footerText = get_theme_mod('jt_footer_text');


?><style type="text/css">

a,
.genesis-nav-menu > li a,
.genesis-nav-menu .current-menu-item > a,
.genesis-nav-menu .sub-menu > li a,
.archive-pagination li a {
    color: <?php echo $link; ?>;
}

a:hover,
.genesis-nav-menu > li a:hover,
.genesis-nav-menu .current-menu-item > a:hover,
.genesis-nav-menu .sub-menu > li a:hover,
.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
.archive-pagination li a:hover {
    color: <?php echo $linkHover; ?>;
}

a:visited {
    color: <?php echo $linkVisited; ?>;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.button {
    background: <?php echo $buttonBackground; ?>;
    color: <?php echo $buttonText; ?>;
    border-color: <?php echo $buttonBorder; ?>;
}

button:hover,
input:hover[type="button"],
input:hover[type="reset"],
input:hover[type="submit"],
.button:hover {
    background: <?php echo $buttonHover; ?>;
    border-color: <?php echo $buttonHover; ?>;
}

.styledSelect:active,
.styledSelect.active,
input:focus,
textarea:focus {
    border-color: <?php echo $link; ?>;
}

.site-header {
    background: <?php echo $headerBackground; ?>;
}

.site-header .site-title a {
    color: <?php echo $siteTitle; ?>;
}

.site-header .genesis-nav-menu > li > a,
.icon-responsive-nav {
    color: <?php echo $headerNav; ?>;
}

.genesis-nav-menu > li a:hover,
.genesis-nav-menu .current-menu-item > a:hover,
.genesis-nav-menu .sub-menu > li a:hover,
.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
.archive-pagination li a:hover {
    color: <?php echo $headerNavHover; ?>;
}

.site-footer,
.footer-widgets {
    background: <?php echo $footerBackground; ?>;
    color: <?php echo $footerText; ?>;
}

</style>
<?php
}
add_action( 'wp_head', 'jt_customizer_css' );
