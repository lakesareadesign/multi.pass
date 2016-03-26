<?php

	/***
	***	@follow user
	***/
	add_action('wp_ajax_nopriv_um_followers_follow', 'um_followers_follow');
	add_action('wp_ajax_um_followers_follow', 'um_followers_follow');
	function um_followers_follow(){
		global $ultimatemember, $um_followers;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( !is_user_logged_in() ) die(0);
		if ( !isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( !is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( !$um_followers->api->can_follow( $user_id1, $user_id2 ) ) die(0);
		if ( $um_followers->api->followed( $user_id1, $user_id2 ) ) die(0);
		
		$um_followers->api->add( $user_id1, $user_id2 );
		
		$output['btn'] = $um_followers->api->follow_button( $user_id1, $user_id2 );
		
		do_action('um_followers_after_user_follow', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}
	
	/***
	***	@unfollow user
	***/
	add_action('wp_ajax_nopriv_um_followers_unfollow', 'um_followers_unfollow');
	add_action('wp_ajax_um_followers_unfollow', 'um_followers_unfollow');
	function um_followers_unfollow(){
		global $ultimatemember, $um_followers;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( !is_user_logged_in() ) die(0);
		if ( !isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( !is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( !$um_followers->api->can_follow( $user_id1, $user_id2 ) ) die(0);
		if ( !$um_followers->api->followed( $user_id1, $user_id2 ) ) die(0);
		
		$um_followers->api->remove( $user_id1, $user_id2 );
		
		$output['btn'] = $um_followers->api->follow_button( $user_id1, $user_id2 );
		
		do_action('um_followers_after_user_unfollow', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}