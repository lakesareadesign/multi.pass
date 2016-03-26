<?php

	/***
	***	@award points on connecting with social network
	***/
	add_action('um_social_login_after_connect', 'um_mycred_when_user_connects_social_network');
	function um_mycred_when_user_connects_social_network( $provider, $user_id ) {
		global $um_mycred;
		$um_mycred->add( $user_id, 'mycred_' . $provider );
	}

	/***
	***	@award points on putting his profile photo
	***/
	add_action('um_before_upload_db_meta_profile_photo', 'um_mycred_when_user_upload_photo');
	function um_mycred_when_user_upload_photo( $user_id ) {
		global $um_mycred;
		$um_mycred->add( $user_id, 'mycred_photo' );
	}
	
	/***
	***	@award points on putting his cover photo
	***/
	add_action('um_before_upload_db_meta_cover_photo', 'um_mycred_when_user_upload_cover');
	function um_mycred_when_user_upload_cover( $user_id ) {
		global $um_mycred;
		$um_mycred->add( $user_id, 'mycred_cover' );
	}
	
	/***
	***	@award points on approval
	***/
	add_action('um_after_user_is_approved', 'um_mycred_award_points_signup', 20 );
	function um_mycred_award_points_signup( $user_id ){
		global $um_mycred;
		$um_mycred->add( $user_id, 'mycred_register' );
	}
	
	/***
	***	@award points on login
	***/
	add_action('um_on_login_before_redirect', 'um_mycred_award_points_login', 20 );
	function um_mycred_award_points_login( $user_id ){
		global $um_mycred;
		$um_mycred->add( $user_id, 'mycred_login' );
	}
	
	/***
	***	@pre - put pending points balance
	***/
	add_action('um_user_pre_updating_profile', 'um_mycred_award_points_edit', 20 );
	function um_mycred_award_points_edit( $changes ){
		global $um_mycred;
		
		$mycred = um_get_option('mycred_editprofile');
		if ( !$mycred ) return;

		foreach( $changes as $k => $v ) {
			if ( um_user($k) != $v ) {
				$changed[$k] = $v;
			}
		}
		
		if ( isset( $changed['mycred_default'] ) )
			unset( $changed['mycred_default'] );

		if ( isset( $changed ) && !empty( $changed ) ) {

			$user_id = um_user('ID');
			$um_mycred->pending_balance = $um_mycred->add_pending( $user_id, 'mycred_editprofile' );

		}

	}
	
	/***
	***	@award on save profile
	***/
	add_action('um_user_after_updating_profile', 'um_mycred_award_points_editsave', 20 );
	function um_mycred_award_points_editsave( $changes ){
		global $um_mycred;
		if ( isset( $um_mycred->pending_balance ) && !empty( $um_mycred->pending_balance ) ) {
			//mycred_add( 'mycred_editprofile', um_user('ID'), $um_mycred->pending_balance, 'Earned %plural% via Ultimate Member (mycred_editprofile)' );
			$um_mycred->add( um_user('ID'), 'mycred_editprofile' );
		}	
	}