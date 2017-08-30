<?php
/**
 * Studio Pro.
 *
 * This file adds customizer settings to the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Add theme customizer colors here.
$studio_colors = array(
	'button' 		 => '#2A2B33',
	'gradient_left'  => '#7A28FF',
	'gradient_right' => '#00A1FF',
);

/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @access public
 * @param  object $wp_customize Global customizer object.
 * @return void
 */
function studio_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize, $studio_colors;

	/**
	 * RGBA Color Picker Customizer Control
	 *
	 * This control adds a second slider for opacity to the stock
	 * WordPress color picker, and it includes logic to seamlessly
	 * convert between RGBa and Hex color values as opacity is
	 * added to or removed from a color.
	 */
	class RGBA_Customize_Control extends WP_Customize_Control {

		/**
		 * Official control name.
		 *
		 * @var string $type Control name.
		 */
		public $type = 'alpha-color';

		/**
		 * Add support for palettes to be passed in.
		 *
		 * Supported palette values are true, false,
		 * or an array of RGBa and Hex colors.
		 *
		 * @var array $palette Color palettes.
		 */
		public $palette;

		/**
		 * Add support for showing the opacity value on the slider handle.
		 *
		 * @var bool $show_opacity Show opacity.
		 */
		public $show_opacity;

		/**
		 * Enqueue scripts and styles.
		 *
		 * Ideally these would get registered and given proper paths
		 * before this control object gets initialized, then we could
		 * simply enqueue them here, but for completeness as a stand
		 * alone class we'll register and enqueue them here.
		 */
		public function enqueue() {
			wp_enqueue_script(
				'rgba-color-picker',
				get_stylesheet_directory_uri() . '/assets/scripts/min/customize.min.js',
				array( 'jquery', 'wp-color-picker' ),
				'1.0.0',
				true
			);
			wp_enqueue_style(
				'rgba-color-picker',
				get_stylesheet_directory_uri() . '/assets/styles/min/customize.min.css',
				array( 'wp-color-picker' ),
				'1.0.0'
			);
		}

		/**
		 * Render the control.
		 */
		public function render_content() {

			// Process the palette.
			if ( is_array( $this->palette ) ) {
				$palette = implode( '|', $this->palette );
			} else {
				// Default to true.
				$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
			}

			// Support passing show_opacity as string or boolean. Default to true.
			$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

			// Begin the output. ?>
			<label>
				<?php // Output the label and description if they were passed in.
				if ( isset( $this->label ) && '' !== $this->label ) {
					echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
				}
				if ( isset( $this->description ) && '' !== $this->description ) {
					echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
				} ?>
				<input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
			</label>
			<?php
		}
	}

	/**
	 * Custom colors.
	 *
	 * Loop through the global variable array of colors and
	 * register a customizer setting and control for each.
	 * To add additional color settings, do not modify this
	 * function, instead add your color name and hex value to
	 * the $studio_colors` array at the start of this file.
	 */
	foreach ( $studio_colors as $id => $rgba ) {

		// Format ID and label.
		$setting = "studio_{$id}_color";
		$label	 = ucwords( str_replace( '_', ' ', $id ) ) . __( ' Color', 'studio-pro' );

		// Add color setting.
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $rgba,
				'sanitize_callback' => 'sanitize_rgba_color',

			)
		);

		// Add color control.
		$wp_customize->add_control(
			new RGBA_Customize_Control(
				$wp_customize,
				$setting,
				array(
					'section'      => 'colors',
					'label'        => $label,
					'settings'     => $setting,
					'show_opacity' => true,
					'palette'	   => array(
						'#000000',
						'#ffffff',
						'#dd3333',
						'#dd9933',
						'#eeee22',
						'#81d742',
						'#1e73be',
						'#8224e3',
					)
				)
			)
		);
	}
}
add_action( 'customize_register', 'studio_customize_register' );

/**
 * Preview customizer colors.
 *
 * This function enables postMessage support for the customizer
 * colors. First it outputs two divs containing the existing theme
 * mod values which can then be accessed by the customizer JS.
 * Then we output empty style blocks which are modified by the
 * postMessage functions when the custom colors are changed.
 */
function studio_gradient_customizer_styles() {

	// Add in Customizer Only (style tag placeholder for gradient color).
	global $wp_customize, $studio_colors;

	if ( isset( $wp_customize ) ) {
		echo '<div id="studio_gradient_left" data-color="' . esc_attr( get_theme_mod( 'studio_gradient_left_color', $studio_colors['gradient_left'] ) ) . '"></div>';
		echo '<div id="studio_gradient_right" data-color="' . esc_attr( get_theme_mod( 'studio_gradient_right_color', $studio_colors['gradient_right'] ) ) . '"></div>';
	    echo '<style type="text/css" id="button-css"></style>';
		echo '<style type="text/css" id="gradient-css"></style>';
	}
}
add_action( 'wp_head', 'studio_gradient_customizer_styles' );

/**
 * Customizer inline CSS.
 *
 * This function adds some styles to the WordPress Customizer to
 * hide the first paragraph of the Widgets panel notice. Because
 * of the dynamic widget areas, it displays an incorrect number
 * of available widget areas. The simplest way to fix this is to
 * just hide the number, it's not needed anyway.
 */
function my_customizer_styles() {
	$css = '
		.no-widget-areas-rendered-notice p:nth-of-type(1) {
			display: none !important;
		}
		.no-widget-areas-rendered-notice p:nth-of-type(2) {
			margin-top: 0 !important;
		}
	';
	printf( '<style>%s</style>', studio_minify_css( $css ) );
}
add_action( 'customize_controls_print_styles', 'my_customizer_styles', 999 );

/**
 * Customizer JavaScript file.
 *
 * Loads the custom scripts used to add the postMessage functions
 * to WordPress core customizer settings and also the color settings
 * defined by the theme. Without this, live preview will not work.
 *
 * @access public
 * @return void
 */
function studio_enqueue_customizer_scripts() {
	wp_enqueue_script( 'studio-customize', get_stylesheet_directory_uri() . '/assets/scripts/min/customize.min.js', array( 'jquery' ), null, true );
}
add_action( 'customize_preview_init', 'studio_enqueue_customizer_scripts' );
