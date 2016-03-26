<?php

class UM_Notifications_Main_API {

	/***
	***	@Did user enable this web notification?
	***/
	function user_enabled( $key, $user_id ) {
		if ( !um_get_option('log_'.$key ) ) {
			return false;
		}
		$prefs = get_user_meta( $user_id, '_notifications_prefs', true );
		if ( $prefs && isset($prefs[$key]) && !$prefs[$key] ) {
			return false;
		}
		return true;
	}

	/***
	***	@Register notification types
	***/
	function get_log_types() {

		$array['upgrade_role'] = array(
			'title' => __('Role upgrade','um-notifications'),
			'template' => 'Your membership level has been changed from <strong>{role_pre}</strong> to <strong>{role_post}</strong>',
			'account_desc' => __('When my membership level is changed','um-notifications'),
		);

		$array['comment_reply'] = array(
			'title' => __('New comment reply','um-notifications'),
			'template' => '<strong>{member}</strong> has replied to one of your comments.',
			'account_desc' => __('When a member replies to one of my comments','um-notifications'),
		);

		$array['user_comment'] = array(
			'title' => __('New user comment','um-notifications'),
			'template' => '<strong>{member}</strong> has commented on your <strong>post</strong>. <span class="b1">"{comment_excerpt}"</span>',
			'account_desc' => __('When a member comments on my posts','um-notifications'),
		);

		$array['guest_comment'] = array(
			'title' => __('New guest comment','um-notifications'),
			'template' => 'A guest has commented on your <strong>post</strong>. <span class="b1">"{comment_excerpt}"</span>',
			'account_desc' => __('When a guest comments on my posts','um-notifications'),
		);

		$array['profile_view'] = array(
			'title' => __('User view profile','um-notifications'),
			'template' => '<strong>{member}</strong> has viewed your profile.',
			'account_desc' => __('When a member views my profile','um-notifications'),
		);

		$array['profile_view_guest'] = array(
			'title' => __('Guest view profile','um-notifications'),
			'template' => 'A guest has viewed your profile.',
			'account_desc' => __('When a guest views my profile','um-notifications'),
		);

		$array['bbpress_user_reply'] = array(
			'title' => __('User leaves a reply to bbpress topic','um-notifications'),
			'template' => '<strong>{member}</strong> has <strong>replied</strong> to a topic you started on the forum.',
			'account_desc' => __('When a member replies to one of my topics','um-notifications'),
		);

		$array['bbpress_guest_reply'] = array(
			'title' => __('Guest leaves a reply to bbpress topic','um-notifications'),
			'template' => 'A guest has <strong>replied</strong> to a topic you started on the forum.',
			'account_desc' => __('When a guest replies to one of my topics','um-notifications'),
		);

		if ( defined('um_reviews_version') ) {
		$array['user_review'] = array(
			'title' => __('New user review','um-notifications'),
			'template' => '<strong>{member}</strong> has left you a new review. <span class="b1">"{review_excerpt}"</span>',
			'account_desc' => __('When someone leaves me a review','um-notifications'),
		);
		}

		if ( defined('um_mycred_version') ) {
		$array['mycred_award'] = array(
			'title' => __('User awarded points for action','um-notifications'),
			'template' => 'You have received <strong>{mycred_points}</strong> for <strong>{mycred_task}</strong>',
			'account_desc' => __('When I receive points by completing an action','um-notifications'),
		);

		$array['mycred_points_sent'] = array(
			'title' => __('User receives points from another person','um-notifications'),
			'template' => 'You have just got <strong>{mycred_points}</strong> from <strong>{mycred_sender}</strong>',
			'account_desc' => __('When I receive points balance from another member','um-notifications'),
		);
		}

		$array = apply_filters('um_notifications_core_log_types', $array );

		return $array;

	}

	/***
	***	@Get unread count by user ID
	***/
	function unread_count( $user_id = 0 ) {
		global $wpdb, $ultimatemember;

		$user_id = ( $user_id > 0 ) ? $user_id : get_current_user_id();

		$table_name = $wpdb->prefix . "um_notifications";
		$results = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT id FROM {$table_name} WHERE user = %d AND status='unread'",
							$user_id
						)
					);

		if ( $wpdb->num_rows == 0 ) {
			return 0;
		} else {
			return $wpdb->num_rows;
		}
	}

	/***
	***	@Deletes a notification by its ID
	***/
	function delete_log( $notification_id ) {
		global $wpdb;
		if ( !is_user_logged_in() ) return;
		$user_id = get_current_user_id();
		$table_name = $wpdb->prefix . "um_notifications";
		$wpdb->delete( $table_name, array('id' => $notification_id) );
	}

	/***
	***	@Gets icon for notification
	***/
	function get_icon( $type ) {
		$output = null;
		switch( $type ) {

			default:
				$output = apply_filters('um_notifications_get_icon', $output, $type );
				break;

			case 'user_comment':
			case 'guest_comment':
				$output = '<i class="um-faicon-comment" style="color: #DB6CD2"></i>';
				break;

			case 'user_review':
				$output = '<i class="um-faicon-star" style="color: #FFD700"></i>';
				break;

			case 'profile_view':
			case 'profile_view_guest':
				$output = '<i class="um-faicon-eye" style="color: #6CB9DB"></i>';
				break;

			case 'bbpress_user_reply':
			case 'bbpress_guest_reply':
				$output = '<i class="um-faicon-comments" style="color: #67E264"></i>';
				break;

			case 'mycred_award':
			case 'mycred_points_sent':
				$output = '<i class="um-faicon-plus-circle" style="color: #DFB250"></i>';
				break;

			case 'upgrade_role':
				$output = '<i class="um-faicon-exchange" style="color: #999"></i>';
				break;

		}

		return $output;
	}

	/***
	***	@Gets time in user-friendly way
	***/
	function nice_time( $time ) {
		$var = human_time_diff( strtotime( $time ), current_time('timestamp') );
		$time = sprintf(__('%s ago','um-notifications'), $var );
		return $time;
	}

	/***
	***	@Gets notifications
	***/
	function get_notifications( $per_page = 10, $unread_only = false, $count = false ) {
		global $wpdb, $ultimatemember;
		$user_id = get_current_user_id();
		$table_name = $wpdb->prefix . "um_notifications";

		if ( $unread_only == 'unread' && $count == true ) {

			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table_name} WHERE user = %d AND status = 'unread'",
					$user_id
				)
			);

			return $wpdb->num_rows;

		} else if ( $unread_only == 'unread' ) {

			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table_name} WHERE user = %d AND status='unread' ORDER BY time DESC LIMIT %d",
					$user_id,
					$per_page
				)
			);

		} else {

			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table_name} WHERE user = %d ORDER BY time DESC LIMIT %d",
					$user_id,
					$per_page
				)
			);

		}

		if ( $results )
			return $results;

		return false;
	}

	/***
	***	@Saves a notification
	***/
	function store_notification( $user_id, $type, $vars = array() ) {

		global $wpdb;

		$url = '';

		// Check if user opted-in
		if ( !$this->user_enabled( $type, $user_id ) ) return;

		$content = $this->get_notify_content( $type );
		if ( $vars ) {
			foreach( $vars as $key => $var ) {
				$content = str_replace('{'.$key.'}', $var, $content);
			}
		}

		$content = implode(' ',array_unique(explode(' ', $content)));

		if ( $vars && isset($vars['photo']) ) {
			$photo = $vars['photo'];
		} else {
			$photo = um_get_default_avatar_uri();
		}

		if ( $vars && isset($vars['notification_uri']) ) {
			$url = $vars['notification_uri'];
		}

		$table_name = $wpdb->prefix . "um_notifications";

		// Try to update a similar log
		$results = $wpdb->get_results(
			 $wpdb->prepare(
			"SELECT * FROM {$table_name} WHERE user = %d AND type = %s  AND content = %s ORDER BY time DESC LIMIT 1"
			,$user_id
			,$type
			,$content)
		);
		if ( $results && isset( $results[0] ) ) {
			$wpdb->update(
					$table_name,
					array(
						'status' 	=> 'unread',
						'time' 		=> current_time( 'mysql' ),
						'url'		=> $url
					),
					array(
						'user' 		=> $user_id,
						'type' 		=> $type,
						'content'	=> $content
					)
				);
			$do_not_insert = true;
		}

		if ( isset( $do_not_insert ) ) return;

		$wpdb->insert(
			$table_name,
			array(
				'time' => current_time( 'mysql' ),
				'user' => $user_id,
				'status' => 'unread',
				'photo' => $photo,
				'type' => $type,
				'url' => $url,
				'content' => $content
			)
		);

	}

	/***
	***	@Get notification content
	***/
	function get_notify_content( $type ) {
		$content = null;
		$content = um_get_option('log_' . $type . '_template');
		$content = apply_filters("um_notification_modify_entry_{$type}", $content);
		return $content;
	}

	/***
	***	@Mark as read
	***/
	function set_as_read( $notification_id ) {
		global $wpdb, $ultimatemember;
		$user_id = get_current_user_id();
		$table_name = $wpdb->prefix . "um_notifications";
		$wpdb->update(
			$table_name,
			array(
				'status' 	=> 'read',
			),
			array(
				'user' 		=> $user_id,
				'id' 		=> $notification_id
			)
		);
	}

	/***
	***	@Checks if notification is unread
	***/
	function is_unread( $notification_id ) {
		$user_id = get_current_user_id();
		$saved_id = get_post_meta( $notification_id, '_belongs_to', true );
		if ( $saved_id == $user_id ) {
			$is_unread = get_post_meta( $notification_id, 'status', true );
			if ( $is_unread == 'unread' ) {
				return true;
			}
		}
		return false;
	}

}
