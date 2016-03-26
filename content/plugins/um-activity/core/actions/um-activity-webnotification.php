<?php

	/***
	***	@send a web notification after new post comment
	***/
	add_action('um_activity_after_wall_comment_published','um_activity_web_notification_comment', 90, 4 );
	function um_activity_web_notification_comment( $comment_id, $comment_parent, $post_id, $user_id ) {
		if ( $comment_parent > 0 ) return false;
		if ( !defined('um_notifications_version') ) return false;
		global $um_notifications, $um_activity;
		
		$author = $um_activity->api->get_author( $post_id );
		if ( $author == $user_id ) return false;
		
		um_fetch_user( $user_id );
			
		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
		$vars['member'] = um_user('display_name');

		um_fetch_user( $author );
		
		$url = $um_activity->api->get_permalink( $post_id );
		
		$vars['notification_uri'] = $url;
		
		$um_notifications->api->store_notification( $author, 'new_wall_comment', $vars );
	}
		
	/***
	***	@send a web notification after new post like
	***/
	add_action('um_activity_after_wall_post_liked','um_activity_web_notification_likepost', 90, 2 );
	function um_activity_web_notification_likepost( $post_id, $user_id ) {
		if ( !defined('um_notifications_version') ) return false;
		global $um_notifications, $um_activity;
		
		$author = $um_activity->api->get_author( $post_id );
		if ( $author == $user_id ) return false;
		
		um_fetch_user( $user_id );
			
		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
		$vars['member'] = um_user('display_name');

		um_fetch_user( $author );
		
		$url = $um_activity->api->get_permalink( $post_id );
		
		$vars['notification_uri'] = $url;
		
		$um_notifications->api->store_notification( $author, 'new_post_like', $vars );
	}
	
	/***
	***	@send a web notification after new post
	***/
	add_action('um_activity_after_wall_post_published','um_activity_web_notification', 90, 3 );
	function um_activity_web_notification( $post_id, $writer, $wall ) {
		if ( !defined('um_notifications_version') ) return false;
		if ( $writer == $wall ) return false;
		global $um_notifications, $um_activity;
		
		um_fetch_user( $writer );
			
		$vars['photo'] = um_get_avatar_url( get_avatar( $writer, 40 ) );
		$vars['member'] = um_user('display_name');

		um_fetch_user( $wall );
		
		$url = $um_activity->api->get_permalink( $post_id );
		
		$vars['notification_uri'] = $url;
		
		$um_notifications->api->store_notification( $wall, 'new_wall_post', $vars );
	}
	
	/***
	***	@Adds a notification type
	***/
	add_filter('um_notifications_core_log_types', 'um_activity_add_notification_type', 200 );
	function um_activity_add_notification_type( $array ) {
		
		$array['new_wall_post'] = array(
			'title' => __('User get a new wall post','um-activity'),
			'template' => '<strong>{member}</strong> has posted on your wall.',
			'account_desc' => __('When someone publish a post on my wall','um-activity'),
		);
		
		$array['new_wall_comment'] = array(
			'title' => __('User get a new wall comment','um-activity'),
			'template' => '<strong>{member}</strong> has commented on your wall post.',
			'account_desc' => __('When someone comments on your post','um-activity'),
		);
		
		$array['new_post_like'] = array(
			'title' => __('User get a new post like','um-activity'),
			'template' => '<strong>{member}</strong> likes your wall post.',
			'account_desc' => __('When someone likes your post','um-activity'),
		);
		
		$array['new_mention'] = array(
			'title' => __('User get a new mention','um-activity'),
			'template' => '<strong>{member}</strong> just mentioned you.',
			'account_desc' => __('When someone mentions me','um-activity'),
		);
		
		return $array;
	}
	
	/***
	***	@Adds a notification icon
	***/
	add_filter('um_notifications_get_icon', 'um_activity_add_notification_icon', 10, 2 );
	function um_activity_add_notification_icon( $output, $type ) {
		
		if ( $type == 'new_wall_post' ) {
			$output = '<i class="um-icon-compose" style="color: #3ba1da"></i>';
		}
		
		if ( $type == 'new_wall_comment' ) {
			$output = '<i class="um-icon-chatbox" style="color: #00b56c"></i>';
		}
		
		if ( $type == 'new_post_like' ) {
			$output = '<i class="um-faicon-thumbs-up" style="color: #1c6dc9"></i>';
		}
		
		if ( $type == 'new_mention' ) {
			$output = '<i class="um-icon-ios-contact" style="color: #00c9ae"></i>';
		}
		
		return $output;
	}