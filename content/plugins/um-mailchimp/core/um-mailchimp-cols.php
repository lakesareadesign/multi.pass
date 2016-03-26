<?php

class UM_Mailchimp_Cols {

	function __construct() {
		
		add_filter('manage_edit-um_mailchimp_columns', array(&$this, 'manage_edit_um_mailchimp_columns') );
		add_action('manage_um_mailchimp_posts_custom_column', array(&$this, 'manage_um_mailchimp_posts_custom_column'), 10, 3);
		
	}
	
	/***
	***	@Custom columns
	***/
	function manage_edit_um_mailchimp_columns($columns) {
	
		$admin = new UM_Admin_Metabox();
		
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = __('Title','um-mailchimp');
		$new_columns['status'] = __('Status','um-mailchimp');
		$new_columns['reg_status'] = __('Automatic Signup','um-mailchimp');
		$new_columns['list_id'] = __('List ID','um-mailchimp');
		$new_columns['subscribers'] = __('Subscribers','um-mailchimp');
		$new_columns['available_to'] = __('Roles','um-mailchimp');
		
		return $new_columns;
		
	}
	
	/***
	***	@Display cusom columns
	***/
	function manage_um_mailchimp_posts_custom_column($column_name, $id) {
		global $wpdb, $ultimatemember, $um_mailchimp;
		
		switch ($column_name) {
			
			case 'status':
				$status = get_post_meta( $id, '_um_status', true );
				if ( $status ) {
					echo '<span class="um-adm-ico um-admin-tipsy-n" title="'.__('Active','um-mailchimp').'"><i class="um-faicon-check"></i></span>';
				} else {
					echo '<span class="um-adm-ico inactive um-admin-tipsy-n" title="'.__('Inactive','um-mailchimp').'"><i class="um-faicon-remove"></i></span>';
				}
				break;
				
			case 'reg_status':
				$status = get_post_meta( $id, '_um_reg_status', true );
				if ( $status ) {
					echo '<span class="um-adm-ico um-admin-tipsy-n" title="'.__('Active','um-mailchimp').'"><i class="um-faicon-check"></i></span>';
				} else {
					echo __('Manual','um-mailchimp');
				}
				break;
				
			case 'list_id':
				$list_id = get_post_meta( $id, '_um_list', true );
				echo $list_id;
				break;
				
			case 'subscribers':
				$list_id = get_post_meta( $id, '_um_list', true );
				echo $um_mailchimp->api->get_list_member_count( $list_id );
				break;
				
			case 'available_to':
				$roles = get_post_meta( $id, '_um_roles', true );
				$res = __('Everyone','um-mailchimp');
				if ( $roles && is_array( $roles ) ) {
					$res = '';
					foreach( $roles as $role ) {
						$data = $ultimatemember->query->role_data($role);
						$res .= $data['role_name'];
					}
				}
				echo $res;
				break;
				
		}
		
	}
	
}