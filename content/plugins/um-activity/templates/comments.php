<div class="um-activity-comments">

	<?php if ( is_user_logged_in() && $um_activity->api->can_comment() ) { ?>
	
	<div class="um-activity-commentl um-activity-comment-area">
		<div class="um-activity-comment-avatar"><?php echo get_avatar( get_current_user_id(), 30 ); ?></div>
		<div class="um-activity-comment-box"><textarea class="um-activity-comment-textarea" data-replytext="<?php _e('Write a reply...','um-activity'); ?>" data-reply_to="0" placeholder="<?php _e('Write a comment...','um-activity'); ?>"></textarea></div>
	</div>
	
	<?php } ?>
	
	<div class="um-activity-comments-loop">
	
		<div class="um-activity-commentl um-activity-commentl-clone">
			<a href="#" class="um-activity-comment-hide um-tip-s" title="<?php _e('Hide','um-activity'); ?>"><i class="um-icon-close-round"></i></a>
			<div class="um-activity-comment-avatar"><a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( get_current_user_id(), 30 ); ?></a></div>
			<div class="um-activity-comment-info">
				<div class="um-activity-comment-data">
					<span class="um-activity-comment-author-link"><a href="<?php echo um_user_profile_url(); ?>" class="um-link"><?php echo um_user('display_name'); ?></a></span> <span class="um-activity-comment-text"></span>
				</div>
				<div class="um-activity-comment-meta">
					<?php if ( is_user_logged_in() ) { ?>
					<span><a href="#" class="um-link um-activity-comment-like" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><?php _e('Like','um-activity'); ?></a></span>
					<?php if ( $um_activity->api->can_comment() ) { ?><span><a href="#" class="um-link um-activity-comment-reply" data-commentid="0"><?php _e('Reply','um-activity'); ?></a></span><?php } ?>
					
					<span class="um-activity-editc"><a href="#"><i class="um-icon-edit"></i></a>
						<span class="um-activity-editc-d">
							<a href="#" class="edit"><?php _e('Edit','um-activity'); ?></a>
							<a href="#" class="delete" data-msg="<?php _e('Are you sure you want to delete this comment?','um-activity'); ?>"><?php _e('Delete','um-activity'); ?></a>
						</span>
					</span>
						
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="um-activity-commentl is-child um-activity-commentlre-clone">
			<a href="#" class="um-activity-comment-hide um-tip-s" title="<?php _e('Hide','um-activity'); ?>"><i class="um-icon-close-round"></i></a>
			<div class="um-activity-comment-avatar"><a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( get_current_user_id(), 20 ); ?></a></div>
			<div class="um-activity-comment-info">
				<div class="um-activity-comment-data">
					<span class="um-activity-comment-author-link"><a href="<?php echo um_user_profile_url(); ?>" class="um-link"><?php echo um_user('display_name'); ?></a></span> <span class="um-activity-comment-text"></span>
				</div>
				<div class="um-activity-comment-meta">
					<?php if ( is_user_logged_in() ) { ?>
					<span><a href="#" class="um-link um-activity-comment-like" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><?php _e('Like','um-activity'); ?></a></span>
					
					<span class="um-activity-editc"><a href="#"><i class="um-icon-edit"></i></a>
						<span class="um-activity-editc-d">
							<a href="#" class="edit"><?php _e('Edit','um-activity'); ?></a>
							<a href="#" class="delete" data-msg="<?php _e('Are you sure you want to delete this comment?','um-activity'); ?>"><?php _e('Delete','um-activity'); ?></a>
						</span>
					</span>
					
					<?php } ?>
				</div>
			</div>
		</div>
		
		<?php
		// Comments display
		if ( $post_id > 0 ) {
		$comments_all = $um_activity->api->get_comments_number( $post_id );
		if ( $comments_all > 0 ) {
		
			$comm_num = ( isset( $_GET['wall_comment_id'] ) && absint( $_GET['wall_comment_id'] ) ) ? 10000 : um_get_option('activity_init_comments_count');
			
			$comments = get_comments( array( 'post_id' => $post_id, 'parent' => 0, 'number' => $comm_num, 'offset' => 0, 'order' => um_get_option('activity_order_comment') ) );

			include um_activity_path . 'templates/comment.php';
			
			// Do we have more comments
			if ( $comments_all > count( $comments ) ) {
				$calc = $comments_all - count( $comments );
				if ( $calc > 1 ) {
					$text = sprintf(__('load %s more comments','um-activity'), $calc );
				} else if ( $calc == 1 ) {
					$text = sprintf(__('load %s more comment','um-activity'), $calc );
				}
				echo '<a href="#" class="um-activity-commentload" data-load_replies="'. __('load more replies','um-activity').'" data-load_comments="'.__('load more comments','um-activity') . '" data-loaded="'. count( $comments ) . '"><i class="um-icon-forward"></i><span>' . $text . '</span></a>';
				echo '<div class="um-activity-commentload-spin"></div>';
			}
		
		}
		}
		?>
	
	</div>
	
</div>