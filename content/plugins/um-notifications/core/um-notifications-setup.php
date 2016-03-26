<?php

class UM_Notifications_Setup {

	function __construct() {

		add_action('init',  array(&$this, 'sql_setup'), 8);
		
		add_action('init',  array(&$this, 'setup'), 9);

	}
	
	function is_setup() {
		if ( get_option('um_notification_addon_setup') )
			return true;
		return false;
	}
	
	/***
	***	@sql setup
	***/
	function sql_setup() {
		global $wpdb;
		
		if ( !current_user_can('manage_options') ) return;
		if ( get_option('ultimatemember_notification_db') == um_notifications_version ) return;
		
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "um_notifications";
		
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  user tinytext NOT NULL,
		  status tinytext NOT NULL,
		  photo varchar(255) DEFAULT '' NOT NULL,
		  type tinytext NOT NULL,
		  url varchar(255) DEFAULT '' NOT NULL,
		  content text NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		update_option('ultimatemember_notification_db', um_notifications_version );

	}
	
	/***
	***	@setup
	***/
	function setup() {
		global $wpdb, $ultimatemember;

		if ( !current_user_can('manage_options') ) return;
		if ( $this->is_setup() ) return;

		$core = $ultimatemember->permalinks->core;
		if ( isset( $core ) && !empty( $core ) ) {

			if ( isset($core['notifications']) ) return;
			
			$args = array(
				'post_type' 	  	=> 'page',
				'post_title'		=> __('Notifications','um-notifications'),
				'post_status'		=> 'publish',
				'post_author'   	=> um_user('ID'),
				'post_content'		=> '[ultimatemember_notifications]',
				'comment_status'	=> 'closed',
			);

			$post_id = wp_insert_post( $args );
			if ( $post_id ) {
				
				$core['notifications'] = $post_id;

				update_option('um_core_pages', $core );
				update_post_meta( $post_id, '_um_core', 'notifications');
				update_option('um_notification_addon_setup', 1);
				
			}
		
		}
		
	}

}