<?php

if (!defined('ABSPATH')) die('No direct access.');
/**
 * MS Theme base - Use to instanciate and store theme functions. 
 * Extend it if you need to change / add functionality to your theme.
 */
class MetaSlider_Theme_Base {
	/**
	 * Theme ID
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Registered Themes - used to give access to the themes options and settings
	 * 
	 * @var array
	 */
	public static $themes = array();

	/**
	 * Construct - set private for singleton pattern.
	 */
	public function __construct($id, $version, $assets = array()) {
		$this->id = $id;
		$this->version = $version;
		$this->assets = apply_filters('metaslider_theme_assets', $assets, $this->id);
		
		// store the current instance, to give it global access via MetaSlider_Theme_Base::$themes['theme_id']
		self::$themes[$this->id] = $this;

		$this->init();
	}

	/**
	 * Initialize hooks
	 */
	public function init() {
		// Enqueue assets
		add_action('metaslider_register_public_styles', array($this, 'enqueue_assets'));

		// override the arrows markup
		add_filter('metaslider_flex_slider_parameters', array($this, 'update_parameters'), 10, 3);
		add_filter('metaslider_responsive_slider_parameters', array($this, 'update_parameters'), 10, 3);
		add_filter('metaslider_nivo_slider_parameters', array($this, 'update_parameters'), 10, 3);
		add_filter('metaslider_coin_slider_parameters', array($this, 'update_parameters'), 10, 3);

		// Pro - override the arrows markup for the filmstrip
		add_filter('metaslider_flex_slider_filmstrip_parameters', array($this, 'update_parameters'), 10, 3);

		// Adds classes for thumbnails and filmstrip navigation
		add_filter('metaslider_css_classes', array($this, 'slider_classes'), 20, 3);
	}

	/** 
	 * Slider Classes - Filter 
	 * 
	 * @param string $classes 
	 * @param int    $slider_id 
	 * @param array  $slider_settings 
	 * @return string 
	 */ 
	public function slider_classes($classes, $slider_id, $slider_settings) {
		if (isset($slider_settings['carouselMode']) && 'true' === $slider_settings['carouselMode']) {
			$classes .= ' has-carousel-mode';
		}
		if ('thumbs' == $slider_settings['navigation']) {  
			$classes .= ' has-thumb-nav';  
		}  
		if ('filmstrip' == $slider_settings['navigation']) {  
			$classes .= ' has-filmstrip-nav';  
		}  
		return $classes;  
	}

	/**
	 * Enqueues theme specific styles and scripts
	 */
	public function enqueue_assets() {
		foreach($this->assets as $asset) {
			if ('css' == $asset['type']) {
				wp_enqueue_style('metaslider_' . $this->id . '_theme_styles', METASLIDER_THEMES_URL . $this->id . $asset['file'], isset($asset['dependencies']) ? $asset['dependencies'] : array(), $this->version);
			}

			if ('js' == $asset['type']) {
				wp_enqueue_script('metaslider_' . $this->id . '_theme_script', METASLIDER_THEMES_URL . $this->id . $asset['file'], isset($asset['dependencies']) ? $asset['dependencies'] : array(), $this->version, isset($asset['in_footer']) ? $asset['in_footer'] : true);
			}
		}
	}

	/**
	 * Adds parameters for this theme. Used mainly for changing the Arrows text + icons
	 * 
	 * @param array 	 $options 	   The slider plugin options
	 * @param int|string $slideshow_id The slideshow options
	 * @param array 	 $settings 	   The slideshow settings
	 */
	public function update_parameters($options, $slideshow_id, $settings) {
		$theme_id = false;

		if (!$this->slider_parameters) return $options;

		// if preview
		if (isset($_REQUEST['action']) && 'ms_get_preview' == $_REQUEST['action']) {
			if (isset($_REQUEST['theme_id'])) $theme_id = $_REQUEST['theme_id'];
		}
	
		// only fetch the saved theme if the preview theme isn't set
		if (!$theme_id) {
			$theme = get_post_meta($slideshow_id, 'metaslider_slideshow_theme', true);
			if (isset($theme['folder'])) $theme_id = $theme['folder'];
		}

		if ($this->id == $theme_id) {
			return wp_parse_args(apply_filters('metaslider_theme_' . $this->id . '_slider_parameters', $this->slider_parameters), $options);
		}

		return $options;
	}

}