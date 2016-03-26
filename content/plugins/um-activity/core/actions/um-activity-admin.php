<?php

	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_activity_add_role_metabox');
	function um_activity_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-activity{" . um_activity_path . "}", __('Social Activity','um-activity'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}
	
	/***
	***	@Clear a wall post report
	***/
	add_action('um_admin_do_action__wall_report', 'um_admin_do_action__wall_report');
	function um_admin_do_action__wall_report( $action ){
		global $ultimatemember, $um_activity;
		if ( !is_admin() || !current_user_can( 'edit_posts' ) ) die();
		
		if ( !isset($_REQUEST['post_id']) || !is_numeric( $_REQUEST['post_id'] ) ) die();

		if ( !$um_activity->api->reported( $_REQUEST['post_id'] ) ) die();
		
		$post_id = (int) $_REQUEST['post_id'];
		
		delete_post_meta( $post_id, '_reported' );
		delete_post_meta( $post_id, '_reported_by' );
		
		$count = (int)get_option('um_activity_flagged');
		if ( $count < 1 ) $count = 1;
		update_option( 'um_activity_flagged', absint( $count - 1 ) );
		
		exit( wp_redirect( admin_url( 'edit.php?post_type=um_activity' ) ) );

	}