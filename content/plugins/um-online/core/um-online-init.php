<?php

class UM_Online_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);
		
		add_action('init', array(&$this, 'log'), 1);
		
		$this->users = get_option('um_online_users');

		$this->schedule_update();
		
		require_once um_online_path . 'core/um-online-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );

	}

	/***
	***	@Plugin check
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-online'), um_online_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_online_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-online'), um_online_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}

	/***
	***	@Plugin notice
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
		require_once um_online_path . 'core/um-online-shortcode.php';
		require_once um_online_path . 'core/um-online-enqueue.php';

		$this->shortcode = new UM_Online_Shortcode();
		$this->enqueue = new UM_Online_Enqueue();

		// Actions
		require_once um_online_path . 'core/actions/um-online-profile.php';
		require_once um_online_path . 'core/actions/um-online-account.php';
		
		// Filters
		require_once um_online_path . 'core/filters/um-online-fields.php';

	}
	
	/***
	***	@Logs online user
	***/
	function log() {
		
		// Guest or not on frontend
		if ( is_admin() || !is_user_logged_in() )
			return;
		
		// User privacy do not allow that
		$test = get_user_meta( get_current_user_id(), '_hide_online_status', true );
		if ( $test == 1 ) {
			return;
		}
		
		// We have a logged in user
		// Store the user as online with a timestamp of last seen
		$this->users[ get_current_user_id() ] = current_time('timestamp');
		
		// Save the new online users
		update_option('um_online_users', $this->users );
	
	}
	
	/***
	***	@Gets users online
	***/
	function get_users() {
		if ( isset( $this->users ) && is_array( $this->users ) && !empty( $this->users ) ) {
			arsort( $this->users ); // this will get us the last active user first
			return $this->users;
		}
		return false;
	}
	
	/***
	***	@Checks if user is online
	***/
	function is_online( $user_id ) {
		if ( isset( $this->users[ $user_id ] ) )
			return true;
		return false;
	}
	
	/***
	***	@Update the online users
	***/
	private function schedule_update() {
		$this->run_update();
	}

	/***
	***	@Execute updating the list every x interval
	***/
	public function run_update() {

		// Send a maximum of once per period
		$last_send = $this->get_last_update();
		if( $last_send && $last_send > strtotime( '-15 minutes' ) )
			return;
			
		// We have to check if each user was last seen in the previous x
		if ( is_array( $this->users ) ) {
			foreach( $this->users as $user_id => $last_seen ) {
				if ( ( current_time('timestamp') - $last_seen ) > ( 60 * 15 ) ) {
					// Time now is more than x since he was last seen
					// Remove user from online list
					unset( $this->users[$user_id] );
				}
			}
			update_option('um_online_users', $this->users );
		}
	
		update_option( 'um_online_users_last_updated', time() );

	}
	
	private function get_last_update() {
		return get_option( 'um_online_users_last_updated' );
	}
	
	function widgets_init() {
		register_widget( 'um_online_users' );
	}
	
}

$um_online = new UM_Online_API();