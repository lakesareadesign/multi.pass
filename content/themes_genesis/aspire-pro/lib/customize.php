<?php

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function aspire_customizer_get_default_accent_color() {
	return '#fa5738';
}

add_action( 'customize_register', 'aspire_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function aspire_customizer_register() {

	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class Child_Aspire_Image_Control extends WP_Customize_Image_Control {

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
			$this->statuses = array( '' => __( 'No Image', 'aspire' ) );

			parent::__construct( $manager, $id, $args );

			$this->add_tab( 'upload-new', __( 'Upload New', 'aspire' ), array( $this, 'tab_upload_new' ) );
			$this->add_tab( 'uploaded',   __( 'Uploaded', 'aspire' ),   array( $this, 'tab_uploaded' ) );

			if ( $this->setting->default )
				$this->add_tab( 'default',  __( 'Default', 'aspire' ),  array( $this, 'tab_default_background' ) );

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

	$images = apply_filters( 'aspire_images', array( '1', '4', '5', '7', '9', '11', '12' ) );

	$wp_customize->add_section( 'aspire-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 1050 pixels tall</strong>.', 'aspire' ),
		'title'    => __( 'Front Page Background Images', 'aspire' ),
		'priority' => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-aspire-image', array(
			'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'     => 'option',
		) );

		$wp_customize->add_control( new Child_Aspire_Image_Control( $wp_customize, $image .'-aspire-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'aspire' ), $image ),
			'section'  => 'aspire-settings',
			'settings' => $image .'-aspire-image',
			'priority' => $image+1,
		) ) );

	}

	$wp_customize->add_setting(
		'aspire_accent_color',
		array(
			'default' => aspire_customizer_get_default_accent_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'aspire_accent_color',
			array(
				'description' => __( 'Change the default accent color for links, buttons, and more.', 'aspire' ),
			    'label'       => __( 'Accent Color', 'aspire' ),
			    'section'     => 'colors',
			    'settings'    => 'aspire_accent_color',
			)
		)
	);
	
	//* Add front page setting to the Customizer
		$wp_customize->add_section( 'aspire_journal_section', array(
		    'title'    => __( 'Front Page Content Settings', 'aspire' ),
		    'description' => __( 'Choose if you would like to display the content section below widget sections on the front page.', 'aspire' ),
		    'priority' => 75.01,
		));
		
		//* Add front page setting to the Customizer
		$wp_customize->add_setting( 'aspire_journal_setting', array(
		    'default'           => 'true',
		    'capability'        => 'edit_theme_options',
		    'type'              => 'option',
		));	
	
		$wp_customize->add_control( new WP_Customize_Control( 
		    $wp_customize, 'aspire_journal_control', array(
				'label'       => __( 'Front Page Content Section Display', 'aspire' ),
				'description' => __( 'Show or Hide the content section. The section will display on the front page by default.', 'aspire' ),
				'section'     => 'aspire_journal_section',
				'settings'    => 'aspire_journal_setting',
				'type'        => 'select',
				'choices'     => array(                    
					'false'   => __( 'Hide content section', 'aspire' ),
					'true'    => __( 'Show content section', 'aspire' ),
				),
		    ))
		);
		
	    $wp_customize->add_setting( 'aspire_journal_text', array(
			'default'           => __( 'Latest From the Blog', 'aspire' ),
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
			'type'              => 'option',
	    ));
	
	    $wp_customize->add_control( new WP_Customize_Control( 
	        $wp_customize, 'aspire_journal_text_control', array(
				'label'      => __( 'Journal Section Heading Text', 'aspire' ),
				'description' => __( 'Choose the heading text you would like to display above posts on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'aspire' ),
				'section'    => 'aspire_journal_section',
				'settings'   => 'aspire_journal_text',
				'type'       => 'text',
			))
		);

}
