<?php

	/***
	***	@fallback for empty roles
	***/
	add_action('um_admin_before_saving_role_meta', 'um_reviews_reset_roles');
	function um_reviews_reset_roles( $post_id ) {
		delete_post_meta( $post_id, '_um_can_review_roles');
	}
	
	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_reviews_add_role_metabox');
	function um_reviews_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-reviews{" . um_reviews_path . "}", __('User Reviews','um-reviews'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}
	
	/***
	***	@sort by highest rated
	***/
	add_action('um_admin_directory_sort_users_select', 'um_reviews_sort_user_option');
	function um_reviews_sort_user_option( $option ) {
		global $ultimatemember; ?>
		
		<option value="top_rated" <?php selected('top_rated', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Highest rated first','um-reviews'); ?></option>
		
		<?php
	}