<?php

class UM_bbPress_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 4);
		
		add_action('init', array(&$this, 'init'), 5);
		
		add_action('um_admin_before_saving_role_meta', array(&$this, 'remove_this_meta'), 5);

		add_filter('query_vars', array(&$this, 'add_query_vars') );

	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-bbpress'), um_bbpress_extension) );
			$this->plugin_inactive = true;
		
		} else if( !class_exists('bbPress') ) {
			
			$this->add_notice( sprintf(__('Sorry. You must activate the <strong>bbPress</strong> plugin to use the %s.','um-bbpress'), um_bbpress_extension ) );
			$this->plugin_inactive = true;
			
		} else if ( !version_compare( ultimatemember_version, um_bbpress_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-bbpress'), um_bbpress_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() || ( defined('DOING_AJAX') && DOING_AJAX ) ) return;
		
		echo '<div class="error um-admin-notice"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@Init
	***/
	function init() {
		
		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_bbpress_path . 'core/um-bbpress-enqueue.php';
		
		$this->enqueue = new UM_bbPress_Enqueue();
		
		// Actions
		require_once um_bbpress_path . 'core/actions/um-bbpress-content.php';
		require_once um_bbpress_path . 'core/actions/um-bbpress-ajax.php';
		require_once um_bbpress_path . 'core/actions/um-bbpress-redirect.php';
		require_once um_bbpress_path . 'core/actions/um-bbpress-admin.php';
		require_once um_bbpress_path . 'core/actions/um-bbpress-notices.php';
		
		// Filters
		require_once um_bbpress_path . 'core/filters/um-bbpress-settings.php';
		require_once um_bbpress_path . 'core/filters/um-bbpress-tabs.php';
		require_once um_bbpress_path . 'core/filters/um-bbpress-access.php';
		require_once um_bbpress_path . 'core/filters/um-bbpress-permissions.php';
		require_once um_bbpress_path . 'core/filters/um-bbpress-caps.php';
		require_once um_bbpress_path . 'core/filters/um-bbpress-admin.php';
		
	}
	
	/***
	***	@Get count of subscriptions of user
	***/
	function user_subscriptions_count( $user_id = null ) {
		$topic_count = count(bbp_get_user_subscribed_topic_ids($user_id));
		$forum_count = count(bbp_get_user_subscribed_forum_ids($user_id));
		return $forum_count + $topic_count ;
	}
	
	/***
	***	@delete specific meta conditionally
	***/
	function remove_this_meta( $post_id ) {
		delete_post_meta( $post_id, '_um_lock_days' );
	}
	
	/***
	***	@Get week days
	***/
	function get_weekdays() {
		$array['sun'] = 'Sunday';
		$array['mon'] = 'Monday';
		$array['tue'] = 'Tuesday';
		$array['wed'] = 'Wednesday';
		$array['thu'] = 'Thursday';
		$array['fri'] = 'Friday';
		$array['sat'] = 'Saturday';
		return $array;
	}
	
	/***
	***	@Check if user role allow creating topic
	***/
	function can_do_topic() {
		global $ultimatemember;
		
		if ( is_admin() ) return true;
		
		$user_id = get_current_user_id();
		$role = get_user_meta( $user_id, 'role', true );
		$role_data = $ultimatemember->query->role_data( $role );
		
		$lock_days = ( isset( $role_data['lock_days'] ) && $role_data['lock_days'] ) ? unserialize( $role_data['lock_days'] ) : '';
		$check_day = strtolower(current_time('D'));
		
		if ( $lock_days && in_array( $check_day, $lock_days ) ) return false;

		return true;
	}

	function add_query_vars( $query_vars ) {
	    $query_vars[] = 'bbp-subscription';
	    return $query_vars;
	}

	
}

$um_bbpress = new UM_bbPress_API();