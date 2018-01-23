<?php
/**
 * Loads Customizer image settings for Hello Pro theme.
 *
 * @since 2.0
 *
 * @package Hello Pro Theme
 */

add_action( 'customize_register', 'hellopro_register_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 */
function hellopro_register_customizer() {

	/*
	 SETUP CLASS
	------------------------------------------------------------------------- */
	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class HelloPro_Image_Control extends WP_Customize_Image_Control {

		/**
		 * Constructor.
		 *
		 * If $args['settings'] is not defined, use the $id as the setting ID.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Upload_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string               $id
		 * @param array                $args
		 */
		// public function __construct( $manager, $id, $args ) {
		// $this->statuses = array( '' => __( 'No Image', 'hello-pro' ) );
		//
		// parent::__construct( $manager, $id, $args );
		//
		// $this->add_tab( 'upload-new', __( 'Upload New', 'hello-pro' ), array( $this, 'tab_upload_new' ) );
		// $this->add_tab( 'uploaded',   __( 'Uploaded', 'hello-pro' ),   array( $this, 'tab_uploaded' ) );
		// if ( $this->setting->default ) {
		// $this->add_tab( 'default',  __( 'Default', 'hello-pro' ),  array( $this, 'tab_default_background' ) );
		// }
		// Early priority to occur before $this->manager->prepare_controls();.
		// add_action( 'customize_controls_init', array( $this, 'prepare_control' ), 5 );
		// }
		/**
		 * Tab.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Image_Control::print_tab_image()
		 */
		// public function tab_default_background() {
		// $this->print_tab_image( $this->setting->default );
		// }
	}

	/*
	 START CUSTOMIZER CODE
	------------------------------------------------------------------------- */
	global $wp_customize;

	$images = apply_filters( 'hellopro_images', array( '1', '2', '3', '4' ) );

	/*
	 "FRONT PAGE BACKGROUND IMAGES" SECTION
	------------------------------------------------------------------------- */
	$wp_customize->add_section( 'HelloPro-settings', array(
		'title'    => __( 'Front Page Background Images', 'hello-pro' ),
		'priority' => 80,
		'active_callback' => 'is_front_page',
	) );

	foreach ( $images as $image ) {

		if ( '1' === $image || '2' === $image || '3' === $image || '4' === $image ) {
			$wp_customize->add_setting( $image .'-hellopro-image', array(
				'default'  => '',
				'type'     => 'theme_mod',
				'sanitize_callback'	=> 'hellopro_sanitize_image',
			) );
		} else {
			$wp_customize->add_setting( $image .'-hellopro-image', array(
				'default'  => '',
				'type'     => 'theme_mod',
				'sanitize_callback'	=> 'hellopro_sanitize_image',
			) );
		}

		if ( '1' === $image ) {

			$wp_customize->add_control( new HelloPro_Image_Control( $wp_customize, $image .'-image', array(
				'label'    => sprintf( __( 'Front Page Welcome Section Image:', 'hello-pro' ), $image ),
						'section'  => 'HelloPro-settings',
						'description' => ' <hr> ',
						'settings' => $image .'-hellopro-image',
						'priority' => $image + 1,
			) ) );

		} elseif ( '2' === $image ) {

			$wp_customize->add_control( new HelloPro_Image_Control( $wp_customize, $image .'-image', array(
				'label'    => sprintf( __( 'Front Page Call To Action Section Image:', 'hello-pro' ), $image ),
						'section'  => 'HelloPro-settings',
						'description' => ' <hr> ',
						'settings' => $image .'-hellopro-image',
						'priority' => $image + 1,
			) ) );

		} elseif ( '3' === $image ) {

			$wp_customize->add_control( new HelloPro_Image_Control( $wp_customize, $image .'-image', array(
				'label'    => sprintf( __( 'Front Page Statement Section Image:', 'hello-pro' ), $image ),
						'section'  => 'HelloPro-settings',
						'description' => ' <hr> ',
						'settings' => $image .'-hellopro-image',
						'priority' => $image + 1,
			) ) );

		} else {

			$wp_customize->add_control( new HelloPro_Image_Control( $wp_customize, $image .'-image', array(
				'label'    => sprintf( __( 'Front Page Testimonial Section Image:', 'hello-pro' ), $image ),
						'section'  => 'HelloPro-settings',
						'description' => ' <hr> ',
						'settings' => $image .'-hellopro-image',
						'priority' => $image + 1,
			) ) );
		}

		/*
		 BG IMAGE POSITION
		--------------------------------------------------------------------- */
		$wp_customize->add_setting( $image .'-hellopro-image-position-x', array(
			'default'  => 'center',
			'type'     => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control( $image .'-hellopro-image-position-x', array(
			'label'      => __( 'Background Position Horizontal', 'hello-pro' ),
			'section'    => 'HelloPro-settings',
			'type'       => 'select',
			'priority'   => $image + 1,
			'choices'    => array(
					'left'       => __( 'Left', 'hello-pro' ),
					'center'     => __( 'Center', 'hello-pro' ),
					'right'      => __( 'Right', 'hello-pro' ),
			),
		));

		$wp_customize->add_setting( $image .'-hellopro-image-position-y', array(
			'default'        => 'center',
			'type'     => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( $image .'-hellopro-image-position-y', array(
			'label'      => __( 'Background Position Vertical', 'hello-pro' ),
			'section'  => 'HelloPro-settings',
			'type'       => 'select',
			'priority' => $image + 1,
			'choices'    => array(
					'top'       => __( 'Top', 'hello-pro' ),
					'center'     => __( 'Center', 'hello-pro' ),
					'bottom'      => __( 'Bottom', 'hello-pro' ),
			),
		) );

		/*
		 "LOGO IMAGE" SECTION
		--------------------------------------------------------------------- */
		$wp_customize->add_section( 'header_image', array(
				 'title'          => __( 'Logo Image', 'hello-pro' ),
				 'theme_supports' => 'custom-header',
				 'priority'       => 60,
		) );

		/*
		 "STICKY HEADER" SECTION
		--------------------------------------------------------------------- */
		$wp_customize->add_section('header_settings' , array(
				'title'     => __( 'Sticky Header', 'hello-pro' ),
				'priority'  => 70,
		));

		/*
		 STICKY HEADER OPTION
		--------------------------------------------------------------------- */
		$wp_customize->add_setting('fixed_header_off', array(
				'default'    => false,
				'type'     => 'theme_mod',
				'sanitize_callback' => 'hellopro_sanitize_checkbox',
		));

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'fixed_header_off',
				array(
					'label'     => __( 'Turn OFF the Sticky Header Navigation — (no "sticky" behavior)', 'hello-pro' ),
					'section'   => 'header_settings',
					'settings'  => 'fixed_header_off',
					'type'      => 'checkbox',
				)
			)
		);

		$wp_customize->add_setting(
			'hello_pro_link_color',
			array(
					'default'           => hello_pro_customizer_get_default_link_color(),
					'sanitize_callback' => 'sanitize_hex_color',
				)
		);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'hello_pro_link_color',
					array(
						'description' => __( 'Change the color of post info links, hover color of linked titles, hover color of menu items, and more.', 'hello-pro' ),
						'label'       => __( 'Link Color', 'hello-pro' ),
						'section'     => 'colors',
						'settings'    => 'hello_pro_link_color',
					)
				)
			);

			$wp_customize->add_setting(
				'hello_pro_accent_color',
				array(
					'default'           => hello_pro_customizer_get_default_accent_color(),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'hello_pro_accent_color',
					array(
						'description' => __( 'Change the default hovers color for button.', 'hello-pro' ),
						'label'       => __( 'Accent Color', 'hello-pro' ),
						'section'     => 'colors',
						'settings'    => 'hello_pro_accent_color',
					)
				)
			);
	}
}


/**
 * Image sanitization callback.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 *
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function hellopro_sanitize_image( $image, $setting ) {

	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'svg'          => 'image/svg',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon',
	);

	// Return an array with file extension and mime_type.
	$file = wp_check_filetype( $image, $mimes );

	// If $image has a valid mime_type, return it; otherwise, return nothing.
	return ( $file['ext'] ? $image : '');
}

/**
 * Checkbox sanitization callback example.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function hellopro_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}
