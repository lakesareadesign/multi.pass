<?php

class UM_Followers_API {

	function __construct() {

		$this->plugin_inactive = false;

		add_action('init', array(&$this, 'plugin_check'), 1);

		add_action('init', array(&$this, 'init'), 1);

		require_once um_followers_path . 'core/um-followers-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );

	}

	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){

		if ( !class_exists('UM_API') ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-followers'), um_followers_extension) );
			$this->plugin_inactive = true;

		} else if ( !version_compare( ultimatemember_version, um_followers_requires, '>=' ) ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-followers'), um_followers_extension) );
			$this->plugin_inactive = true;

		}

	}

	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {

		if ( !is_admin() ) return;

		echo '<div class="error"><p>' . $msg . '</p></div>';

	}

	/***
	***	@Init
	***/
	function init() {

		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_followers_path . 'core/um-followers-setup.php';
		require_once um_followers_path . 'core/um-followers-api.php';
		require_once um_followers_path . 'core/um-followers-enqueue.php';
		require_once um_followers_path . 'core/um-followers-shortcode.php';

		$this->api = new UM_Followers_Main_API();
		$this->setup = new UM_Followers_Setup();
		$this->enqueue = new UM_Followers_Enqueue();
		$this->shortcode = new UM_Followers_Shortcode();

		// Actions
		require_once um_followers_path . 'core/actions/um-followers-profile.php';
		require_once um_followers_path . 'core/actions/um-followers-notifications.php';
		require_once um_followers_path . 'core/actions/um-followers-members.php';
		require_once um_followers_path . 'core/actions/um-followers-ajax.php';
		require_once um_followers_path . 'core/actions/um-followers-admin.php';
		require_once um_followers_path . 'core/actions/um-followers-account.php';

		// Filters
		require_once um_followers_path . 'core/filters/um-followers-settings.php';
		require_once um_followers_path . 'core/filters/um-followers-profile.php';
		require_once um_followers_path . 'core/filters/um-followers-admin.php';
		require_once um_followers_path . 'core/filters/um-followers-account.php';
		require_once um_followers_path . 'core/filters/um-followers-search.php';

	}

	function widgets_init() {
		register_widget( 'um_my_followers' );
		register_widget( 'um_my_following' );
	}

}

$um_followers = new UM_Followers_API();
