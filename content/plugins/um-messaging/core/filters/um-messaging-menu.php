<?php

	/***
	***	@unread messages count in menu
	***/
	add_filter('um_allowed_user_tags_patterns', 'um_messaging_allowed_user_tags');
	function um_messaging_allowed_user_tags( $tags ) {
		$tags[] = '{new_messages}';
		return $tags;
	}
	
	/***
	***	@display unread messages count in menu
	***/
	add_filter('um_profile_tag_hook__new_messages', 'um_profile_tag_hook__new_messages', 10, 2);
	function um_profile_tag_hook__new_messages( $value, $user_id ) {
		global $um_messaging;
		$count = $um_messaging->api->get_unread_count( $user_id );
		return '<span class="um-message-unreaditems count-'. $count . '">' . $count . '</span>';
	}