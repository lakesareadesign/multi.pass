<?php
	
	/***
	***	@inherit topic access control from their parent "forums"
	***/
	add_filter('um_access_control_for_parent_posts', 'um_bbpress_access_control_for_topics');
	function um_bbpress_access_control_for_topics( $post_id ) {
		$is_forum = bbp_get_topic_forum_id( $post_id );
		if ( $is_forum )
			return $is_forum;
		return $post_id;
	}
	
	/***
	***	@add a class to help us hide it from forums list
	***/
	add_filter('bbp_get_forum_class', 'um_bbpress_add_class_to_locked_forum_or_topic', 888, 2);
	add_filter('bbp_get_topic_class', 'um_bbpress_add_class_to_locked_forum_or_topic', 888, 2);
	function um_bbpress_add_class_to_locked_forum_or_topic( $classes, $post_id ) {
		global $ultimatemember;
		
		$args = $ultimatemember->access->get_meta( $post_id );
		extract($args);

		if ( !isset( $args['custom_access_settings'] ) || $args['custom_access_settings'] == 0 ) {
			return $classes;
		}

		$restricted = false;

		if ( !isset( $accessible ) ) return $classes;

		switch( $accessible ) {
			
			case 0:	

				break;
			
			case 1:
			
				if ( is_user_logged_in() )
					$restricted = true;

				break;
				
			case 2:
				
				if ( !is_user_logged_in() ){
					$restricted = true;
				}
				
				$role = get_user_meta( get_current_user_id(), 'role', true );
				
				if ( is_user_logged_in() && isset( $access_roles ) && !empty( $access_roles ) ){
					if ( !in_array( $role, unserialize( $access_roles ) ) ) {
						$restricted = true;
					}
				}
				
				break;
				
		}
		
		if ( $restricted ) {
			$classes[] = 'um-bbpress-restricted';
		}
		
		return $classes;
	}