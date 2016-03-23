<?php

/**
 * Customize Background Image Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class Child_Remobile_Image_Control extends WP_Customize_Image_Control {

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
		$this->statuses = array( '' => __( 'No Image', 'remobile' ) );

		parent::__construct( $manager, $id, $args );

		$this->add_tab( 'upload-new', __( 'Upload New', 'remobile' ), array( $this, 'tab_upload_new' ) );
		$this->add_tab( 'uploaded',   __( 'Uploaded', 'remobile' ), array( $this, 'tab_uploaded' ) );
		
		if ( $this->setting->default )
			$this->add_tab( 'default',  __( 'Default', 'remobile' ), array( $this, 'tab_default_background' ) );

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

$wp_customize->add_section( 'remobile-image', array(
	'title'    => __( 'Backstretch Image', 'remobile' ),
	'description'    => __( '<p>Use the included default image or personalize your site by uploading your own image for the homepage and landing page template background.</p><p>The default image is <strong>1600 x 558 pixels</strong>.</p>', 'remobile' ),
	'priority' => 75,
) );

$wp_customize->add_setting( 'remobile-backstretch-image', array(
	'default'  => sprintf( '%s/images/home-intro.jpg', get_stylesheet_directory_uri() ),
	'type'     => 'option',
) );
 
$wp_customize->add_control(
	new Child_Remobile_Image_Control(
		$wp_customize,
		'backstretch-image',
		array(
			'label'       => __( 'Backstretch Image Upload', 'remobile' ),
			'section'     => 'remobile-image',
			'settings'    => 'remobile-backstretch-image',
		)
	)
);
