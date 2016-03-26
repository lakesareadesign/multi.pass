<?php
	
	/***
	***	@bbpress user capabilities
	***/
	add_filter('bbp_map_meta_caps', 'um_bbpress_meta_caps_filter', 10, 4);
	function um_bbpress_meta_caps_filter( $caps, $cap, $user_id, $args ){
		
		global $ultimatemember, $um_bbpress;

		$role = get_user_meta( $user_id, 'role', true );

		$role_data = $ultimatemember->query->role_data( $role );
		
		switch ( $cap ) {
			
			case 'publish_topics':
			
				if ( !um_user_can('can_create_topics') )
					$caps[] = 'do_not_allow';
				
				if ( !$um_bbpress->can_do_topic() ) {
					$caps[] = 'do_not_allow';
				}
				
				$who_can_make_topics = get_post_meta( get_the_ID(), '_um_bbpress_can_topic', true );
				if ( is_array($who_can_make_topics) && !in_array( $role, $who_can_make_topics ) )
					$caps[] = 'do_not_allow';
				
				break;
				
			case 'publish_replies':
			
				if ( !um_user_can('can_create_replies') )
					$caps[] = 'do_not_allow';
				
				if ( bbp_is_topic ( get_the_ID() ) ) {
					$forum_id = bbp_get_topic_forum_id( get_the_ID() );
				} else {
					$forum_id = get_the_ID();
				}
				
				$who_can_make_replies = get_post_meta( $forum_id, '_um_bbpress_can_reply', true );
				if ( is_array($who_can_make_replies) && !in_array( $role, $who_can_make_replies ) )
					$caps[] = 'do_not_allow';
				
				break;
				
		}

		return $caps;
	}