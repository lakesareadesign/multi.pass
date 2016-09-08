<?php

class WMD_PrettyPluginsFEShowcase extends WMD_PrettyPlugins_Functions {
	var $plugin;

	var $preview_blog_id;

	function __construct() {
		global $wmd_prettyplugins;
		$this->plugin = $wmd_prettyplugins;

		add_shortcode('wmd-plugins-showcase', array($this,'display_plugins_showcase'));

		add_action('init', array($this, 'set_theme_preview_data' ) );
	}

	function display_plugins_showcase($atts) {
		global $post;

		$atts = shortcode_atts(array('preview_site_id' => '', 'plugins' => false, 'hide_interface' => false, 'show_buttons' => 'hover', 'category' => ''), $atts, 'wmd-theme-showcase');
		$this->preview_blog_id = (int) $atts['preview_site_id'];

		$this->plugin->init_vars();
		$this->plugin->set_custom_plugin_data();

		add_filter('wmd_prettythemes_merged_theme_data', array($this, 'set_theme_data'));

		wp_enqueue_style('wmd-prettyplugins-fe-theme', $this->plugin->plugin_dir_url.'includes/frontend-showcase-files/style.css', array(), 6);
		wp_enqueue_script('wmd-prettyplugins-fe-theme', $this->plugin->plugin_dir_url.'includes/frontend-showcase-files/theme.js', array('jquery', 'backbone', 'wp-backbone'), 6);

		if($atts['plugins']) {
			$plugins_links = explode(',', str_replace(' ', '' , $atts['plugins']));
			$plugins = array();
			foreach($themes_stylesheets as $stylesheet)
				$plugins[] = wp_get_theme($stylesheet);
		}
		if(!isset($plugins) || !$plugins)
			$plugins = false;

		$this->plugin->enqueue_plugin_showcase_script_data('wmd-prettyplugins-fe-theme', parse_url( get_permalink($post->ID), PHP_URL_PATH ), true, $plugins, true);

		ob_start();
		include($this->plugin->plugin_dir.'includes/frontend-showcase-files/theme_list.php');
		return ob_get_clean();
	}

	function set_theme_data($theme) {
		global $post;

		$theme['live_preview_url'] = $this->get_live_preview_url($theme['id']);
		$theme['details_url'] = get_permalink($post->ID).'?wmd-fe-showcase-theme-details='.$theme['id'];


		return $theme;
	}

	function get_live_preview_url($theme_id, $preview_blog_id = false) {
		global $post;

		if(!$preview_blog_id)
			$preview_blog_id = $this->preview_blog_id;

		$url = apply_filters('wmd_prettythemes_showcase_theme_site', get_permalink($post->ID));

		return $url.'?wmd-fe-showcase-theme-preview='.$theme_id.'&wmd-fe-showcase-preview-blog-id='.$preview_blog_id;
	}


	function set_theme_preview_data() {
		if ( isset($_GET['wmd-fe-showcase-theme-preview']) && $_GET['wmd-fe-showcase-theme-preview'] && isset($_GET['wmd-fe-showcase-preview-blog-id']) && is_numeric($_GET['wmd-fe-showcase-preview-blog-id']) ) {
			$blog_url = get_site_url($_GET['wmd-fe-showcase-preview-blog-id']);
			if($blog_url) {
				setcookie( 'wmd-fe-showcase', json_encode(array('blog_id' => $_GET['wmd-fe-showcase-preview-blog-id'], 'theme' => esc_attr($_GET['wmd-fe-showcase-theme-preview']))), time() + 30000000, COOKIEPATH, COOKIE_DOMAIN );

				wp_redirect($blog_url);
				exit();
			}
		}
	}
	function get_preview_theme_name() {
		if ( !empty( $_COOKIE[ 'wmd-fe-showcase' ] ) ) {
			$cookie = json_decode(stripslashes($_COOKIE[ 'wmd-fe-showcase' ]), true);
			return $cookie['blog_id'] == get_current_blog_id() ? $cookie['theme'] : false;
		} else {
			return;
		}
	}
}

global $wmd_prettyplugins_fe_showcase;
$wmd_prettyplugins_fe_showcase = new WMD_PrettyPluginsFEShowcase;