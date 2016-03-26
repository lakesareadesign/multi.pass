<?php

	/***
	***	@mark a notice as seen
	***/
	add_action('wp_ajax_nopriv_um_notices_mark_notice_seen', 'um_notices_mark_notice_seen');
	add_action('wp_ajax_um_notices_mark_notice_seen', 'um_notices_mark_notice_seen');
	function um_notices_mark_notice_seen(){
		global $ultimatemember;
		extract($_REQUEST);
		
		if ( $user_id > 0 && $notice_id > 0 ) { // member
		
			$users = get_post_meta( $notice_id, '_users', true );
			
			$users[] = $user_id;
			
			update_post_meta( $notice_id, '_users', $users );
			
		}
		
		// register this notice in a cookie anyway
		setcookie('um_notice_seen_' . $notice_id, true, time() + (86400 * 7), '/');
		
		die(0);
	}
	
	/***
	***	@flush a notice
	***/
	add_action('um_admin_do_action__flush_notice', 'um_admin_do_action__flush_notice');
	function um_admin_do_action__flush_notice( $action ){
		global $ultimatemember;
		if ( !is_admin() || !current_user_can('manage_options') ) die();
		delete_post_meta( $_REQUEST['notice_id'], '_users' );
		$url = remove_query_arg('um_adm_action', $ultimatemember->permalinks->get_current_url() );
		exit( wp_redirect($url) );
	}