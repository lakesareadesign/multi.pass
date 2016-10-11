<?php

	/***
	***	@confirm friendship
	***/
	add_action('wp_ajax_nopriv_um_friends_approve', 'um_friends_approve');
	add_action('wp_ajax_um_friends_approve', 'um_friends_approve');
	function um_friends_approve(){
		global $ultimatemember, $um_friends;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( ! is_user_logged_in() ) die(0);
		if ( ! isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( ! is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( ! $um_friends->api->can_friend( $user_id1, $user_id2 ) ) die(0);
		if ( $um_friends->api->is_friend( $user_id1, $user_id2 ) ) die(0);
		
		$um_friends->api->approve( $user_id1, $user_id2 );
		
		$output['btn'] = $um_friends->api->friend_button( $user_id1, $user_id2 );
		
		do_action('um_friends_after_user_friend', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}

	/***
	***	@friend a user
	***/
	add_action('wp_ajax_nopriv_um_friends_add', 'um_friends_add');
	add_action('wp_ajax_um_friends_add', 'um_friends_add');
	function um_friends_add(){
		global $ultimatemember, $um_friends;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( ! is_user_logged_in() ) die(0);
		if ( ! isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( ! is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( ! $um_friends->api->can_friend( $user_id1, $user_id2 ) ) die(0);
		if ( $um_friends->api->is_friend( $user_id1, $user_id2 ) ) die(0);
		
		$um_friends->api->add( $user_id1, $user_id2 );
		
		$output['btn'] = $um_friends->api->friend_button( $user_id1, $user_id2 ); // following user id , current user id
		
		do_action('um_friends_after_user_friend_request', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}
	
	/***
	***	@unfriend a user
	***/
	add_action('wp_ajax_nopriv_um_friends_unfriend', 'um_friends_unfriend');
	add_action('wp_ajax_um_friends_unfriend', 'um_friends_unfriend');
	function um_friends_unfriend(){
		global $ultimatemember, $um_friends;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( ! is_user_logged_in() ) die(0);
		if ( ! isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( ! is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( ! $um_friends->api->can_friend( $user_id1, $user_id2 ) ) die(0);

		$um_friends->api->remove( $user_id1, $user_id2 );
		
		$output['btn'] = $um_friends->api->friend_button( $user_id1, $user_id2 );
		
		do_action('um_friends_after_user_unfriend', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}
	
	/***
	***	@to cancel pending request
	***/
	add_action('wp_ajax_nopriv_um_friends_cancel_request', 'um_friends_cancel_request');
	add_action('wp_ajax_um_friends_cancel_request', 'um_friends_cancel_request');
	function um_friends_cancel_request(){
		global $ultimatemember, $um_friends;
		extract($_POST);
		$output = '';
		
		// Checks
		if ( ! is_user_logged_in() ) die(0);
		if ( ! isset( $user_id1 ) || !isset( $user_id2 ) ) die(0);
		if ( ! is_numeric( $user_id1 ) || !is_numeric( $user_id2 ) ) die(0);
		if ( ! $um_friends->api->can_friend( $user_id1, $user_id2 ) ) die(0);

		$um_friends->api->cancel( $user_id1, $user_id2 );
		
		$output['btn'] = $um_friends->api->friend_button( $user_id1, $user_id2 );
		
		do_action('um_friends_after_user_cancel_request', $user_id1, $user_id2 );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}