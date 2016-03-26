<?php

class UM_Messaging_Main_API {

	/***
	***	@Construct
	***/
	function __construct() {
		global $wpdb;

		$this->table_name1 = $wpdb->prefix . "um_conversations";
		$this->table_name2 = $wpdb->prefix . "um_messages";

		$this->emoji[':)'] = 'https://s.w.org/images/core/emoji/72x72/1f604.png';
		$this->emoji[':smiley:'] = 'https://s.w.org/images/core/emoji/72x72/1f603.png';
		$this->emoji[':D'] = 'https://s.w.org/images/core/emoji/72x72/1f600.png';
		$this->emoji[':$'] = 'https://s.w.org/images/core/emoji/72x72/1f60a.png';
		$this->emoji[':relaxed:'] = 'https://s.w.org/images/core/emoji/72x72/263a.png';
		$this->emoji[';)'] = 'https://s.w.org/images/core/emoji/72x72/1f609.png';
		$this->emoji[':heart_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f60d.png';
		$this->emoji[':kissing_heart:'] = 'https://s.w.org/images/core/emoji/72x72/1f618.png';
		$this->emoji[':kissing_closed_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f61a.png';
		$this->emoji[':kissing:'] = 'https://s.w.org/images/core/emoji/72x72/1f617.png';
		$this->emoji[':kissing_smiling_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f619.png';
		$this->emoji[';P'] = 'https://s.w.org/images/core/emoji/72x72/1f61c.png';
		$this->emoji[':P'] = 'https://s.w.org/images/core/emoji/72x72/1f61b.png';
		$this->emoji[':stuck_out_tongue_closed_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f61d.png';
		$this->emoji[':flushed:'] = 'https://s.w.org/images/core/emoji/72x72/1f633.png';
		$this->emoji[':grin:'] = 'https://s.w.org/images/core/emoji/72x72/1f601.png';
		$this->emoji[':pensive:'] = 'https://s.w.org/images/core/emoji/72x72/1f614.png';
		$this->emoji[':relieved:'] = 'https://s.w.org/images/core/emoji/72x72/1f60c.png';
		$this->emoji[':unamused'] = 'https://s.w.org/images/core/emoji/72x72/1f612.png';
		$this->emoji[':('] = 'https://s.w.org/images/core/emoji/72x72/1f61e.png';
		$this->emoji[':persevere:'] = 'https://s.w.org/images/core/emoji/72x72/1f623.png';
		$this->emoji[":'("] = 'https://s.w.org/images/core/emoji/72x72/1f622.png';
		$this->emoji[':joy:'] = 'https://s.w.org/images/core/emoji/72x72/1f602.png';
		$this->emoji[':sob:'] = 'https://s.w.org/images/core/emoji/72x72/1f62d.png';
		$this->emoji[':sleepy:'] = 'https://s.w.org/images/core/emoji/72x72/1f62a.png';
		$this->emoji[':disappointed_relieved:'] = 'https://s.w.org/images/core/emoji/72x72/1f625.png';
		$this->emoji[':cold_sweat:'] = 'https://s.w.org/images/core/emoji/72x72/1f630.png';
		$this->emoji[':sweat_smile:'] = 'https://s.w.org/images/core/emoji/72x72/1f605.png';
		$this->emoji[':sweat:'] = 'https://s.w.org/images/core/emoji/72x72/1f613.png';
		$this->emoji[':weary:'] = 'https://s.w.org/images/core/emoji/72x72/1f629.png';
		$this->emoji[':tired_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f62b.png';
		$this->emoji[':fearful:'] = 'https://s.w.org/images/core/emoji/72x72/1f628.png';
		$this->emoji[':scream:'] = 'https://s.w.org/images/core/emoji/72x72/1f631.png';
		$this->emoji[':angry:'] = 'https://s.w.org/images/core/emoji/72x72/1f620.png';
		$this->emoji[':rage:'] = 'https://s.w.org/images/core/emoji/72x72/1f621.png';
		$this->emoji[':triumph'] = 'https://s.w.org/images/core/emoji/72x72/1f624.png';
		$this->emoji[':confounded:'] = 'https://s.w.org/images/core/emoji/72x72/1f616.png';
		$this->emoji[':laughing:'] = 'https://s.w.org/images/core/emoji/72x72/1f606.png';
		$this->emoji[':yum:'] = 'https://s.w.org/images/core/emoji/72x72/1f60b.png';
		$this->emoji[':mask:'] = 'https://s.w.org/images/core/emoji/72x72/1f637.png';
		$this->emoji[':cool:'] = 'https://s.w.org/images/core/emoji/72x72/1f60e.png';
		$this->emoji[':sleeping:'] = 'https://s.w.org/images/core/emoji/72x72/1f634.png';
		$this->emoji[':dizzy_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f635.png';
		$this->emoji[':astonished:'] = 'https://s.w.org/images/core/emoji/72x72/1f632.png';
		$this->emoji[':worried:'] = 'https://s.w.org/images/core/emoji/72x72/1f61f.png';
		$this->emoji[':frowning:'] = 'https://s.w.org/images/core/emoji/72x72/1f626.png';
		$this->emoji[':anguished:'] = 'https://s.w.org/images/core/emoji/72x72/1f627.png';
		$this->emoji[':smiling_imp:'] = 'https://s.w.org/images/core/emoji/72x72/1f608.png';
		$this->emoji[':imp:'] = 'https://s.w.org/images/core/emoji/72x72/1f47f.png';
		$this->emoji[':open_mouth:'] = 'https://s.w.org/images/core/emoji/72x72/1f62e.png';
		$this->emoji[':grimacing:'] = 'https://s.w.org/images/core/emoji/72x72/1f62c.png';
		$this->emoji[':neutral_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f610.png';
		$this->emoji[':confused:'] = 'https://s.w.org/images/core/emoji/72x72/1f615.png';
		$this->emoji[':hushed:'] = 'https://s.w.org/images/core/emoji/72x72/1f62f.png';
		$this->emoji[':no_mouth:'] = 'https://s.w.org/images/core/emoji/72x72/1f636.png';
		$this->emoji[':innocent:'] = 'https://s.w.org/images/core/emoji/72x72/1f607.png';
		$this->emoji[':smirk:'] = 'https://s.w.org/images/core/emoji/72x72/1f60f.png';
		$this->emoji[':expressionless:'] = 'https://s.w.org/images/core/emoji/72x72/1f611.png';

		$this->emoji = apply_filters('um_messaging_emoji', $this->emoji );

		add_action('init', array( $this, 'init_perms'), 100 );

	}

	function init_perms() {
		$this->perms = $this->get_perms( get_current_user_id() );
	}

	function get_perms( $user_id ) {
		global $ultimatemember;

		if ( !isset( $ultimatemember->query ) || ! method_exists( $ultimatemember->query, 'role_data' ) ) {
			return;
		}

		$role = get_user_meta( $user_id, 'role', true );
		$role_data = $ultimatemember->query->role_data( $role );
		$role_data = apply_filters('um_user_permissions_filter', $role_data, $user_id);
		return $role_data;
	}

	/***
	***	@Blocked a user?
	***/
	function blocked_user( $user_id, $who_blocked = false ) {
		if ( !$who_blocked )
			$who_blocked = get_current_user_id();

		$blocked = (array) get_user_meta( $who_blocked, '_pm_blocked', true );
		if ( in_array( $user_id, $blocked ) )
			return true;
		return false;
	}

	/***
	***	@Is it a hidden conversation?
	***/
	function hidden_conversation( $conversation_id ) {
		$hidden = (array) get_user_meta( get_current_user_id(), '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) )
			return true;
		return false;
	}

	/***
	***	@hides a conversation
	***/
	function hide_conversation( $user_id, $conversation_id ) {
		$hidden = (array) get_user_meta( $user_id, '_hidden_conversations', true );
		if ( !in_array( $conversation_id, $hidden ) ) {
			$hidden[] = $conversation_id;
			update_user_meta( $user_id, '_hidden_conversations', $hidden );
		}
	}

	/***
	***	@Can start messages?
	***/
	function can_message( $recipient ) {
		global $ultimatemember;

		if ( $this->blocked_user( $recipient, get_current_user_id() ) || $this->blocked_user( get_current_user_id(), $recipient ) )
			return false;

		$who_can_pm = get_user_meta( $recipient, '_pm_who_can', true );
		if ( $who_can_pm == 'nobody')
			return false;

		// only people I follow
		if ( $who_can_pm == 'followed' && defined('um_followers_extension') ) {
			global $um_followers;
			if ( !$um_followers->api->followed( get_current_user_id(), $recipient ) ) {
				return false;
			}
		}

		// followers can message
		if ( $who_can_pm == 'follower' && defined('um_followers_extension') ) {
			global $um_followers;
			if ( !$um_followers->api->followed( $recipient, get_current_user_id() ) ) {
				return false;
			}
		}

		if ( um_get_option('pm_block_users') ) {
			$users = str_replace(' ', '', um_get_option('pm_block_users') );
			$array = explode(',', $users );
			if ( in_array( get_current_user_id(), $array ) )
				return false;
		}

		$role = get_user_meta( get_current_user_id(), 'role', true );
		$role_data = $ultimatemember->query->role_data( $role );
		$role_data = apply_filters('um_user_permissions_filter', $role_data, get_current_user_id() );

		if ( $role_data['can_start_pm'] )
			return true;

		return false;
	}

	/***
	***	@Check if conversation has unread messages
	***/
	function unread_conversation( $conversation_id, $user_id ) {
		global $wpdb;
		$count = $wpdb->get_var("SELECT COUNT(message_id) FROM {$this->table_name2} WHERE conversation_id={$conversation_id} AND recipient={$user_id} AND status=0 LIMIT 1");
		if ( $count )
			return true;
		return false;
	}

	/***
	***	@Get unread messages count
	***/
	function get_unread_count( $user_id ) {
		global $wpdb;
		$blocked = get_user_meta( $user_id, '_pm_blocked', true );
		$blocked = is_array( $blocked ) ? array_filter( $blocked, 'intval' ) : array();

		if(count($blocked)) {
			$count = $wpdb->get_var("SELECT COUNT(message_id) FROM {$this->table_name2} WHERE recipient={$user_id} AND author NOT IN(" . implode(',', $blocked) . ") status=0 LIMIT 10");
		} else {
			$count = $wpdb->get_var("SELECT COUNT(message_id) FROM {$this->table_name2} WHERE recipient={$user_id} AND status=0 LIMIT 10");
		}
		return intval($count);
	}

	/***
	***	@Remove a message
	***/
	function remove_message( $message_id, $conversation_id ) {
		global $wpdb;
		$wpdb->delete( $this->table_name2, array( 'conversation_id' => $conversation_id, 'message_id' => $message_id, 'author' => get_current_user_id() ) );
	}

	/***
	***	@Check whether limit reached for sending msg
	***/
	function limit_reached() {
		$user_id = get_current_user_id();
		$msgs_sent = get_user_meta( $user_id, '_um_pm_msgs_sent', true );

		$last_pm = get_user_meta( $user_id, '_um_pm_last_send', true );

		$limit = $this->perms['pm_max_messages'];
		$limit_tf = $this->perms['pm_max_messages_tf'];

		if ( !$limit ) return false;

		if ( $limit_tf ) {

		$numDays = number_format( abs( $last_pm - current_time('timestamp') ) /60/60/24, 2 );
		if ( $numDays > $limit_tf ) { // more than x day since last msg open it again
			delete_user_meta( $user_id, '_um_pm_last_send' );
			delete_user_meta( $user_id, '_um_pm_msgs_sent' );
		} else {

			if ( $msgs_sent >= $limit ) {
				return true;
			} else {
				return false;
			}

		}

		} else {

			if ( $msgs_sent >= $limit ) {
				return true;
			}

		}

		return false;
	}

	/***
	***	@Conversation template
	***/
	function conversation_template( $message_to, $user_id ) {
		global $ultimatemember;

		um_fetch_user( $message_to );
		$contact_name = ( um_user('display_name') ) ? um_user('display_name') : __('Deleted User','um-messaging');
		$contact_url = um_user_profile_url();

		$limit = um_get_option('pm_char_limit');

		um_fetch_user( $user_id );

		$response = $this->get_conversation_id( $message_to, $user_id );
		$message_history = add_query_arg('profiletab', 'messages', um_user_profile_url() );

		?>

			<div class="um-message-header um-popup-header">
				<div class="um-message-header-left"><?php echo get_avatar( $message_to, 40 ); ?> <?php echo '<a href="'. um_user_profile_url() . '">' . $contact_name . '</a>'; ?></div>
				<div class="um-message-header-right">
					<a href="#" class="um-message-blocku um-tip-e" title="<?php _e('Block user','um-messaging'); ?>" data-other_user="<?php echo $message_to; ?>" data-conversation_id="<?php echo $response['conversation_id']; ?>"><i class="um-faicon-ban"></i></a>
					<a href="#" class="um-message-delconv um-tip-e" title="<?php _e('Delete conversation','um-messaging'); ?>" data-other_user="<?php echo $message_to; ?>" data-conversation_id="<?php echo $response['conversation_id']; ?>"><i class="um-icon-trash-b"></i></a>
					<a href="#" class="um-message-hide um-tip-e" title="<?php _e('Close chat','um-messaging'); ?>"><i class="um-icon-android-close"></i></a>
				</div>
			</div>

			<div class="um-message-body um-popup-autogrow um-message-autoheight" data-message_to="<?php echo $message_to; ?>">
				<div class="um-message-ajax" data-message_to="<?php echo $message_to; ?>" data-conversation_id="<?php echo $response['conversation_id']; ?>" data-last_updated="<?php echo $response['last_updated']; ?>">

					<?php if ( $this->perms['can_read_pm'] ) {
							echo $this->get_conversation( $message_to, $user_id, $response['conversation_id'] );
					} else {

						echo '<span class="um-message-notice">' . __('Your membership level does not allow you to view conversations.','um-messaging') . '</span>';

					}

					?>

				</div>
			</div>

			<div class="um-message-footer um-popup-footer" data-limit_hit="<?php _e('You have reached your limit for sending messages.','um-messaging'); ?>" >

				<?php if ( $this->limit_reached() ) { ?>

				<?php _e('You have reached your limit for sending messages.','um-messaging'); ?>

				<?php } else if ( $this->perms['can_reply_pm'] ) { ?>

				<div class="um-message-textarea">

					<?php echo $this->emoji(); ?>

					<textarea name="um_message_text" id="um_message_text" data-maxchar="<?php echo $limit; ?>" placeholder="<?php _e('Type your message...','um-messaging'); ?>"></textarea>

				</div>

				<div class="um-message-buttons">
					<span class="um-message-limit"><?php echo $limit; ?></span>
					<a href="#" class="um-message-send disabled"><i class="um-faicon-envelope-o"></i><?php _e('Send message','um-messaging'); ?></a>
				</div>

				<div class="um-clear"></div>

				<?php } else { ?>

				<?php _e('You are not allowed to reply to private messages.','um-messaging'); ?>

				<?php } ?>

			</div>

	<?php
	}

	/***
	***	@Get conversations
	***/
	function get_conversations( $user_id ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM {$this->table_name1} WHERE user_a=$user_id OR user_b=$user_id ORDER BY last_updated DESC LIMIT 50");
		if ( $results ) {
			foreach( $results as $key => $result ) {
				if ( get_userdata( $result->user_b ) === false || get_userdata( $result->user_a ) === false ) {
					unset( $results[$key] );
				}
			}
			return $results;
		}
		return '';
	}

	/***
	***	@Get a conversation ID
	***/
	function get_conversation_id( $user1, $user2, $conversation_id = null ) {
		global $wpdb;
		$response = null;
		if ( !$conversation_id ) {
			$conversation = $wpdb->get_results("SELECT conversation_id, last_updated FROM {$this->table_name1} WHERE user_a=$user1 AND user_b=$user2 LIMIT 1");
			if ( isset( $conversation[0]->conversation_id ) ) {
				$response['conversation_id'] = $conversation[0]->conversation_id;
				$response['last_updated'] = $conversation[0]->last_updated;
			} else {
				$conversation = $wpdb->get_results("SELECT conversation_id, last_updated FROM {$this->table_name1} WHERE user_a=$user2 AND user_b=$user1 LIMIT 1");
				if ( isset( $conversation[0]->conversation_id ) ) {
					$response['conversation_id'] = $conversation[0]->conversation_id;
					$response['last_updated'] = $conversation[0]->last_updated;
				}
			}
		}
		return $response;
	}

	/***
	***	@Get a conversation
	***/
	function get_conversation( $user1, $user2, $conversation_id = null ) {
		global $wpdb;

		// No conversation yet
		if ( !$conversation_id || $conversation_id <= 0 ) return;

		// Get conversation ordered by time and show only 1000 messages
		$messages = $wpdb->get_results("SELECT * FROM {$this->table_name2} WHERE conversation_id=$conversation_id ORDER BY time ASC LIMIT 1000");
		$response = null;
		$update_query = false;
		foreach( $messages as $message ) {

			if ( $message->status == 0 ) {
				$update_query = true;
				$status = 'unread';
			} else {
				$status = 'read';
			}

			if ( $message->author == get_current_user_id() ) {
				$class = 'right_m';
				$remove_msg = '<a href="#" class="um-message-item-remove um-message-item-show-on-hover um-tip-s" title="'. __('Remove','um-messaging').'"></a>';
			} else {
				$class = 'left_m';
				$remove_msg = '';
			}

			$response .= '<div class="um-message-item ' . $class . ' ' . $status . '" data-message_id="'.$message->message_id.'" data-conversation_id="'.$message->conversation_id.'">';

			$response .= '<div class="um-message-item-content">' . $this->chatize( $message->content ) . '</div><div class="um-clear"></div>';

			$response .= '<div class="um-message-item-metadata">' . $this->beautiful_time( $message->time, $class ) . '</div><div class="um-clear"></div>';

			$response .= $remove_msg;

			$response .= '</div><div class="um-clear"></div>';

		}

		if ( $update_query ) {
			$logged = get_current_user_id();
			$wpdb->query("UPDATE {$this->table_name2} SET status=1 WHERE conversation_id={$conversation_id} AND author != {$logged}");
		}

		return $response;
	}

	/***
	***	@Chatize a message content
	***/
	function chatize( $content ) {
		$content = stripslashes( $content );
		foreach( $this->emoji as $code => $val ) {
			$content = str_replace( $code, '<img src="'.$val.'" alt="'.$code.'" title="'.$code.'" class="emoji" />', $content );
		}

		// autolink
		$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a href="$2" target="_blank" rel="nofollow">$2</a> ', $content." ");
		$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank" rel="nofollow">$2</a> ', $content." ");

		return nl2br( $content );
	}

	/***
	***	@Nice time difference
	***/
	function human_time_diff( $from, $to = '' ) {
		if ( empty( $to ) ) {
			$to = time();
		}

		$diff = (int) abs( $to - $from );

		if ( $diff < 60 ) {
			$since = sprintf( __('%ss','um-messaging'), $diff );
		} elseif ( $diff < HOUR_IN_SECONDS ) {
			$mins = round( $diff / MINUTE_IN_SECONDS );
			if ( $mins <= 1 )
				$mins = 1;
			/* translators: min=minute */
			$since = sprintf( __('%sm','um-messaging'), $mins );
		} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
			$hours = round( $diff / HOUR_IN_SECONDS );
			if ( $hours <= 1 )
				$hours = 1;
			$since = sprintf( __('%sh','um-messaging'), $hours );
		} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
			$days = round( $diff / DAY_IN_SECONDS );
			if ( $days <= 1 )
				$days = 1;
			$since = sprintf( __('%sd','um-messaging'), $days );
		} elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
			$weeks = round( $diff / WEEK_IN_SECONDS );
			if ( $weeks <= 1 )
				$weeks = 1;
			$since = sprintf( __('%sw','um-messaging'), $weeks );
		} elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
			$months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
			if ( $months <= 1 )
				$months = 1;
			$since = sprintf( __('%sm','um-messaging'), $months );
		} elseif ( $diff >= YEAR_IN_SECONDS ) {
			$years = round( $diff / YEAR_IN_SECONDS );
			if ( $years <= 1 )
				$years = 1;
			$since = sprintf( __('%sy','um-messaging'), $years );
		}

		return apply_filters( 'um_messaging_human_time_diff', $since, $diff, $from, $to );
	}

	/***
	***	@Show time beautifully
	***/
	function beautiful_time( $time, $pos ) {
		$nice_time = $this->human_time_diff( strtotime( $time ), current_time('timestamp') );
		if ( $pos == 'right_m' ) {
		return '<span class="um-message-item-time um-tip-e" title="'.$time.'">' . $nice_time . '</span>';
		} else {
		return '<span class="um-message-item-time um-tip-w" title="'.$time.'">' . $nice_time . '</span>';
		}
	}

	/***
	***	@Checks if user enabled email notification
	***/
	function enabled_email( $user_id ) {
		$_enable_new_pm = true;
		if ( get_user_meta( $user_id, '_enable_new_pm', true ) == 'yes' ) {
			$_enable_new_pm = 1;
		} else if ( get_user_meta( $user_id, '_enable_new_pm', true ) == 'no' ) {
			$_enable_new_pm = 0;
		}
		return $_enable_new_pm;
	}

	/***
	***	@Create a conversation between both parties
	***/
	function create_conversation( $user1, $user2 ) {
		global $wpdb;
		$conversation_id = false;

		// Test for previous conversation
		$conversation = $wpdb->get_results("SELECT conversation_id FROM {$this->table_name1} WHERE user_a=$user1 AND user_b=$user2 LIMIT 1");
		if ( isset( $conversation[0]->conversation_id ) ) {
			$conversation_id = $conversation[0]->conversation_id;
		} else {
			$conversation = $wpdb->get_results("SELECT conversation_id FROM {$this->table_name1} WHERE user_a=$user2 AND user_b=$user1 LIMIT 1");
			if ( isset( $conversation[0]->conversation_id ) ) {
				$conversation_id = $conversation[0]->conversation_id;
			}
		}

		// Build new conversation
		if ( !$conversation_id ) {
			$wpdb->insert(
				$this->table_name1,
				array(
					'user_a' => $user1,
					'user_b' => $user2
				)
			);
			$conversation = $wpdb->get_results("SELECT conversation_id FROM {$this->table_name1} WHERE user_a=$user1 AND user_b=$user2 LIMIT 1");
			$conversation_id = $conversation[0]->conversation_id;

			do_action('um_after_new_conversation', $user1, $user2, $conversation_id );

		} else {

			do_action('um_after_existing_conversation', $user1, $user2, $conversation_id );

		}

		// Insert message
		$wpdb->update(
			$this->table_name1,
			array(
				'last_updated' 			=> current_time( 'mysql' ),
			),
			array(
				'conversation_id' 		=> $conversation_id,
			)
		);

		$wpdb->insert(
				$this->table_name2,
				array(
					'conversation_id' => $conversation_id,
					'time' => current_time( 'mysql' ),
					'content' => strip_tags( $_POST['content'] ),
					'status' => 0,
					'author' => $user2,
					'recipient' => $user1
				)
		);

		$this->update_user( $user2 );

		$hidden = (array) get_user_meta( $user1, '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) ) {
			$hidden = array_diff($hidden, array( $conversation_id ) );
			update_user_meta( $user1, '_hidden_conversations', $hidden );
		}

		$hidden = (array) get_user_meta( $user2, '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) ) {
			$hidden = array_diff($hidden, array( $conversation_id ) );
			update_user_meta( $user2, '_hidden_conversations', $hidden );
		}

		do_action('um_after_new_message', $user1, $user2, $conversation_id );

		return $conversation_id;

	}

	/***
	***	@Update user
	***/
	function update_user( $user_id ) {

		update_user_meta( $user_id, '_um_pm_last_send', current_time( 'timestamp' ) );
		$msgs_sent = get_user_meta( $user_id, '_um_pm_msgs_sent', true );
		update_user_meta( $user_id, '_um_pm_msgs_sent', (int) $msgs_sent + 1 );

	}

	/***
	***	@Show available emoji
	***/
	function emoji() {

		?>

		<div class="um-message-emoji">
			<a href="#" class="um-message-emo"><img src="<?php echo um_messaging_url . 'assets/img/emoji_init.png'; ?>" alt="" title="" /></a>
			<span class="um-message-emolist">

		<?php foreach( $this->emoji as $emoji_code => $emoji_url ) { ?>

			<span data-emo="<?php echo $emoji_code; ?>" title="<?php echo $emoji_code; ?>" class="um-message-insert-emo">
				<img src="<?php echo $emoji_url; ?>" alt="<?php echo $emoji_code; ?>" title="<?php echo $emoji_code; ?>" class="emoji">
			</span>

		<?php

		} ?>

		</span>
		</div>

		<?php
	}

	/***
	***	@Hex to RGB
	***/
	function hex_to_rgb( $hex ) {
		list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
		return "$r, $g, $b";
	}

}
