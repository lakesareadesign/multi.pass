<?php
foreach( $comments as $comment ) {
	$likes = get_comment_meta( $comment->comment_ID, '_likes', true );
	$avatar = get_avatar( $comment->comment_author_email, 30 );
	
	$user_hidden = $um_activity->api->user_hidden_comment( $comment->comment_ID );
?>
		
			<div class="um-activity-commentwrap" data-comment_id="<?php echo $comment->comment_ID; ?>">

			<div class="um-activity-commentl" id="commentid-<?php echo $comment->comment_ID; ?>">
				
				<?php if ( !$user_hidden ) { ?>
				<a href="#" class="um-activity-comment-hide um-tip-s"><i class="um-icon-close-round"></i></a>
				<?php } ?>
				
				<div class="um-activity-comment-avatar hidden-<?php echo $user_hidden; ?>"><a href="<?php echo um_user_profile_url(); ?>"><?php echo $avatar; ?></a></div>
				
				<div class="um-activity-comment-hidden hidden-<?php echo $user_hidden; ?>"><?php _e('Comment hidden. <a href="#" class="um-link">Show this comment</a>','um-activity'); ?></div>
				
				<div class="um-activity-comment-info hidden-<?php echo $user_hidden; ?>">
					
					<div class="um-activity-comment-data">
						<span class="um-activity-comment-author-link"><a href="<?php echo um_user_profile_url(); ?>" class="um-link"><?php echo um_user('display_name'); ?></a></span> <span class="um-activity-comment-text"><?php echo $um_activity->api->commentcontent( $comment->comment_content ); ?></span>
					</div>
					
					<div class="um-activity-comment-meta">
						<?php if ( is_user_logged_in() ) { ?>
						
						<?php if ( $um_activity->api->user_liked_comment( $comment->comment_ID ) ) { ?>
						<span><a href="#" class="um-link um-activity-comment-like active" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><?php _e('Unike','um-activity'); ?></a></span>
						<?php } else { ?>
						<span><a href="#" class="um-link um-activity-comment-like" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><?php _e('Like','um-activity'); ?></a></span>
						<?php } ?>
			
						<span class="um-activity-comment-likes count-<?php echo (int) $likes; ?>"><a href="#"><i class="um-faicon-thumbs-up"></i><ins class="um-activity-ajaxdata-commentlikes"><?php echo (int) $likes; ?></ins></a></span>
						
						<?php if ( $um_activity->api->can_comment() ) { ?><span><a href="#" class="um-link um-activity-comment-reply" data-commentid="<?php echo $comment->comment_ID; ?>"><?php _e('Reply','um-activity'); ?></a></span><?php } ?>
						
						<?php } ?>
						
						<span><a href="<?php echo $um_activity->api->get_comment_link( $post_link, $comment->comment_ID ); ?>" class="um-activity-comment-permalink"><?php echo $um_activity->api->get_comment_time( $comment->comment_date ); ?></a></span>
						
						<?php if ( $um_activity->api->can_edit_comment( $comment->comment_ID, get_current_user_id() ) ) { ?>
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
		
		$comm_num = ( isset( $_GET['wall_comment_id'] ) && absint( $_GET['wall_comment_id'] ) ) ? 10000 : um_get_option('activity_init_comments_count');
		
		$child = get_comments( array( 'post_id' => $post_id, 'parent' => $comment->comment_ID, 'number' => $comm_num, 'offset' => 0, 'order' => um_get_option('activity_order_comment') ) );
		$child_all = get_comments( array( 'post_id' => $post_id, 'parent' => $comment->comment_ID, 'number' => 999, 'offset' => 0, 'order' => um_get_option('activity_order_comment') ) );

		echo '<div class="um-activity-comment-child">';
		
			foreach( $child as $commentc ) {
				
				$likes = get_comment_meta( $commentc->comment_ID, '_likes', true );
				
				$avatar = get_avatar( $commentc->comment_author_email, 20 );
				
				$user_hidden = $um_activity->api->user_hidden_comment( $commentc->comment_ID );

				include um_activity_path . 'templates/comment-reply.php';

			}
			
			// Do we have more comments
			if ( count( $child_all ) > count( $child ) ) {
				$calc = count( $child_all ) - count( $child );
				if ( $calc > 1 ) {
					$text = sprintf(__('load %s more replies','um-activity'), $calc );
				} else if ( $calc == 1 ) {
					$text = sprintf(__('load %s more reply','um-activity'), $calc );
				}
				echo '<a href="#" class="um-activity-ccommentload" data-load_replies="'. __('load more replies','um-activity').'" data-load_comments="'.__('load more comments','um-activity') . '" data-loaded="'. count( $child ) . '"><i class="um-icon-forward"></i><span>' . $text . '</span></a>';
				echo '<div class="um-activity-ccommentload-spin"></div>';
			}

		echo '</div>';
		
echo '</div>';
}