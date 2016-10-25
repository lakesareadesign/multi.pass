<?php
/**
 * Customizer additions.
 *
 * @package Whitespace Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/whitespace/
 * @license GPL2-0+
 */
 
/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function whitespace_customizer_get_default_accent_color() {
	return '#00a99d';
}

/**
 * Get default highlight color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for highlight color.
 */
function whitespace_customizer_get_default_highlight_color() {
	return '#00baad';
}
 
add_action( 'customize_register', 'whitespace_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function whitespace_customizer_register() {

	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class Child_Whitespace_Image_Control extends WP_Customize_Image_Control {

		/**
		 * Constructor.
		 *
		 * If $args['settings'] is not defined, use the $id as the setting ID.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Upload_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct( $manager, $id, $args ) {
			$this->statuses = array( '' => __( 'No Image', 'whitespace' ) );

			parent::__construct( $manager, $id, $args );

			$this->add_tab( 'upload-new', __( 'Upload New', 'whitespace' ), array( $this, 'tab_upload_new' ) );
			$this->add_tab( 'uploaded',   __( 'Uploaded', 'whitespace' ), array( $this, 'tab_uploaded' ) );
			
			if ( $this->setting->default )
				$this->add_tab( 'default',  __( 'Default', 'whitespace' ), array( $this, 'tab_default_background' ) );

			// Early priority to occur before $this->manager->prepare_controls();
			add_action( 'customize_controls_init', array( $this, 'prepare_control' ), 5 );
		}

		/**
		 * @since 3.4.0
		 * @uses WP_Customize_Image_Control::print_tab_image()
		 */
		public function tab_default_background() {
			$this->print_tab_image( $this->setting->default );
		}
		
	}

	global $wp_customize;

	$wp_customize->add_section( 'whitespace-image', array(
		'title'    => __( 'Homepage Image', 'whitespace' ),
		'description'    => __( '<p>Use the included default image or personalize your site by uploading your own image for the homepage widget background.</p><p>The default image is <strong>1200 x 400 pixels</strong>.</p>', 'whitespace' ),
		'priority' => 75,
	) );

	$wp_customize->add_setting( 'whitespace-home-image', array(
		'default'  => sprintf( '%s/images/welcome.jpg', get_stylesheet_directory_uri() ),
		'type'     => 'option',
	) );
	 
	$wp_customize->add_control(
		new Child_Whitespace_Image_Control(
			$wp_customize,
			'home-background-image',
			array(
				'label'       => __( 'Home Image Upload', 'whitespace' ),
				'section'     => 'whitespace-image',
				'settings'    => 'whitespace-home-image',
			)
		)
	);
	
	$wp_customize->add_setting(
		'whitespace_accent_color',
		array(
			'default' => whitespace_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'whitespace_accent_color',
			array(
			    'label'    => __( 'Accent Color', 'whitespace' ),
			    'section'  => 'colors',
			    'settings' => 'whitespace_accent_color',
			)
		)
	);
	
	$wp_customize->add_setting(
		'whitespace_highlight_color',
		array(
			'default' => whitespace_customizer_get_default_highlight_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'whitespace_highlight_color',
			array(
			    'label'    => __( 'Highlight Color', 'whitespace' ),
			    'section'  => 'colors',
			    'settings' => 'whitespace_highlight_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'whitespace_css' );
/**
* Checks the settings for the accent color, highlight color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function whitespace_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'whitespace_accent_color', whitespace_customizer_get_default_accent_color() );
	$color_highlight = get_theme_mod( 'whitespace_highlight_color', whitespace_customizer_get_default_highlight_color() );
	$height = get_custom_header()->height;

	$css = '';
	
	$css .= ( get_header_image() != '' ) ? sprintf( '
		.header-image .title-area,
		.header-image .site-title > a {
			min-height: %spx;
		}
		', $height ) : '';

	$css .= ( whitespace_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		a,
		.entry-title a:hover,
		.entry-header .entry-meta,
		.site-footer a:hover {
			color: %1$s;
		}

		a.button,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.after-entry .enews,
		.archive-pagination.pagination a,
		.enews-widget input[type="submit"],
		.nav-secondary,
		.site-header {
			background-color: %1$s;
		}
		', $color ) : '';
		
	$css .= ( whitespace_customizer_get_default_highlight_color() !== $color_highlight ) ? sprintf( '
		a.button:hover,
		button:hover,
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.after-entry .enews-widget input:hover[type="submit"],
		.archive-pagination.pagination a:hover {
			background-color: %1$s;
		}

		.nav-secondary {
			border-color: %1$s;
		}
		', $color_highlight ) : '';
		
	if ( whitespace_customizer_get_default_accent_color() !== $color || whitespace_customizer_get_default_highlight_color() !== $color_highlight ) {
		$css .= '
		@media only screen and (min-width: 800px) {
		';
	}
		
	$css .= ( whitespace_customizer_get_default_accent_color() !== $color ) ? sprintf( '
			.archive .content .entry:hover,
			.genesis-nav-menu .sub-menu,
			.genesis-nav-menu .sub-menu .sub-menu {
				background-color: %1$s;
			}
		', $color ) : '';
		
	$css .= ( whitespace_customizer_get_default_highlight_color() !== $color_highlight ) ? sprintf( '
			.genesis-nav-menu .sub-menu,
			.genesis-nav-menu .sub-menu .sub-menu,
			.genesis-nav-menu .sub-menu a {
				border-color: %1$s;
			}
		', $color_highlight ) : '';
		
	if ( whitespace_customizer_get_default_accent_color() !== $color || whitespace_customizer_get_default_highlight_color() !== $color_highlight ) {
		$css .= '
		}
		';
	}

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
