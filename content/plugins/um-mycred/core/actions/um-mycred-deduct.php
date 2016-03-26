<?php

	/***
	***	@deduct points on connecting with social network
	***/
	add_action('um_social_login_after_disconnect', 'um_mycred_when_user_disconnects_social_network');
	function um_mycred_when_user_disconnects_social_network( $provider, $user_id ) {
		global $um_mycred;
		$um_mycred->deduct( $user_id, 'mycred_d_' . $provider );
	}
	
	/***
	***	@deduct points when photo is removed
	***/
	add_action('um_after_remove_profile_photo', 'um_mycred_when_user_remove_photo');
	function um_mycred_when_user_remove_photo( $user_id ) {
		global $um_mycred;
		$um_mycred->deduct( $user_id, 'mycred_d_photo' );
	}
	
	/***
	***	@deduct points when cover is removed
	***/
	add_action('um_after_remove_cover_photo', 'um_mycred_when_user_remove_cover');
	function um_mycred_when_user_remove_cover( $user_id ) {
		global $um_mycred;
		$um_mycred->deduct( $user_id, 'mycred_d_cover' );
	}