<?php

	/***
	***	@load user's topics
	***/
	add_action('um_ajax_load_posts__um_bbpress_load_topics', 'um_bbpress_load_topics');
	function um_bbpress_load_topics( $args ) {
		global $ultimatemember;
		
		$array = explode(',', $args );
		$post_type = $array[0];
		$posts_per_page = $array[1];
		$offset = $array[2];
		$author = $array[3];
		
		$offset_n = $posts_per_page + $offset;
		$modified_args = "$post_type,$posts_per_page,$offset_n,$author";
		
		$loop = $ultimatemember->query->make("post_type=$post_type&posts_per_page=$posts_per_page&offset=$offset&author=$author");
		
		require um_bbpress_path . 'templates/topics-single.php';
		
	}
	
	/***
	***	@load user's replies
	***/
	add_action('um_ajax_load_posts__um_bbpress_load_replies', 'um_bbpress_load_replies');
	function um_bbpress_load_replies( $args ) {
		global $ultimatemember;
		
		$array = explode(',', $args );
		$post_type = $array[0];
		$posts_per_page = $array[1];
		$offset = $array[2];
		$author = $array[3];
		
		$offset_n = $posts_per_page + $offset;
		$modified_args = "$post_type,$posts_per_page,$offset_n,$author";
		
		$loop = $ultimatemember->query->make("post_type=$post_type&posts_per_page=$posts_per_page&offset=$offset&author=$author");
		
		require um_bbpress_path . 'templates/replies-single.php';
		
	}
	
	/***
	***	@remove a user's favorite topic
	***/
	add_action('um_run_ajax_function__um_bbpress_remove_user_favorite', 'um_bbpress_remove_user_favorite');
	function um_bbpress_remove_user_favorite( $args ) {
		extract( $args );
		
		if ( !um_current_user_can('edit', $user_id ) ) die();

		bbp_remove_user_favorite( $user_id, $arguments );

		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}
	
	/***
	***	@remove a user's subscribed topic
	***/
	add_action('um_run_ajax_function__um_bbpress_remove_user_subscription', 'um_bbpress_remove_user_subscription');
	function um_bbpress_remove_user_subscription( $args ) {
		extract( $args );
		
		if ( !um_current_user_can('edit', $user_id ) ) die();

		bbp_remove_user_subscription( $user_id, $arguments );

		if(is_array($output)){ print_r($output); }else{ echo $output; } die;
	}