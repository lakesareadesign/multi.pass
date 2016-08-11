<?php

/**
 * Author: Hoang Ngo
 */
class WD_Comment_Audit extends WD_Event_Abstract {
	const ACTION_SPAMMED = 'spammed', ACTION_UNSPAMMED = 'unspammed', ACTION_DUPLICATED = 'duplicated', ACTION_FLOOD = 'flood';
	const CONTEXT_COMMENT = 'ct_comment';
	protected $type = 'comment';

	public function get_hooks() {
		return array(
			/*'comment_post'              => array(
				'args'        => array( 'comment_ID', 'comment_approved', 'commentdata' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_ADDED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' )
			),*/
			'wp_insert_comment'         => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_ADDED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' )
			),
			'comment_flood_trigger'     => array(
				'args'        => array( 'time_lastcomment', 'time_newcomment' ),
				'level'       => self::LOG_LEVEL_NOTICE,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_FLOOD,
				'context'     => self::CONTEXT_COMMENT,
				'text'        => sprintf( __( "User %s flooded comment", wp_defender()->domain ), '{{wp_user}}' ),
			),
			'deleted_comment'           => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_DELETED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'trash_comment'             => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_TRASHED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'untrash_comment'           => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_RESTORED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'spam_comment'              => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_SPAMMED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'unspam_comment'            => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_UNSPAMMED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'transition_comment_status' => array(
				'args'        => array( 'new_status', 'old_status', 'comment' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_UPDATED,
				'callback'    => array( 'WD_Comment_Audit', 'process_comment_status_changed' ),
			),
			'edit_comment'              => array(
				'args'        => array( 'comment_ID' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => WD_Audit_API::ACTION_UPDATED,
				'callback'    => array( 'WD_Comment_Audit', 'process_generic_comment' ),
			),
			'comment_duplicate_trigger' => array(
				'args'        => array( 'commentdata' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_DUPLICATED,
				'callback'    => array( 'WD_Comment_Audit', 'process_comment_duplicate_trigger' ),
			),
		);
	}

	public function dictionary() {
		return array(
			self::ACTION_DUPLICATED => __( "Duplicated", wp_defender()->domain ),
			self::ACTION_SPAMMED    => __( "Spammed", wp_defender()->domain ),
			self::ACTION_UNSPAMMED  => __( "Unspammed", wp_defender()->domain ),
			self::CONTEXT_COMMENT   => __( "Comment", wp_defender()->domain )
		);
	}

	public static function process_comment_duplicate_trigger() {
		$args         = func_get_args();
		$comment_data = $args[1]['commentdata'];

		$post            = get_post( $comment_data['comment_post_ID'] );
		$post_type       = get_post_type_object( $post->post_type );
		$post_type_label = strtolower( $post_type->labels->singular_name );
		$text            = sprintf( __( "User %s submitted a duplicate comment on %s \"%s\"", wp_defender()->domain ), is_user_logged_in() ? WD_Utils::get_user_name( get_current_user_id() ) : $comment_data['comment_author'], $post_type_label, $post->post_title );

		return array( $text, $post_type_label );
	}

	/**
	 * @return bool|string
	 */
	public static function process_comment_status_changed() {
		$args            = func_get_args();
		$new_stat        = $args[1]['new_status'];
		$old_stat        = $args[1]['old_status'];
		$comment         = $args[1]['comment'];
		$post            = get_post( $comment->comment_post_ID );
		$post_type       = get_post_type_object( $post->post_type );
		$post_type_label = strtolower( $post_type->labels->singular_name );
		$text            = false;
		if ( $old_stat == 'unapproved' && $new_stat == 'approved' ) {
			$text = sprintf( __( "%s approved comment ID %s from %s, on %s \"%s\"", wp_defender()->domain ), WD_Utils::get_user_name( get_current_user_id() ), $comment->comment_ID, $comment->comment_author, $post_type_label, $post->post_title );
		} elseif ( $new_stat == 'unapproved' && $old_stat == 'approved' ) {
			$text = sprintf( __( "%s unapproved comment ID %s from %s, on %s \"%s\"", wp_defender()->domain ), WD_Utils::get_user_name( get_current_user_id() ), $comment->comment_ID, $comment->comment_author, $post_type_label, $post->post_title );
		}

		return array( $text, $post_type_label );
	}

	/**
	 * @return bool|string
	 */
	public static function process_generic_comment() {
		$args       = func_get_args();
		$hookname   = $args[0];
		$comment_id = $args[1]['comment_ID'];
		if ( ! isset( $args[1]['commentdata'] ) ) {
			$comment = get_comment( $comment_id );
			$comment = $comment->to_array();
		} else {
			$comment = $args[1]['commentdata'];
		}
		if ( ! isset( $args[1]['comment_approved'] ) ) {
			$comment_approved = '';
		} else {
			$comment_approved = $args[1]['comment_approved'];
		}
		$post            = get_post( $comment['comment_post_ID'] );
		$post_type       = get_post_type_object( $post->post_type );
		$post_type_label = strtolower( $post_type->labels->singular_name );
		switch ( $hookname ) {
			case 'comment_post':
				if ( $comment_approved === 'spam' ) {
					$comment_status = 'spam';
				} elseif ( $comment_approved === 1 ) {
					$comment_status = __( "approved", wp_defender()->domain );
				} else {
					$comment_status = __( "pending approval", wp_defender()->domain );
				}
				if ( $comment['comment_parent'] == 0 ) {
					$text = sprintf( __( "%s commented on %s \"%s\" - comment status: %s", wp_defender()->domain ),
						$comment['comment_author'], $post_type_label, $post->post_title, $comment_status );
				} else {
					$parent_comment = get_comment( $comment['comment_parent'] );
					$text           = sprintf( __( "%s replied to %s's comment on %s \"%s\" - comment status: %s", wp_defender()->domain ),
						$comment['comment_author'], $parent_comment->comment_author, $post_type_label, $post->post_title, $comment_status );
				}
				break;
			case 'wp_insert_comment':
				if ( $comment_approved === 'spam' ) {
					$comment_status = 'spam';
				} elseif ( $comment_approved === 1 ) {
					$comment_status = __( "approved", wp_defender()->domain );
				} else {
					$comment_status = __( "pending approval", wp_defender()->domain );
				}
				if ( $comment['comment_parent'] == 0 ) {
					$text = sprintf( __( "%s commented on %s \"%s\" - comment status: %s", wp_defender()->domain ),
						$comment['comment_author'], $post_type_label, $post->post_title, $comment_status );
				} else {
					$parent_comment = get_comment( $comment['comment_parent'] );
					$text           = sprintf( __( "%s replied to %s's comment on %s \"%s\" - comment status: %s", wp_defender()->domain ),
						$comment['comment_author'], $parent_comment->comment_author, $post_type_label, $post->post_title, $comment_status );
				}
				break;
			case 'deleted_comment':
				$text = sprintf( __( "%s deleted comment ID %s, comment author: %s on %s \"%s\"", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			case 'trash_comment':
				$text = sprintf( __( "%s trashed comment ID %s, comment author: %s on %s \"%s\"", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			case 'untrash_comment':
				$text = sprintf( __( "%s untrashed comment ID %s, comment author: %s on %s \"%s\"", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			case 'spam_comment':
				$text = sprintf( __( "%s marked comment ID %s, comment author: %s on %s \"%s\" as spam", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			case 'unspam_comment':
				$text = sprintf( __( "%s unmarked comment ID %s, comment author: %s on %s \"%s\" as spam", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			case 'edit_comment':
				$text = sprintf( __( "%s edited comment ID %s, comment author: %s on %s \"%s\"", wp_defender()->domain ),
					WD_Utils::get_user_name( get_current_user_id() ), $comment_id, $comment['comment_author'], $post_type_label, $post->post_title );
				break;
			default:
				return false;
		}

		return array( $text, $post_type_label );
	}
}