<?php

class UM_Friends_API {

	function __construct() {

		$this->plugin_inactive = false;

		add_action('init', array(&$this, 'plugin_check'), 1);

		add_action('init', array(&$this, 'init'), 1);

		require_once um_friends_path . 'core/um-friends-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );

	}

	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){

		if ( !class_exists('UM_API') ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-friends'), um_friends_extension) );
			$this->plugin_inactive = true;

		} else if ( !version_compare( ultimatemember_version, um_friends_requires, '>=' ) ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-friends'), um_friends_extension) );
			$this->plugin_inactive = true;

		}

	}

	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {

		
		if ( !is_admin() || ( defined('DOING_AJAX') && DOING_AJAX ) ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';

	}

	/***
	***	@Init
	***/
	function init() {

		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_friends_path . 'core/um-friends-setup.php';
		require_once um_friends_path . 'core/um-friends-api.php';
		require_once um_friends_path . 'core/um-friends-enqueue.php';
		require_once um_friends_path . 'core/um-friends-shortcode.php';

		$this->api = new UM_Friends_Main_API();
		$this->setup = new UM_Friends_Setup();
		$this->enqueue = new UM_Friends_Enqueue();
		$this->shortcode = new UM_Friends_Shortcode();

		// Actions
		require_once um_friends_path . 'core/actions/um-friends-profile.php';
		require_once um_friends_path . 'core/actions/um-friends-notifications.php';
		require_once um_friends_path . 'core/actions/um-friends-members.php';
		require_once um_friends_path . 'core/actions/um-friends-ajax.php';
		require_once um_friends_path . 'core/actions/um-friends-admin.php';
		require_once um_friends_path . 'core/actions/um-friends-account.php';

		// Filters
		require_once um_friends_path . 'core/filters/um-friends-settings.php';
		require_once um_friends_path . 'core/filters/um-friends-profile.php';
		require_once um_friends_path . 'core/filters/um-friends-admin.php';
		require_once um_friends_path . 'core/filters/um-friends-account.php';
		require_once um_friends_path . 'core/filters/um-friends-search.php';

	}

	function widgets_init() {
		register_widget( 'um_my_friends' );
	}

}

$um_friends = new UM_Friends_API();
