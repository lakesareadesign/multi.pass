<?php

//* Get accent color
function bbs_get_default_color_accent() {
	return '#91c3ba';
}

add_action( 'customize_register', 'bbs_register_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function bbs_register_customizer() {

	global $wp_customize;

  //* Background Image Settings
	$wp_customize->add_section(
    'bbs_background_image_section',
    array(
  		'title'          => __( 'Front Page Background Images', 'bbs' ),
  		'description'    => __( '<p>Personalize your site by uploading your own image for the front page 1, front page 3, and before footer widget backgrounds.</p><p>The recommended pixel dimension for these images is <strong>1600 x 900 pixels</strong>.</p>', 'bbs' ),
  		'priority'       => 75,
  	)
  );

	$wp_customize->add_setting(
    'bbs_front_page_image_1',
    array(
  		'default'  => sprintf( '%s/images/front-page-image-1.jpg', get_stylesheet_directory_uri() ),
  		'type'     => 'option',
  	)
  );

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
      'bbs_front_page_image_1',
      array(
        'label'       => __( 'Front Page Image 1', 'bbs' ),
        'section'     => 'bbs_background_image_section',
        'settings'    => 'bbs_front_page_image_1',
      )
    )
  );

  $wp_customize->add_setting(
    'bbs_front_page_image_2',
    array(
  		'default'  => sprintf( '%s/images/front-page-image-2.jpg', get_stylesheet_directory_uri() ),
  		'type'     => 'option',
	  )
  );

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
      'bbs_front_page_image_2',
      array(
        'label'       => __( 'Front Page Image 2', 'bbs' ),
        'section'     => 'bbs_background_image_section',
        'settings'    => 'bbs_front_page_image_2',
      )
    )
  );

  $wp_customize->add_setting(
    'bbs_front_page_image_3',
    array(
  		'default'  => sprintf( '%s/images/front-page-image-3.jpg', get_stylesheet_directory_uri() ),
  		'type'     => 'option',
	  )
  );

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
      'bbs_front_page_image_3',
      array(
        'label'       => __( 'Front Page Image 3', 'bbs' ),
        'section'     => 'bbs_background_image_section',
        'settings'    => 'bbs_front_page_image_3',
      )
    )
  );

  //* Accent Color

	$wp_customize->add_setting(
    'bbs_accent_color',
    array(
  		'default'           => bbs_get_default_color_accent(),
  		'sanitize_callback' => 'sanitize_hex_color',
  	)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'bbs_accent_color',
			array(
				'description' => __( 'Change the default color for buttons and links.', 'bbs' ),
			  'label'       => __( 'Accent Color', 'bbs' ),
			  'section'     => 'colors',
			  'settings'    => 'bbs_accent_color',
			)
		)
	);

  //* Add front page setting to the Customizer
  $wp_customize->add_section(
    'bbs_front_page_content_settings',
    array(
      'title'       => __( 'Front Page Content Settings', 'bbs' ),
      'description' => __( 'Choose if you would like to display the blog below the front page widget areas on the front page.', 'bbs' ),
      'priority'    => 75.01,
    )
  );

  $wp_customize->add_setting(
    'bbs_front_page_blog_setting',
    array(
      'default'       => 'true',
      'capability'    => 'edit_theme_options',
      'type'          => 'option',
    )
  );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'bbs_front_page_blog_control',
    array(
			'label'       => __( 'Show / Hide Front Page Blog', 'bbs' ),
			'description' => __( 'Show or Hide the blog. The blog will display on the front page by default.', 'bbs' ),
			'section'     => 'bbs_front_page_content_settings',
			'settings'    => 'bbs_front_page_blog_setting',
			'type'        => 'select',
			'choices'     => array(
				'false'     => __( 'Hide blog', 'bbs' ),
				'true'      => __( 'Show blog', 'bbs' ),
			),
    )
  ));

  $wp_customize->add_setting(
    'bbs_blog_title',
    array(
  		'default'           => __( 'Recent Posts', 'bbs' ),
  		'capability'        => 'edit_theme_options',
  		'sanitize_callback' => 'wp_kses_post',
  		'type'              => 'option',
      )
    );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'bbs_blog_title_control',
    array(
			'label'      => __( 'Front Page Blog Heading Text', 'bbs' ),
			'description' => __( 'Choose the heading text you would like to display above the blog on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'bbs' ),
			'section'    => 'bbs_front_page_content_settings',
			'settings'   => 'bbs_blog_title',
			'type'       => 'text',
		))
	);
}
