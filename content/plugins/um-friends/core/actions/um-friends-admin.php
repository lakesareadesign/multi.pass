<?php

	/***
	***	@delete multiselect fields
	***/
	add_action('um_admin_before_saving_role_meta', 'um_friends_multi_choice_keys');
	function um_friends_multi_choice_keys( $post_id ){
		delete_post_meta( $post_id, '_um_can_friend_roles' );
	}

	/***
	***	@add options for friends
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_friends_add_role_metabox');
	function um_friends_add_role_metabox( $action ){

		global $ultimatemember;

		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-friends{" . um_friends_path . "}", __('Friends','um-friends'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');

	}

	/***
	***	@When user is removed all their data should be removed
	***/
	add_action('um_delete_user', 'um_friends_delete_user_data');
	function um_friends_delete_user_data( $user_id ) {
		global $wpdb;
		$wpdb->delete( $wpdb->prefix . "um_friends" , array( 'user_id1' => $user_id ) );
		$wpdb->delete( $wpdb->prefix . "um_friends" , array( 'user_id2' => $user_id ) );
	}

	/***
	***	@sort by highest rated
	***/
	add_action('um_admin_directory_sort_users_select', 'um_friends_sort_user_option');
	function um_friends_sort_user_option( $option ) {
		global $ultimatemember; ?>

		<option value="most_friends" <?php selected('most_friends', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Most friends', 'um-friends'); ?></option>
		<option value="least_friends" <?php selected('least_friends', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Least friends', 'um-friends'); ?></option>

		<?php
	}
