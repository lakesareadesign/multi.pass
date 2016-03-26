<?php 

$topics = bbp_get_user_favorites_topic_ids( um_user('ID') ); 

if ( !$topics ) $topics = array('abc');

$loop = $ultimatemember->query->make( array('post_type' => 'topic', 'post__in' => $topics ) ); ?>

<?php if ( $loop->have_posts()) { ?>
			
	<?php while ($loop->have_posts()) { $loop->the_post(); $topic_id = get_the_ID(); ?>

		<div class="um-item">
			
			<?php if ( um_current_user_can('edit', um_user('ID') ) ) { ?>
			<div class="um-item-action">
			
			<a href="#" class="um-ajax-action um-tip-e" title="<?php _e('Remove','um-bbpress'); ?>" data-hook="um_bbpress_remove_user_favorite" data-js-remove="um-item" data-user_id="<?php echo um_user('ID'); ?>" data-arguments="<?php echo $topic_id; ?>" rel="nofollow"><i class="um-icon-close"></i></a>
			
			</div>
			<?php } ?>
			
			<div class="um-item-link"><a href="<?php the_permalink(); ?>"><?php bbp_topic_title( $topic_id ); ?></a></div>
			<div class="um-item-meta">
				<span><?php printf( __('in: <a href="%1$s">%2$s</a>', 'um-bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id( $topic_id ) ), bbp_get_forum_title( bbp_get_topic_forum_id( $topic_id ) ) ); ?></span>
				<span>Voices: <?php echo bbp_get_topic_voice_count( $topic_id ); ?></span>
				<span>Replies: <?php echo bbp_get_topic_reply_count( $topic_id ); ?></span>
				<?php echo ( bbp_get_topic_last_active_time( $topic_id ) ) ? '<span>' . sprintf(__('Last active %s','um-bbpress'), bbp_get_topic_last_active_time( $topic_id ) ) . '</span>' : ''; ?>
			</div>
		</div>
		
	<?php } ?>
		
<?php } else { ?>

	<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You currently have no favorite topics.','um-bbpress') : __('This user has no favorite topics.','um-bbpress'); ?></span></div>
	
<?php } ?>