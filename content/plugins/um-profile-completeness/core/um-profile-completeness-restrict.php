<?php

class UM_Profile_Completeness_Restrict {

	function __construct() {
	
		add_action('template_redirect', array(&$this, 'template_redirect'), 999999999);
		
		add_action('wp_insert_comment', array(&$this, 'wp_insert_comment'), 9999999 );
		
		add_filter('bbp_new_topic_pre_extras', array(&$this, 'forum_restrict'), 9999999 );
		add_filter('bbp_new_reply_pre_extras', array(&$this, 'forum_restrict'), 9999999 );
		
	}
	
	/***
	***	@bbPress
	***/
	function forum_restrict( $forum_id ) {
		global $ultimatemember, $um_profile_completeness;
		if ( !is_user_logged_in() || is_admin() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( $result['progress'] < $result['req_progress'] ) {

			if ( $result['prevent_bb'] ) {
				exit( wp_redirect( add_query_arg('notice','incomplete_forum',um_edit_profile_url()) ) );
			}
			
		}
	}
	
	/***
	***	@COMMENTS
	***/
	function wp_insert_comment( $cid ) {
		global $ultimatemember, $um_profile_completeness;
		if ( !is_user_logged_in() || is_admin() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( $result['progress'] < $result['req_progress'] ) {

			if ( $result['prevent_comment'] ) {
				wp_delete_comment( $cid, true );
				exit( wp_redirect( add_query_arg('notice','incomplete_comment',um_edit_profile_url()) ) );
			}
			
		}
	}
	
	/***
	***	@ACCESS / PROFILES
	***/
	function template_redirect() {
		global $ultimatemember, $um_profile_completeness;
		if ( !is_user_logged_in() || is_admin() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( $result['progress'] < $result['req_progress'] ) {
			
			// Global
			if ( $result['prevent_browse'] && !isset( $_REQUEST['um_action'] ) ) {
				exit( wp_redirect( add_query_arg('notice','incomplete_access',um_edit_profile_url()) ) );
			}
			
			// Profile view
			if ( $result['prevent_profileview'] ) {
				if ( um_get_requested_user() && um_get_requested_user() != get_current_user_id() ) {
					exit( wp_redirect( add_query_arg('notice','incomplete_view',um_edit_profile_url()) ) );
				}
			}
			
		}
		
	}
	
}