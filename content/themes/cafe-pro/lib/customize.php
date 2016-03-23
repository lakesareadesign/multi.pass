<?php

/**
 * Customizer additions.
 *
 * @package Cafe Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/cafe/
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
function cafe_customizer_get_default_accent_color() {
	return '#a0ac48';
}

add_action( 'customize_register', 'cafe_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function cafe_customizer(){

	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class Child_Cafe_Image_Control extends WP_Customize_Image_Control {

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
			$this->statuses = array( '' => __( 'No Image', 'cafe' ) );

			parent::__construct( $manager, $id, $args );

			$this->add_tab( 'upload-new', __( 'Upload New', 'cafe' ), array( $this, 'tab_upload_new' ) );
			$this->add_tab( 'uploaded',   __( 'Uploaded', 'cafe' ),   array( $this, 'tab_uploaded' ) );
			
			if ( $this->setting->default )
				$this->add_tab( 'default',  __( 'Default', 'cafe' ),  array( $this, 'tab_default_background' ) );

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

	$images = apply_filters( 'cafe_images', array( 'header', '2', '4' ) );
	
	$wp_customize->add_section( 'cafe-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>2000 pixels wide and between 1300-1500 pixels tall</strong>.', 'cafe' ),
		'title'       => __( 'Background Images', 'cafe' ),
		'priority'    => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-image', array(
			'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'     => 'option',
		) );

		$wp_customize->add_control( new Child_Cafe_Image_Control( $wp_customize, $image .'-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'cafe' ), $image ),
			'section'  => 'cafe-settings',
			'settings' => $image .'-image',
			'priority' => $image+1,
		) ) );

	}

	$wp_customize->add_setting(
		'cafe_accent_color',
		array(
			'default' => cafe_customizer_get_default_accent_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'cafe_accent_color',
			array(
				'description' => __( 'Change the default accent color for links, buttons, and more.', 'cafe' ),
			    'label'       => __( 'Accent Color', 'cafe' ),
			    'section'     => 'colors',
			    'settings'    => 'cafe_accent_color',
			)
		)
	);

}
