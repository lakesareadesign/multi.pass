<?php

/**
 * Customizer additions.
 *
 * @package Remobile Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/remobile/
 * @license GPL2-0+
 */

global $wp_customize;

$wp_customize->add_section( 'remobile-image', array(
	'title'    => __( 'Backstretch Image', 'remobile' ),
	'description'    => __( '<p>Use the included default image or personalize your site by uploading your own image for the homepage.</p><p>The default image is <strong>1600 x 558 pixels</strong>.</p>', 'remobile' ),
	'priority' => 75,
) );

$wp_customize->add_setting( 'remobile-backstretch-image', array(
	'default'  => sprintf( '%s/images/home-intro.jpg', get_stylesheet_directory_uri() ),
	'type'     => 'option',
) );
 
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'backstretch-image',
		array(
			'label'       => __( 'Backstretch Image Upload', 'remobile' ),
			'section'     => 'remobile-image',
			'settings'    => 'remobile-backstretch-image',
		)
	)
);
