<?php

	/***
	***	@Link review owner with UM profile
	***/
	add_filter( 'comment_author', 'um_woocommerce_comment_author', 100, 2 );
	function um_woocommerce_comment_author( $author, $comment_ID ) {
		global $comment, $ultimatemember;
		
		$comment = get_comment( $comment_ID );
		if ( isset( $comment->user_id ) && !empty( $comment->user_id ) ) {
			
			if ( isset( $ultimatemember->user->cached_user[ $comment->user_id ] ) && $ultimatemember->user->cached_user[ $comment->user_id ] ) {
				
				$return = '<a href="'. $ultimatemember->user->cached_user[$comment->user_id]['url'] . '">' . $ultimatemember->user->cached_user[$comment->user_id]['name'] . '</a>';
			
			} else {
				
				um_fetch_user($comment->user_id);
				$ultimatemember->user->cached_user[ $comment->user_id ] = array('url' => um_user_profile_url(), 'name' => um_user('display_name') );
				$return = '<a href="'. $ultimatemember->user->cached_user[$comment->user_id]['url'] . '">' . $ultimatemember->user->cached_user[$comment->user_id]['name'] . '</a>';
				um_reset_user();
				
			}
			
		}
		return $return;
	}