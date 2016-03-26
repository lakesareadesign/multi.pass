<?php

	/***
	***	@allow hashtags in comments
	***/
	add_filter('um_activity_comment_content_new', 'um_activity_comment_content_new', 10, 2 );
	function um_activity_comment_content_new( $content, $post_id ) {
		global $um_activity;
		$um_activity->api->hashtagit( $post_id, $content, true );
		return $content;
	}