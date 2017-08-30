<?php

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
function elegance_sanitize_image( $image, $setting ) {

	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon'
	);

	// Return an array with file extension and mime_type.
	$file = wp_check_filetype( $image, $mimes );

	// If $image has a valid mime_type, return it; otherwise, return the default.
	return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function elegance_sanitize_checkbox( $checked ) {
	
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );

}

/**
 * Customizer: Add Sections
 *
 * This code adds a Section with multiple Settings and Controls to the Customizer
 *
 * @package   code-examples
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */


/**
 * Theme Options Customizer Implementation.
 *
 * Implement the Theme Customizer for Theme Settings.
 *
 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function elegance_register_theme_customizer( $wp_customize ) {

	/*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}


	/**
	 * Add CTA Section for General Options.
	 *
	 * @uses $wp_customize->add_section() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
	 * @link $wp_customize->add_section() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
	 */
	$wp_customize->add_section(
		// $id
		'elegance_section_cta',
		// $args
		array(
			'title'			=> __( 'CTA Background', 'elegance' ),
			'description'	=> __( 'Set background image for the call to action. This should be around 2680x300 for retina quality or 1340x150 for standard quality.', 'elegance' ),
			'priority'		=> 9
		)
	);

	/**
	 * cta Background Image setting.
	 *
	 * - Setting: cta Background Image
	 * - Control: WP_Customize_Image_Control
	 * - Sanitization: image
	 *
	 * Uses the media manager to upload and select an image to be used as the cta background image.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'cta_background_image_setting',
		// $args
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'elegance_sanitize_image',
			'transport'			=> 'postMessage'
		)
	);


	/**
	 * Display cta Background Image Repeat setting.
	 *
	 * - Setting: Display cta Background Image Repeat
	 * - Control: checkbox
	 * - Sanitization: checkbox
	 *
	 * Uses a checkbox to configure the display of the cta background image repeat checkbox.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'cta_background_image_repeat_setting',
		// $args
		array(
			'default'			=> true,
			'sanitize_callback'	=> 'elegance_sanitize_checkbox',
			'transport'			=> 'postMessage'
		)
	);

	/**
	 * Display cta Background Image Size setting.
	 *
	 * - Setting: Display cta Background Image Size
	 * - Control: checkbox
	 * - Sanitization: checkbox
	 *
	 * Uses a checkbox to configure the display of the cta background image repeat checkbox.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'cta_background_image_size_setting',
		// $args
		array(
			'default'			=> false,
			'sanitize_callback'	=> 'elegance_sanitize_checkbox',
			'transport'			=> 'postMessage'
		)
	);


	/**
	 * Image Upload control.
	 *
	 * Control: Image Upload
	 * Setting: cta Background Image
	 * Sanitization: image
	 *
	 * Register "WP_Customize_Image_Control" to be used to configure the cta Background Image setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 *
	 * @uses WP_Customize_Image_Control() https://developer.wordpress.org/reference/classes/wp_customize_image_control/
	 * @link WP_Customize_Image_Control() https://codex.wordpress.org/Class_Reference/WP_Customize_Image_Control
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'cta_background_image',
			// $args
			array(
				'settings'	  => 'cta_background_image_setting',
				'section'	  => 'elegance_section_cta',
				'label'		  => __( 'CTA Background Image', 'elegance' ),
				'description' => __( 'Select the background image for CTA.', 'elegance' )
			)
		)
	);

	/**
	 * Basic Checkbox control.
	 *
	 * - Control: Basic: Checkbox
	 * - Setting: Display cta Backgroud Image Repeat
	 * - Sanitization: checkbox
	 *
	 * Register the core "checkbox" control to be used to configure the Display cta Backgroud Image Repeat setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
		// $id
		'cta_background_image_repeat',
		// $args
		array(
			'settings'	  => 'cta_background_image_repeat_setting',
			'section'	  => 'elegance_section_cta',
			'type'		  => 'checkbox',
			'label'		  => __( 'Background Repeat', 'elegance' ),
			'description' => __( 'Should the CTA background image repeat?', 'elegance' ),
		)
	);

	/**
	 * Basic Checkbox control.
	 *
	 * - Control: Basic: Checkbox
	 * - Setting: Display cta Backgroud Image Size
	 * - Sanitization: checkbox
	 *
	 * Register the core "checkbox" control to be used to configure the Display cta Backgroud Image Size setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
		// $id
		'cta_background_image_size',
		// $args
		array(
			'settings'	  => 'cta_background_image_size_setting',
			'section'	  => 'elegance_section_cta',
			'type'		  => 'checkbox',
			'label'		  => __( 'Background Stretch', 'elegance' ),
			'description' => __( 'Should the CTA background image stretch in full?', 'elegance' ),
		)
	);

}
// Settings API options initilization and validation.
add_action( 'customize_register', 'elegance_register_theme_customizer' );

/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    sk
 * @since      0.3.0
 * @version    0.3.0
 */
function elegance_customizer_live_preview() {
	
	wp_enqueue_script(
		'elegance-theme-customizer',
		get_stylesheet_directory_uri() . '/js/theme-customizer.js',
		array( 'customize-preview' ),
		'0.1.0',
		true
	);

} // end elegance_customizer_live_preview
add_action( 'customize_preview_init', 'elegance_customizer_live_preview' );


/**
 * Writes the cta Background related controls' values out to the 'head' element of the document
 * by reading the value(s) from the theme mod value in the options table.
 */
function elegance_customizer_css() {
	if ( ! get_theme_mod( 'cta_background_image_setting' ) && false === get_theme_mod( 'cta_background_image_repeat_setting' ) && false === get_theme_mod( 'cta_background_image_size_setting' ) ) {
		return;
	}
?>
	<style type="text/css">
		.cta-widget {

			<?php if ( get_theme_mod( 'cta_background_image_setting' ) != '' ) { ?>
				background-image: url(<?php echo get_theme_mod( 'cta_background_image_setting' ); ?>);
			<?php } ?>

			<?php if ( true === get_theme_mod( 'cta_background_image_repeat_setting' ) ) { ?>
				background-repeat: repeat;
			<?php } ?>

			<?php if ( true === get_theme_mod( 'cta_background_image_size_setting' ) ) { ?>
				background-size: 100%;
			<?php } ?>
		}
	</style>
<?php
} // end elegance_customizer_css
add_action( 'wp_head', 'elegance_customizer_css' );
