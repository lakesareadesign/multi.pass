<?php

class UM_Friends_Setup {

	function __construct() {

		add_action('init',  array(&$this, 'sql_setup'), 8);

	}

	/***
	***	@sql setup
	***/
	function sql_setup() {
		global $wpdb;

		if ( !current_user_can('manage_options') ) return;
	
		//delete_option('ultimatemember_friends_db');

		if ( get_option('ultimatemember_friends_db') == um_friends_version ) return;
		
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "um_friends";
		
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  user_id1 mediumint(9) NOT NULL,
		  user_id2 mediumint(9) NOT NULL,
		  status mediumint(9) NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		update_option('ultimatemember_friends_db', um_friends_version );

	}

}