<?php

	/***
	***	@put users to sync in next update
	***/
	add_action('um_user_after_updating_profile', 'um_mailchimp_sync_user_update' );
	function um_mailchimp_sync_user_update( $changes ) {
		global $um_mailchimp;
		
		$user_id = um_user('ID');
		
		$user_lists = get_user_meta( $user_id, '_mylists', true );
		
		if ( $user_lists ) {
			
			$um_mailchimp->api->user_id = $user_id;
			
			$lists = $um_mailchimp->api->has_lists();
			if ( $lists ) {
				
				delete_option( "um_cache_userdata_{$user_id}" );

				foreach( $lists as $post_id ) { $list = $um_mailchimp->api->fetch_list($post_id);
					if ( isset( $user_lists[$list['id']] ) ) {
						$um_mailchimp->api->update( $list['id'], $list['merge_vars'] );
					}
				}
				
			}
			
		}
		
	}
	
	/***
	***	@hook after registering users
	***/
	add_action('um_post_registration_global_hook', 'um_mailchimp_add_user_after_signup', 10, 2);
	function um_mailchimp_add_user_after_signup( $user_id, $args ) {
		global $um_mailchimp;
		
		if ( !isset( $_POST['um-mailchimp'] ) ) return;
		
		$um_mailchimp->api->user_id = $user_id;
		
		$lists = $um_mailchimp->api->has_lists();
		
		if ( $lists ) {
			
			delete_option( "um_cache_userdata_{$user_id}" );
			
			foreach( $lists as $post_id ) { $list = $um_mailchimp->api->fetch_list($post_id);
				if ( isset ( $_POST['um-mailchimp'][ $list['id'] ] ) ) {

					if ( $_POST['um-mailchimp'][ $list['id'] ] != 'already_subscribed' ) {
						$um_mailchimp->api->subscribe( $list['id'], $list['merge_vars'] );
					}
					
				}
			}
			
		}
		
	}
	
	/***
	***	@hook in account update to subscribe/unsubscribe users
	***/
	add_action('um_post_account_update', 'um_mailchimp_account_update');
	function um_mailchimp_account_update() {
		global $um_mailchimp;
		
		$user_id = um_user('ID');
		
		$lists = $um_mailchimp->api->has_lists();
		$user_lists = get_user_meta( $user_id, '_mylists', true );
		
		if ( $lists ) {
			
			delete_option( "um_cache_userdata_{$user_id}" );
			
			foreach( $lists as $post_id ) { $list = $um_mailchimp->api->fetch_list($post_id);
				if ( isset ( $_POST['um-mailchimp'][ $list['id'] ] ) ) {

					if ( $_POST['um-mailchimp'][ $list['id'] ] != 'already_subscribed' ) {
						$um_mailchimp->api->subscribe( $list['id'], $list['merge_vars'] );
					}
					
				} else {

					if ( isset( $user_lists[$list['id']] ) ) { // must be a subscriber to unsubscribe
						$um_mailchimp->api->unsubscribe( $list['id'] );
					}
					
				}
			}
			
			$um_mailchimp->api->user_id = $user_id;
			foreach( $lists as $post_id ) { $list = $um_mailchimp->api->fetch_list($post_id);
				if ( isset( $user_lists[$list['id']] ) ) {
					$um_mailchimp->api->update( $list['id'], $list['merge_vars'] );
				}
			}
			
		}

	}