<?php
/**
 * AgentPress Pro.
 *
 * This file adds the Customizer additions to the AgentPress Pro Theme.
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

add_action( 'customize_register', 'agentpress_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.1.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function agentpress_customizer(){

	global $wp_customize;

	$wp_customize->add_section( 'agentpress-image', array(
		'title'       => __( 'Background Image', 'agentpress' ),
		'description' => __( '<p>Personalize the top of your site home page by uploading an image.</p><p> The image used on the demo is <strong>1600 x 870 pixels</strong>.</p>', 'agentpress' ),
		'priority'    => 35,
	) );

	$wp_customize->add_setting( 'agentpress-home-image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'type'              => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'home-image',
			array(
				'label'    => __( 'Home Image Upload', 'agentpress' ),
				'section'  => 'agentpress-image',
				'settings' => 'agentpress-home-image',
			)
		)
	);

}
