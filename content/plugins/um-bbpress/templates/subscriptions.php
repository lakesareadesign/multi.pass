<?php 
$subscribed_topics = bbp_get_user_subscribed_topic_ids( um_user('ID') ); 
$subscribed_forums = bbp_get_user_subscribed_forum_ids( um_user('ID') );

$subscribed = array_merge( $subscribed_topics, $subscribed_forums );
if ( !$subscribed ) $subscribed = array('abc');

$loop = $ultimatemember->query->make( array('post_type' => array('forum','topic'), 'post__in' => $subscribed, 'orderby' => 'date', 'order' => 'DESC' ) ); ?>
<?php $show_subscription = get_query_var('bbp-subscription'); ?>
<form class="um-show-bbp-subscription" method="get" action="">
	<input type='hidden' name="profiletab" value="forums"/>
	<input type='hidden' name="subnav" value="subscriptions"/>
	<select class="bbp-subscription" name="bbp-subscription" onchange="this.form.submit();">
		<option value="all"><?php echo sprintf(__("Show all subscriptions (%d)","ultimatemember"),count( $subscribed ) );?></option>
		<option value="topic" <?php selected( $show_subscription,'topic', true ); ?> ><?php echo sprintf(__("Subscribed Topics (%d)","ultimatemember"),count( $subscribed_topics ) );?></option>
		<option value="forum" <?php selected( $show_subscription,'forum', true ); ?> ><?php echo sprintf(__("Subscribed Forums (%d)","ultimatemember"),count( $subscribed_forums ) );?></option>
	</select>
</form>

<?php if ( $loop->have_posts()) { ?>
			
	<?php while ($loop->have_posts()) { $loop->the_post(); ?>
	
		<?php $post_type =  get_post_type(); ?>
		<?php if( empty( $show_subscription ) || in_array( $show_subscription, array('all','',$post_type ) ) ) { ?>

			<?php if( $post_type == 'forum' )  $forum_id = get_the_ID(); ?>
			<?php if( $post_type == 'topic' )  $topic_id = get_the_ID(); ?>
			<?php $post_id = isset( $forum_id )? $forum_id : $topic_id; ?>
			<div class="um-item">
			
				<?php if ( um_current_user_can('edit', um_user('ID') ) ) { ?>
					<div class="um-item-action">
					<?php if( $post_type == 'topic' ){ ?>
					<a href="#" class="um-ajax-action um-tip-e" title="<?php _e('Unsubscribe','um-bbpress'); ?>" data-hook="um_bbpress_remove_user_subscription" data-bbpress-type="<?php echo $post_type;?>" data-js-remove="um-item" data-user_id="<?php echo um_user('ID'); ?>" data-arguments="<?php echo $topic_id; ?>" rel="nofollow"><i class="um-icon-close"></i></a>
					<?php }elseif( $post_type == 'forum' ){ ?>
					<a href="#" class="um-ajax-action um-tip-e" title="<?php _e('Unsubscribe','um-bbpress'); ?>" data-hook="um_bbpress_remove_user_subscription" data-bbpress-type="<?php echo $post_type;?>"  data-js-remove="um-item" data-user_id="<?php echo um_user('ID'); ?>" data-arguments="<?php echo $forum_id; ?>" rel="nofollow"><i class="um-icon-close"></i></a>
					<?php } ?>
				</div>
				<?php } ?>
				
				<div class="um-item-link"><a href="<?php the_permalink(); ?>"><?php bbp_topic_title( $post_id ); ?></a></div>
				<div class="um-item-meta">
				<?php 
				if( $post_type == 'topic' ){ ?>
					<span><i class='um-faicon-comment'></i> Topic</span>
					<span><?php printf( __(' in: <a href="%1$s">%2$s</a>', 'um-bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id( $topic_id ) ), bbp_get_forum_title( bbp_get_topic_forum_id( $topic_id ) ) ); ?></span>
					<span>Voices: <?php echo bbp_get_topic_voice_count( $topic_id ); ?></span>
					<span>Replies: <?php echo bbp_get_topic_reply_count( $topic_id ); ?></span>
					<?php echo ( bbp_get_topic_last_active_time( $topic_id ) ) ? '<span>' . sprintf(__('Last active %s','um-bbpress'), bbp_get_topic_last_active_time( $topic_id ) ) . '</span>' : ''; ?>
				<?php }elseif( $post_type == 'forum' ){ ?>
					<span><i class='um-faicon-comments'></i> Forum</span>
					<span>Topics: <?php echo bbp_forum_topic_count( $forum_id ); ?></span>
					<span>Replies: <?php echo bbp_show_lead_topic($forum_id) ? bbp_forum_reply_count($forum_id) : bbp_forum_post_count($forum_id); ?></span>
					<?php echo ( bbp_get_topic_last_active_time( $forum_id ) ) ? '<span>' . sprintf(__('Last active %s','um-bbpress'), bbp_get_topic_last_active_time( $forum_id ) ) . '</span>' : ''; ?>
				<?php } ?>
				</div>
			</div>

		<?php } ?>
		
	<?php } ?>
		
<?php } else { ?>

	<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You are not currently subscribed to any topics.','um-bbpress') : __('This user is not currently subscribed to any topics.','um-bbpress'); ?></span></div>
	
<?php } ?>