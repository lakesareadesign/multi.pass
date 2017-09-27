<?php
/**
 * This file adds customizer settings to the Business Pro theme.
 *
 * @package      Genesis Startup
 * @link         https://seothemes.com/themes/genesis-startup
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Add theme customizer colors here.
$business_colors = array(
	'primary'   => '#fb2056',
	'secondary' => 'rgba(20,30,40,0.7)',
);

add_action( 'customize_register', 'business_customize_register' );
/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 *
 * @param  object $wp_customize Global customizer object.
 * @return void
 */
function business_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize, $business_colors;

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
				<?php
				if ( isset( $this->label ) && '' !== $this->label ) {
					echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
				}
				if ( isset( $this->description ) && '' !== $this->description ) {
					echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
				}
				?>
				<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_html( $show_opacity ); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
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
	 * the $business_colors` array at the start of this file.
	 */
	foreach ( $business_colors as $id => $rgba ) {

		// Format ID and label.
		$setting = "business_{$id}_color";
		$label   = ucwords( str_replace( '_', ' ', $id ) ) . __( ' Color', 'business-pro' );

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
					'palette'      => array(
						'#000000',
						'#ffffff',
						'#dd3333',
						'#dd9933',
						'#eeee22',
						'#81d742',
						'#1e73be',
						'#8224e3',
					),
				)
			)
		);
	}
}

add_action( 'wp_enqueue_scripts', 'business_customizer_output', 100 );
/**
 * Output customizer styles.
 *
 * Checks the settings for the colors defined in the settings.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since  1.0.0
 *
 * @var    array $business_colors Global theme colors.
 * @return void
 */
function business_customizer_output() {

	// Set in customizer-settings.php.
	global $business_colors;

	/**
	 * Loop though each color in the global array of theme colors
	 * and create a new variable for each. This is just a shorthand
	 * way of creating multiple variables that we can reuse. The
	 * benefit of using a foreach loop over creating each variable
	 * manually is that we can just declare the colors once in the
	 * `$business_colors` array, and they can be used in multiple ways.
	 */
	foreach ( $business_colors as $id => $hex ) {
		${"$id"} = get_theme_mod( "business_{$id}_color",  $hex );
	}

	// Ensure $css var is empty.
	$css = '';

	/**
	 * Build the CSS.
	 *
	 * We need to concatenate each one of our colors to the $css
	 * variable, but first check if the color has been changed by
	 * the user from the theme customizer. If the theme mod is not
	 * equal to the default color then the string is appended to $css.
	 */
	$css .= ( $business_colors['primary'] !== $primary ) ? sprintf( '

		button.accent,
		.button.accent,
		button.accent:hover,
		.button.accent:hover,
		button.accent:focus,
		.button.accent:focus,
		.archive-pagination a:hover,
		.archive-pagination a:focus,
		.archive-pagination .active a,
		.woocommerce a.button:hover,
		.woocommerce a.button:focus,
		.woocommerce a.button,
		.woocommerce a.button.alt:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce a.button.alt,
		.woocommerce button.button:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce button.button.alt,
		.woocommerce input.button:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button,
		.woocommerce input.button.alt:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input.button.alt,
		.woocommerce input[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce input[type="submit"],
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt,
		.woocommerce input.button[type=submit]:focus,
		.woocommerce input.button[type=submit],
		.woocommerce input.button[type=submit]:hover,
		.woocommerce.widget_price_filter .ui-slidui-slider-handle,
		.woocommerce.widget_price_filter .ui-slidui-slider-range,
		.pricing-table .featured .button,
		.pricing-table .featured button,
		.archive-pagination a:hover,
		.archive-pagination .active a,
		.front-page-3 .widget_custom_html:first-of-type hr,
		.front-page-5 .widget_custom_html:first-of-type hr {
			background-color: %1$s;
		}

		.front-page-2 .fa {
			color: %1$s;
		}

		', $primary ) : '';

	$css .= ( $business_colors['secondary'] !== $secondary ) ? sprintf( '

		.page-header:before,
		.front-page-4:before,
		.before-footer:before {
			background-color: %1$s;
		}

		', $secondary ) : '';

	// Style handle is the name of the theme.
	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	// Output CSS if not empty.
	if ( ! empty( $css ) ) {

		// Add the inline styles, also minify CSS first.
		wp_add_inline_style( $handle, business_minify_css( $css ) );
	}
}
