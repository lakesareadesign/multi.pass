<?php
/**
 * Register Customizer settings.
 *
 * @package   FoodiePro\Functions\Customizer
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     3.0.0
 */

defined( 'WPINC' ) || die;

add_action( 'customize_register', 'foodie_pro_register_customizer_archives' );
/**
 * Register custom sections for the Foodie Pro theme.
 *
 * @since  3.1.0
 * @return void
 */
function foodie_pro_register_customizer_archives() {
	$options = array();

	$section = 'genesis_archives';

	$options['foodie_pro_archive_grid'] = array(
		'id'      => 'foodie_pro_archive_grid',
		'label'   => __( 'Archive Grid Display:', 'foodiepro' ),
		'section' => $section,
		'type'    => 'select',
		'default' => 'full',
		'priority' => 0,
		'choices' => array(
			'full'       => __( 'Full Width', 'foodiepro' ),
			'one_half'   => __( 'One Half', 'foodiepro' ),
			'one_third'  => __( 'One Third', 'foodiepro' ),
			'one_fourth' => __( 'One Fourth', 'foodiepro' ),
			'one_sixth'  => __( 'One Sixth', 'foodiepro' ),
		),
	);

	$options['foodie_pro_archive_show_title'] = array(
		'id'       => 'foodie_pro_archive_show_title',
		'label'    => __( 'Display The Title?', 'foodiepro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 5,
	);

	$options['foodie_pro_archive_show_info'] = array(
		'id'       => 'foodie_pro_archive_show_info',
		'label'    => __( 'Display The Entry Info?', 'foodiepro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 6,
	);

	$options['foodie_pro_archive_show_content'] = array(
		'id'       => 'foodie_pro_archive_show_content',
		'label'    => __( 'Display The Content?', 'foodiepro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 7,
	);

	$options['foodie_pro_archive_show_meta'] = array(
		'id'       => 'foodie_pro_archive_show_meta',
		'label'    => __( 'Display The Entry Meta?', 'foodiepro' ),
		'section'  => $section,
		'type'     => 'checkbox',
		'default'  => 1,
		'priority' => 8,
	);

	$options['foodie_pro_archive_image_placement'] = array(
		'id'      => 'foodie_pro_archive_image_placement',
		'label'   => __( 'Featured Image Placement:', 'foodiepro' ),
		'section' => $section,
		'type'    => 'select',
		'default' => 'after_title',
		'choices' => array(
			'after_title'   => __( 'After Title', 'foodiepro' ),
			'before_title'  => __( 'Before Title', 'foodiepro' ),
			'after_content' => __( 'After Content', 'foodiepro' ),
		),
	);

	Feastco_Customizer_Options::add_options( $options );
}

add_action( 'customize_register', 'foodie_pro_register_customizer_colors' );
/**
 * Register custom color sections for the Foodie Pro theme.
 *
 * @since  3.1.0
 * @param  object $api The customizer API object.
 * @return void
 */
function foodie_pro_register_customizer_colors( $api ) {
	$api->remove_section( 'colors' );

	if ( apply_filters( 'foodie_pro_disable_colors', false ) ) {
		return;
	}

	$options = array(
		'sections' => array(),
	);

	$panel = 'colors';

	$api->add_panel(
		$panel,
		array(
			'title'       => __( 'Colors', 'foodiepro' ),
			'description' => __( 'You can customize your theme colors by changing any of the options within this panel.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'priority'    => 70,
		)
	);

	$api->add_section(
		"{$panel}_general",
		array(
			'title'       => __( 'General', 'foodiepro' ),
			'description' => __( 'Customize your general theme colors by changing the options below.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 10,
		)
	);

	$api->add_section(
		"{$panel}_menus",
		array(
			'title'       => __( 'Menus', 'foodiepro' ),
			'description' => __( 'Customize your menu colors by changing the options below.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 12,
		)
	);

	$api->add_section(
		"{$panel}_content",
		array(
			'title'       => __( 'Content', 'foodiepro' ),
			'description' => __( 'Customize your content colors by changing the options below.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 14,
		)
	);

	$api->add_section(
		"{$panel}_buttons",
		array(
			'title'       => __( 'Buttons', 'foodiepro' ),
			'description' => __( 'Customize your button colors by changing the options below.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'panel'       => $panel,
			'priority'    => 16,
		)
	);

	$counter = 20;

	foreach ( foodie_pro_get_colors() as $color => $setting ) {

		$options[ $color ] = array(
			'id'       => $color,
			'label'    => $setting['label'],
			'section'  => "{$panel}_{$setting['section']}",
			'type'     => 'color',
			'default'  => $setting['default'],
			'priority' => $counter++,
		);
	}

	Feastco_Customizer_Options::add_options( $options );
}

add_action( 'customize_register', 'foodie_pro_register_customizer_fonts' );
/**
 * Register custom sections for the Foodie Pro theme.
 *
 * @since  3.1.0
 * @return void
 */
function foodie_pro_register_customizer_fonts( $api ) {
	if ( apply_filters( 'foodie_pro_disable_google_fonts', false ) ) {
		return;
	}

	$panel = 'fonts';

	$api->add_panel(
		$panel,
		array(
			'title'       => __( 'Typography', 'foodiepro' ),
			'description' => __( 'You can customize your fonts here. For best results, we recommend using no more than two unique font families.', 'foodiepro' ),
			'capability'  => 'edit_theme_options',
			'priority'    => 75,
		)
	);

	foreach ( foodie_pro_get_fonts() as $font => $setting ) {
		$api->add_section(
			"{$panel}_{$font}",
			array(
				'title'       => $setting['label'],
				'description' => $setting['description'],
				'capability'  => 'edit_theme_options',
				'panel'       => $panel,
				'priority'    => 10,
			)
		);

		$options[ "{$font}_family" ] = array(
			'id'      => "{$font}_family",
			'label'   => $setting['label'] . ' ' . __( 'Family', 'foodiepro' ),
			'section' => "{$panel}_{$font}",
			'type'    => 'select',
			'choices' => feastco_customizer_get_font_choices(),
			'default' => $setting['default_family'],
		);

		$options[ "{$font}_weight" ] = array(
			'id'      => "{$font}_weight",
			'label'   => $setting['label'] . ' ' . __( 'Weight', 'foodiepro' ),
			'section' => "{$panel}_{$font}",
			'type'    => 'select',
			'default' => $setting['default_weight'],
			'choices' => array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'600' => '600',
				'700' => '700',
				'900' => '900',
			),
		);

		if ( 'disabled' !== $setting['default_size'] ) {
			$options[ "{$font}_size" ] = array(
				'id'      => "{$font}_size",
				'label'   => $setting['label'] . ' ' .  __( 'Size', 'foodiepro' ),
				'section' => "{$panel}_{$font}",
				'type'    => 'select',
				'default' => $setting['default_size'],
				'choices' => array(
					'13px' => '13px',
					'15px' => '15px',
					'19px' => '19px',
					'21px' => '21px',
					'27px' => '27px',
					'37px' => '37px',
					'47px' => '47px',
					'57px' => '57px',
				),
			);
		}

		if ( 'disabled' !== $setting['default_style'] ) {
			$options[ "{$font}_style" ] = array(
				'id'      => "{$font}_style",
				'label'   => $setting['label'] . ' ' . __( 'Style', 'foodiepro' ),
				'section' => "{$panel}_{$font}",
				'type'    => 'select',
				'default' => $setting['default_style'],
				'choices' => array(
					'normal' => 'Normal',
					'italic' => 'Italic',
				),
			);
		}
	}

	Feastco_Customizer_Options::add_options( $options );
}
