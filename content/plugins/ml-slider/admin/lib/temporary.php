<?php

if (!defined('ABSPATH')) {
    die('No direct access.');
}

add_filter('metaslider_basic_settings', 'metaslider_add_legacy_theme_setting', 10, 2);
/**
 * Add legacy theme selection back temporarily
 * 
 * @param array  $fields    - The current fields
 * @param object $slideshow - The slideshow object
 * @return array
 */
function metaslider_add_legacy_theme_setting($fields, $slideshow) {

	// Include the settings class if not already loaded.
    if (!class_exists('MetaSlider_Slideshow_Settings')) {
        require_once plugin_dir_path(__DIR__) . 'Settings.php';
    }
	$settings = new MetaSlider_Slideshow_Settings($slideshow->id);

	$theme = $settings->get_single('theme') ? $settings->get_single('theme') : '';
	$fields['theme'] = array(
		'priority' => 40,
		'type' => 'theme',
		'value' => $theme,
		'label' => __( "Theme", "ml-slider" ),
		'class' => 'effect coin flex responsive nivo',
		'helptext' => __( "Slideshow theme", "ml-slider" ),
		'options' => array(
			'default' => array( 'class' => 'option nivo flex coin responsive' , 'label' => __( "Default", "ml-slider" ) ),
			'dark'    => array( 'class' => 'option nivo', 'label' => __( "Dark (Nivo)", "ml-slider" ) ),
			'light'   => array( 'class' => 'option nivo', 'label' => __( "Light (Nivo)", "ml-slider" ) ),
			'bar'     => array( 'class' => 'option nivo', 'label' => __( "Bar (Nivo)", "ml-slider" ) ),
		),
	);
	return $fields;
}
