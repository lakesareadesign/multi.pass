<?php

class UM_Activity_Setup {

	function __construct() {

		add_action('init',  array(&$this, 'setup'), 9);

	}
	
	function is_setup() {
		if ( get_option('um_activity_addon_setup') )
			return true;
		return false;
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

			if ( isset($core['activity']) ) return;
			
			$args = array(
				'post_type' 	  	=> 'page',
				'post_title'		=> __('Activity','um-activity'),
				'post_status'		=> 'publish',
				'post_author'   	=> um_user('ID'),
				'post_content'		=> '[ultimatemember_activity]',
				'comment_status'	=> 'closed',
			);

			$post_id = wp_insert_post( $args );
			if ( $post_id ) {
				
				$core['activity'] = $post_id;

				update_option('um_core_pages', $core );
				update_post_meta( $post_id, '_um_core', 'activity');
				update_option('um_activity_addon_setup', 1);
				
			}
		
		}
		
	}

}