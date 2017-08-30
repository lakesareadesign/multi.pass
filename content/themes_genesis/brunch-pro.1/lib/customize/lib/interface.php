<?php
/**
 * Builds out customizer options
 *
 * @package FeastcoCustomizer
 */

defined( 'WPINC' ) || die;

add_action( 'customize_register', 'feastco_customizer_register', 20 );
/**
 * Configure settings and controls for the theme customizer
 *
 * @since  1.0.0.
 *
 * @param  object $wp_customize The global customizer object.
 *
 * @return void
 */
function feastco_customizer_register( $wp_customize ) {
	do_action( 'feastco_customizer_register', $wp_customize );

	if ( ! $options = Feastco_Customizer_Options::get_options() ) {
		return;
	}

	if ( isset( $options['sections'] ) ) {
		feastco_customizer_add_sections( $options['sections'], $wp_customize );
	}

	if ( isset( $options['panels'] ) ) {
		feastco_customizer_add_panels( $options['panels'], $wp_customize );
	}

	$loop = 0;

	foreach ( $options as $option ) {
		if ( ! isset( $option['type'] ) ) {
			continue;
		}

		$loop ++;

		if ( ! isset( $option['description'] ) ) {
			$option['description'] = '';
		}

		if ( ! isset( $option['sanitize_callback'] ) ) {
			$option['sanitize_callback'] = feastco_customizer_get_sanitization( $option['type'] );
		}

		if ( ! isset( $option['active_callback'] ) ) {
			$option['active_callback'] = '';
		}

		if ( ! isset( $option['priority'] ) ) {
			$option['priority'] = $loop;
		}

		feastco_customizer_add_setting( $option, $wp_customize );
		feastco_customizer_add_control( $option, $wp_customize );
	}
}

/**
 * Add the customizer sections
 *
 * @since  1.2.0.
 * @param  array  $sections The current sections to be added.
 * @param  object $wp_customize The WordPress cusotmizer object.
 * @return void
 */
function feastco_customizer_add_sections( $sections, $wp_customize ) {
	foreach ( $sections as $section ) {

		if ( ! isset( $section['description'] ) ) {
			$section['description'] = false;
		}

		$wp_customize->add_section( $section['id'], $section );
	}
}

/**
 * Add the customizer panels
 *
 * @since  1.2.0.
 * @param  array  $panels The current panels to be added.
 * @param  object $wp_customize The WordPress cusotmizer object.
 * @return void
 */
function feastco_customizer_add_panels( $panels, $wp_customize ) {
	foreach ( $panels as $panel ) {

		if ( ! isset( $panel['description'] ) ) {
			$panel['description'] = false;
		}

		$wp_customize->add_panel( $panel['id'], $panel );
	}
}

/**
 * Add the setting and proper sanitization
 *
 * @since  1.2.0.
 * @param  array  $option The current option.
 * @param  object $wp_customize The WordPress cusotmizer object.
 * @return void
 */
function feastco_customizer_add_setting( $option, $wp_customize ) {
	$settings_default = array(
		'default'              => null,
		'option_type'          => 'theme_mod',
		'capability'           => 'edit_theme_options',
		'theme_supports'       => null,
		'transport'            => null,
		'sanitize_callback'    => 'wp_kses_post',
		'sanitize_js_callback' => null,
	);

	$settings = array_merge( $settings_default, $option );

	$wp_customize->add_setting( $option['id'], array(
			'default'              => $settings['default'],
			'type'                 => $settings['option_type'],
			'capability'           => $settings['capability'],
			'theme_supports'       => $settings['theme_supports'],
			'transport'            => $settings['transport'],
			'sanitize_callback'    => $settings['sanitize_callback'],
			'sanitize_js_callback' => $settings['sanitize_js_callback'],
		)
	);
}

/**
 * Add the control and proper sanitization
 *
 * @since  1.2.0.
 * @param  array  $option The current option.
 * @param  object $wp_customize The WordPress cusotmizer object.
 * @return void
 */
function feastco_customizer_add_control( $option, $wp_customize ) {
	switch ( $option['type'] ) {
		case 'text':
		case 'url':
		case 'select':
		case 'radio':
		case 'checkbox':
		case 'range':
		case 'dropdown-pages':
			$wp_customize->add_control(
				$option['id'], $option
			);
		break;

		case 'color':
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, $option['id'], $option
				)
			);
		break;

		case 'image':
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$option['id'], array(
						'label'             => $option['label'],
						'section'           => $option['section'],
						'sanitize_callback' => $option['sanitize_callback'],
						'priority'          => $option['priority'],
						'active_callback'   => $option['active_callback'],
						'description'       => $option['description'],
					)
				)
			);
		break;

		case 'upload':
			$wp_customize->add_control(
				new WP_Customize_Upload_Control(
					$wp_customize,
					$option['id'], array(
						'label'             => $option['label'],
						'section'           => $option['section'],
						'sanitize_callback' => $option['sanitize_callback'],
						'priority'          => $option['priority'],
						'active_callback'   => $option['active_callback'],
						'description'       => $option['description'],
					)
				)
			);
		break;

		case 'textarea':
			$wp_customize->add_control( 'setting_id', array(
				$wp_customize->add_control(
					$option['id'], $option
				)
			) );
		break;
	}
}
