<?php

/* General Panel */
FLCustomizer::add_panel('fl-general', array(
	'title'    => _x( 'General', 'Customizer panel title.', 'fl-automator' ),
	'sections' => array(

		/* Layout Section */
		'fl-layout' => array(
			'title'   => _x( 'Layout', 'Customizer section title.', 'fl-automator' ),
			'options' => array(

				/* Layout Width */
				'fl-layout-width' => array(
					'setting'   => array(
						'default'   => 'full-width'
					),
					'control'   => array(
						'class'         => 'WP_Customize_Control',
						'label'         => __('Width', 'fl-automator'),
						'type'          => 'select',
						'choices'       => array(
							'boxed'             => __('Boxed', 'fl-automator'),
							'full-width'        => __('Full Width', 'fl-automator')
						)
					)
				),

				/* Content Width */
				'fl-content-width' => array(
					'setting'   => array(
						'default'           => '1020'
					),
					'control'   => array(
						'class'         => 'FLCustomizerControl',
						'label'         => __('Content Width', 'fl-automator'),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 960,
						    'max'  => 1920,
						    'step' => 1
						),
					)
				),

				/* Spacing */
				'fl-layout-spacing' => array(
					'setting'   => array(
						'default'           => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Spacing', 'fl-automator'),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 0,
						    'max'  => 150,
						    'step' => 1
						),
					)
				),

				/* Drop Shadow Size */
				'fl-layout-shadow-size' => array(
					'setting'   => array(
						'default'   => '0'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Drop Shadow Size', 'fl-automator'),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 0,
						    'max'  => 75,
						    'step' => 1
						),
					)
				),

				/* Drop Shadow Color */
				'fl-layout-shadow-color' => array(
					'setting'   => array(
						'default'   => '#d9d9d9'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Drop Shadow Color', 'fl-automator')
					)
				),

				/* Scroll To Top Button */
				'fl-scroll-to-top' => array(
					'setting'   => array(
						'default'   => 'disable'
					),
					'control'   => array(
						'class'         => 'WP_Customize_Control',
						'label'         => __('Scroll To Top Button', 'fl-automator'),
						'type'          => 'select',
						'choices'       => array(
							'enable'         => __('Enabled', 'fl-automator'),
							'disable'        => __('Disabled', 'fl-automator')
						)
					)
				),
			)
		),

		/* Body Background Section */
		'fl-body-bg' => array(
			'title'   => _x( 'Background', 'Customizer section title.', 'fl-automator' ),
			'options' => array(

				/* Background Color */
				'fl-body-bg-color' => array(
					'setting'   => array(
						'default'   => '#f2f2f2'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Background Color', 'fl-automator')
					)
				),

				/* Background Image */
				'fl-body-bg-image' => array(
					'setting'   => array(
						'default'   => '',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Image_Control',
						'label'     => __('Background Image', 'fl-automator')
					)
				),

				/* Background Repeat */
				'fl-body-bg-repeat' => array(
					'setting'   => array(
						'default'   => 'no-repeat',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Control',
						'label'     => __('Background Repeat', 'fl-automator'),
						'type'      => 'select',
						'choices'   => array(
							'no-repeat'  => __('None', 'fl-automator'),
							'repeat'     => __('Tile', 'fl-automator'),
							'repeat-x'   => __('Horizontal', 'fl-automator'),
							'repeat-y'   => __('Vertical', 'fl-automator')
						)
					)
				),

				/* Background Position */
				'fl-body-bg-position' => array(
					'setting'   => array(
						'default'   => 'center top',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Control',
						'label'     => __('Background Position', 'fl-automator'),
						'type'      => 'select',
						'choices'   => array(
							'left top'      => __( 'Left Top', 'fl-automator' ),
							'left center'   => __( 'Left Center', 'fl-automator' ),
							'left bottom'   => __( 'Left Bottom', 'fl-automator' ),
							'right top'     => __( 'Right Top', 'fl-automator' ),
							'right center'  => __( 'Right Center', 'fl-automator' ),
							'right bottom'  => __( 'Right Bottom', 'fl-automator' ),
							'center top'    => __( 'Center Top', 'fl-automator' ),
							'center center' => __( 'Center', 'fl-automator' ),
							'center bottom' => __( 'Center Bottom', 'fl-automator' )
						)
					)
				),

				/* Background Attachment */
				'fl-body-bg-attachment' => array(
					'setting'   => array(
						'default'   => 'scroll',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Control',
						'label'     => __('Background Attachment', 'fl-automator'),
						'type'      => 'select',
						'choices'   => array(
							'scroll'    => __('Scroll', 'fl-automator'),
							'fixed'     => __('Fixed', 'fl-automator')
						)
					)
				),

				/* Background Size */
				'fl-body-bg-size' => array(
					'setting'   => array(
						'default'   => 'auto',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Control',
						'label'     => __('Background Scale', 'fl-automator'),
						'type'      => 'select',
						'choices'   => array(
							'auto'      => __('None', 'fl-automator'),
							'contain'   => __('Fit', 'fl-automator'),
							'cover'     => __('Fill', 'fl-automator')
						)
					)
				)
			)
		),

		/* Accent Color Section */
		'fl-accent-color' => array(
			'title'   => _x( 'Accent Color', 'Customizer section title.', 'fl-automator' ),
			'options' => array(

				/* Accent Color */
				'fl-accent' => array(
					'setting'   => array(
						'default'   => '#428bca'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Color', 'fl-automator'),
						'description'   => __('The accent color will be used to color elements such as links and buttons as well as various elements in your theme.', 'fl-automator')
					)
				),
				
				/* Accent Hover Color */
				'fl-accent-hover' => array(
					'setting'   => array(
						'default'   => '#428bca'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Hover Color', 'fl-automator')
					)
				)
			)
		),

		/* Heading Font Section */
		'fl-heading-font' => array(
			'title'   => _x( 'Headings', 'Customizer section title.', 'fl-automator' ),
			'options' => array(

				/* Heading Text Color */
				'fl-heading-text-color' => array(
					'setting'   => array(
						'default'   => '#333333',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Color', 'fl-automator')
					)
				),

				/* Heading Font Family */
				'fl-heading-font-family' => array(
					'setting'   => array(
						'default'   => 'Helvetica',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Font Family', 'fl-automator'),
						'type'      => 'font',
						'connect'   => 'fl-heading-font-weight'
					)
				),

				/* Heading Font Weight */
				'fl-heading-font-weight' => array(
					'setting'   => array(
						'default'   => '400'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Font Weight', 'fl-automator'),
						'type'      => 'font-weight',
						'connect'   => 'fl-heading-font-family'
					)
				),

				/* Heading Font Format */
				'fl-heading-font-format' => array(
					'setting'   => array(
						'default'   => 'none',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Control',
						'label'     => __('Font Format', 'fl-automator'),
						'type'      => 'select',
						'choices'   => array(
							'none'       => __('Regular', 'fl-automator'),
							'capitalize' => __('Capitalize', 'fl-automator'),
							'uppercase'  => __('Uppercase', 'fl-automator'),
							'lowercase'  => __('Lowercase', 'fl-automator')
						)
					)
				),

				/* Line */
				'fl-heading-font-line1' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H1 Font Size */
				'fl-h1-font-size' => array(
					'setting'   => array(
						'default'   => '36',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H1' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H1 Line Height */
				'fl-h1-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H1' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H1 Letter Spacing */
				'fl-h1-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H1' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				),

				/* Line */
				'fl-h1-line' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H2 Font Size */
				'fl-h2-font-size' => array(
					'setting'   => array(
						'default'   => '30',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H2' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H2 Line Height */
				'fl-h2-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H2' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H2 Letter Spacing */
				'fl-h2-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H2' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				),

				/* Line */
				'fl-h2-line' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H3 Font Size */
				'fl-h3-font-size' => array(
					'setting'   => array(
						'default'   => '24',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H3' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H3 Line Height */
				'fl-h3-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H3' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H3 Letter Spacing */
				'fl-h3-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H3' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				),

				/* Line */
				'fl-h3-line' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H4 Font Size */
				'fl-h4-font-size' => array(
					'setting'   => array(
						'default'   => '18',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H4' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H4 Line Height */
				'fl-h4-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H4' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H4 Letter Spacing */
				'fl-h4-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H4' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				),

				/* Line */
				'fl-h4-line' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H5 Font Size */
				'fl-h5-font-size' => array(
					'setting'   => array(
						'default'   => '14',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H5' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H5 Line Height */
				'fl-h5-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H5' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H5 Letter Spacing */
				'fl-h5-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H5' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				),

				/* Line */
				'fl-h5-line' => array(
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'type'      => 'line'
					)
				),

				/* H6 Font Size */
				'fl-h6-font-size' => array(
					'setting'   => array(
						'default'   => '12',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Font Size', '%s stands for HTML heading tag.', 'fl-automator' ), 'H6' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* H6 Line Height */
				'fl-h6-line-height' => array(
					'setting'   => array(
						'default'   => '1.4',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Line Height', '%s stands for HTML heading tag.', 'fl-automator' ), 'H6' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				),

				/* H6 Letter Spacing */
				'fl-h6-letter-spacing' => array(
					'setting'   => array(
						'default'   => '0',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class' => 'FLCustomizerControl',
						'label' => sprintf( _x( '%s Letter Spacing', '%s stands for HTML heading tag.', 'fl-automator' ), 'H6' ),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => -3,
						    'max'  => 10,
						    'step' => 1
						),
					)
				)
			)
		),

		/* Body Font Section */
		'fl-body-font' => array(
			'title'   => _x( 'Text', 'Customizer section title.', 'fl-automator' ),
			'options' => array(

				/* Body Text Color */
				'fl-body-text-color' => array(
					'setting'   => array(
						'default'   => '#808080'
					),
					'control'   => array(
						'class'     => 'WP_Customize_Color_Control',
						'label'     => __('Color', 'fl-automator')
					)
				),

				/* Body Font Family */
				'fl-body-font-family' => array(
					'setting'   => array(
						'default'   => 'Helvetica'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Font Family', 'fl-automator'),
						'type'      => 'font',
						'connect'   => 'fl-body-font-weight'
					)
				),
				
				/* Body Font Weight */
				'fl-body-font-weight' => array(
					'setting'   => array(
						'default'   => '400'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Font Weight', 'fl-automator'),
						'type'      => 'font-weight',
						'connect'   => 'fl-body-font-family'
					)
				),				

				/* Body Font Size */
				'fl-body-font-size' => array(
					'setting'   => array(
						'default'   => '14',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Font Size', 'fl-automator'),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 10,
						    'max'  => 72,
						    'step' => 1
						),
					)
				),

				/* Body Line Height */
				'fl-body-line-height' => array(
					'setting'   => array(
						'default'   => '1.45',
						'transport' => 'postMessage'
					),
					'control'   => array(
						'class'     => 'FLCustomizerControl',
						'label'     => __('Line Height', 'fl-automator'),
						'type'  => 'slider',
						'choices'     => array(
						    'min'  => 1,
						    'max'  => 2.5,
						    'step' => 0.05
						),
					)
				)				
			)
		),
	)
));