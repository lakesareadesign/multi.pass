<?php

if (!defined('ABSPATH')) die('No direct access.');

/*
 * Main theme file
 */
class MetaSlider_Theme_Seven extends MetaSlider_Theme_Base {
	/**
	 * Theme ID
	 *
	 * @var string
	 */
	public $id = 'theme-seven';

	/**
	 * Theme Version
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	public function __construct() {
		parent::__construct($this->id, $this->version);
		add_action('metaslider_flex_slider_parameters', array($this, 'move_arrows'), 10, 2);
		add_action('metaslider_flex_slider_javascript_before', array($this, 'remove_broken_commment'), 99, 2);
	}

	/**
	 * Remove this comment that breaks the page (needs high priority number, like 99)
	 *
	 * @param array  $javascript - The javascript that goes before
	 * @param string $id 		 - the id of the slideshow
	 * 
	 * @return array
	 */
	public function remove_broken_commment($javascript, $id) {
		return str_replace('// theme/plugin conflict avoidance', '', $javascript);
	}

	/**
	 * Add some code to flexslider to reposition the arrows
	 *
	 * @param array  $options - The flexslider options
	 * @param string $id 	  - the id of the slideshow
	 * 
	 * @return array
	 */
	public function move_arrows($options, $id) {
		$options['start'] = isset($options['start']) ? $options['start'] : array();
		$options['start'] = array_merge($options['start'], array("$('.metaslider.ms-theme-{$this->id}.has-thumb-nav #metaslider_{$id}.flexslider > .slides').wrap('<div style=\"position:relative\" class=\"flex-slide-wrap\"></div>');
			$('.metaslider.ms-theme-{$this->id}.has-thumb-nav #metaslider_{$id}.flexslider .flex-direction-nav').appendTo('.metaslider.ms-theme-{$this->id} #metaslider_{$id}.flexslider .flex-slide-wrap');"));
		return $options;
	}


	/**
	 * Parameters
	 *
	 * @var string
	 */
	public $slider_parameters = array(
		"prevText" => "'<i class=\"left\"></i>'",
		"nextText" => "'<i class=\"right\"></i>'"
	);

	/**
	 * Enqueues theme specific styles and scripts
	 */
	public function enqueue_assets() {
		wp_enqueue_style('metaslider_theme_seven_theme_styles', METASLIDER_THEMES_URL . $this->id . '/v1.0.0/style.css', array('metaslider-public'), '1.0.0');
		wp_enqueue_script('metaslider_theme_seven_theme_script', METASLIDER_THEMES_URL . $this->id . '/v1.0.0/script.js', array('jquery'), '1.0.0', true);
	}
}

if (!isset(MetaSlider_Theme_Base::$themes['theme-seven'])) new MetaSlider_Theme_Seven();
