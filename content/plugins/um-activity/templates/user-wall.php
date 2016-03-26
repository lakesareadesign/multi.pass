<?php
$args = array(
	'post_type' => 'um_activity',
	'posts_per_page' => ( $ultimatemember->mobile->isMobile() ) ? um_get_option('activity_posts_num_mob') : um_get_option('activity_posts_num'),
	'post_status' => array('publish'),
);

if ( isset( $offset ) ) {
	$args['offset'] = $offset;
}

if ( isset( $user_wall ) && $user_wall ) {
	$args['meta_query'][] = array('key' => '_wall_id','value' => $user_id,'compare' => '=');
}

if ( isset( $wall_post ) && $wall_post > 0 ) {
	
	$args['post__in'] = array( $wall_post );

} else if ( isset( $hashtag ) && $hashtag ) {
	
	$args['tax_query'] = array( array( 'taxonomy' => 'um_hashtag','field' => 'slug','terms' => array ( $hashtag ) ));
	
} else if ( $um_activity->api->followed_ids() ) {
	
	$args['meta_query'][] = array('key' => '_user_id','value' => $um_activity->api->followed_ids(),'compare' => 'IN');

}

/*******************************************************************/

$args = apply_filters('um_activity_wall_args', $args );
$wallposts = new WP_Query( $args );

if ( $wallposts->found_posts == 0 ) return;

	foreach( $wallposts->posts as $post ) {
	setup_postdata( $post );

	$author_id = $um_activity->api->get_author( $post->ID );
	$wall_id = $um_activity->api->get_wall( $post->ID );
	$post_link = $um_activity->api->get_permalink( $post->ID );
	um_fetch_user( $author_id );

?>

<div class="um-activity-widget" id="postid-<?php echo $post->ID; ?>">

	<div class="um-activity-head">
	
		<div class="um-activity-left um-activity-author">
			<div class="um-activity-ava"><a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $author_id, 40 ); ?></a></div>
			<div class="um-activity-author-meta">
				<div class="um-activity-author-url">
					<a href="<?php echo um_user_profile_url(); ?>" class="um-link"><?php echo um_user('display_name'); ?></a>
					<?php
					if ( $wall_id && $wall_id != $author_id ) {
						um_fetch_user( $wall_id );
						echo '<i class="um-icon-forward"></i>';
						echo '<a href="' . um_user_profile_url() . '" class="um-link">' . um_user('display_name'). '</a>';
					}
					?>
				</div>
				<span class="um-activity-metadata">
					<a href="<?php echo $post_link; ?>"><?php echo $um_activity->api->get_post_time( $post->ID ); ?></a>
				</span>
			</div>
		</div>
		
		<div class="um-activity-right">
		
			<?php if ( is_user_logged_in() ) { ?>
			
				<a href="#" class="um-activity-ticon um-activity-start-dialog" data-role="um-activity-tool-dialog"><i class="um-faicon-chevron-down"></i></a>
				
				<div class="um-activity-dialog um-activity-tool-dialog">
					
					<?php if ( ( current_user_can('edit_users') || $author_id == get_current_user_id() ) && ( $um_activity->api->get_action_type( $post->ID ) == 'status' ) ) { ?>
						<a href="#" class="um-activity-manage" data-cancel_text="<?php _e('Cancel editing','um-activity'); ?>" data-update_text="<?php _e('Update','um-activity'); ?>"><?php _e('Edit','um-activity'); ?></a>
					<?php } ?>
					
					<?php if ( current_user_can('edit_users') || $author_id == get_current_user_id() ) { ?>
						<a href="#" class="um-activity-trash" data-msg="<?php _e('Are you sure you want to delete this post?','um-activity'); ?>"><?php _e('Delete','um-activity'); ?></a>
					<?php } ?>
					
					<?php if ( $author_id != get_current_user_id() ) { ?>
						<span class="sep"></span>
						<a href="#" class="um-activity-report <?php if ( $um_activity->api->reported( $post->ID ) ) echo 'flagged'; ?>" data-report="<?php _e('Report','um-activity'); ?>" data-cancel_report="<?php _e('Cancel report','um-activity'); ?>"><?php echo ( $um_activity->api->reported( $post->ID ) ) ? __('Cancel report','um-activity') : __('Report','um-activity'); ?></a>
					<?php } ?>
				
				</div>
			
			<?php } ?>
			
		</div>
		
		<div class="um-clear"></div>
	
	</div>
	
	<div class="um-activity-body">

		<div class="um-activity-bodyinner">
		
			<div class="um-activity-bodyinner-edit">
				<textarea style="display:none!important"><?php echo get_post_meta( $post->ID, '_original_content', true ); ?></textarea>
				<input type="hidden" name="_photo_" id="_photo_" value="<?php echo get_post_meta( $post->ID, '_photo', true ); ?>" />
			</div>
		
			<?php if ( $um_activity->api->get_content( $post->ID ) || get_post_meta( $post->ID, '_shared_link', true ) ) { ?>
				<div class="um-activity-bodyinner-txt">
					<?php echo $um_activity->api->get_content( $post->ID ); ?>
					<?php echo get_post_meta( $post->ID, '_shared_link', true ); ?>
				</div>
			<?php } ?>
			
			<div class="um-activity-bodyinner-photo">
				<?php echo $um_activity->api->get_photo( $post->ID ); ?>
			</div>
			
			<div class="um-activity-bodyinner-video">
				<?php echo $um_activity->api->get_video( $post->ID ); ?>
			</div>
			
		</div>

		<?php

		$likes = $um_activity->api->get_likes_number( $post->ID );
		$comments = $um_activity->api->get_comments_number( $post->ID );
		if ( $likes > 0 || $comments > 0 ) { 

		?>
		<div class="um-activity-disp">
			<div class="um-activity-left"><div class="um-activity-disp-likes"><a href="#" class="um-activity-show-likes um-link" data-post_id="<?php echo $post->ID; ?>"><span class="um-activity-post-likes"><?php echo $likes; ?></span><span class="um-activity-disp-span"><?php _e('likes','um-activity'); ?></span></a></div><div class="um-activity-disp-comments"><a href="#" class="um-link"><span class="um-activity-post-comments"><?php echo $comments; ?></span><span class="um-activity-disp-span"><?php _e('comments','um-activity'); ?></span></a></div></div>
			<div class="um-activity-faces um-activity-right">
				<?php echo $um_activity->api->get_faces( $post->ID ); ?>
			</div>
			<div class="um-clear"></div>
		</div><div class="um-clear"></div>
		<?php } ?>

	</div>
	
	<div class="um-activity-foot status" id="wallcomments-<?php echo $post->ID; ?>">
	
		<?php if ( is_user_logged_in() ) { ?>
		
		<div class="um-activity-left um-activity-actions">
			<?php if ( $um_activity->api->user_liked( $post->ID ) ) { ?>
			<div class="um-activity-like active" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><a href="#"><i class="um-faicon-thumbs-up um-active-color"></i><span class=""><?php _e('Unlike','um-activity'); ?></span></a></div>
			<?php } else { ?>
			<div class="um-activity-like" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>"><a href="#"><i class="um-faicon-thumbs-up"></i><span class=""><?php _e('Like','um-activity'); ?></span></a></div>
			<?php } ?>
			<?php if ( $um_activity->api->can_comment() ) { ?>
			<div class="um-activity-comment"><a href="#"><i class="um-faicon-comment"></i><span class=""><?php _e('Comment','um-activity'); ?></span></a></div>
			<?php } ?>
		</div>
		
		<?php } else { ?>
		<div class="um-activity-left um-activity-join"><?php echo $um_activity->api->login_to_interact( $post->ID ); ?></div>
		<?php } ?>
			
		<div class="um-clear"></div>
	
	</div>
	
	<?php $um_activity->shortcode->load_template('comments', $post->ID ); ?>

</div>

<?php }

wp_reset_postdata(); ?>

<div class="um-activity-load"></div>