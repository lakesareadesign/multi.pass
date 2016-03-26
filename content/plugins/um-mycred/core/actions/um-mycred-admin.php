<?php

	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_mycred_add_role_metabox');
	function um_mycred_add_role_metabox( $action ){

		global $ultimatemember;

		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-mycred{" . um_mycred_path . "}", __('myCRED','um-mycred'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');

	}

	/***
	***	@sort by highest rated
	***/
	add_action('um_admin_directory_sort_users_select', 'um_mycred_sort_user_option');
	function um_mycred_sort_user_option( $option ) {
		global $ultimatemember; ?>

		<option value="most_mycred_points" <?php selected('most_mycred_points', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Most MyCRED Points', 'um-mycred'); ?></option>
		<option value="least_mycred_points" <?php selected('least_mycred_points', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Least MyCRED Points', 'um-mycred'); ?></option>

		<?php
	}
