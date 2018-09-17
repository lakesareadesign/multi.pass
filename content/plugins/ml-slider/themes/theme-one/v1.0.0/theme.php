<?php

if (!defined('ABSPATH')) die('No direct access.');

/*
 * Main theme file
 */
class MetaSlider_Theme_One extends MetaSlider_Theme_Base {
	/**
	 * Theme ID
	 *
	 * @var string
	 */
	public $id = 'theme-one';

	/**
	 * Theme Version
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	public function __construct() {
		parent::__construct($this->id, $this->version);
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
		wp_enqueue_style('metaslider_theme_one_theme_styles', METASLIDER_THEMES_URL . $this->id . '/v1.0.0/style.css', array('metaslider-public'), '1.0.0');
	}
}

if (!isset(MetaSlider_Theme_Base::$themes['theme-one'])) new MetaSlider_Theme_One();
