<?php

class UM_Messaging_Setup {

	function __construct() {

		add_action('init',  array(&$this, 'sql_setup'), 8);

	}

	/***
	***	@sql setup
	***/
	function sql_setup() {
		global $wpdb;

		if ( !current_user_can('manage_options') ) return;
		if ( get_option('ultimatemember_messaging_db2') == um_messaging_version ) return;
		
		$charset_collate = $wpdb->get_charset_collate();
		
		$table_name1 = $wpdb->prefix . "um_conversations";
		$table_name2 = $wpdb->prefix . "um_messages";
		
		$sql = "
		
		CREATE TABLE $table_name1 (
		  conversation_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		  user_a bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
		  user_b bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
		  last_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  UNIQUE KEY conversation_id (conversation_id)
		) $charset_collate;
		
		CREATE TABLE $table_name2 (
		  message_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		  conversation_id bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  content longtext DEFAULT '' NOT NULL,
		  status int(11) DEFAULT 0 NOT NULL,
		  author bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
		  recipient bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
		  UNIQUE KEY message_id (message_id)
		) $charset_collate;
		
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		update_option('ultimatemember_messaging_db2', um_messaging_version );

	}

}