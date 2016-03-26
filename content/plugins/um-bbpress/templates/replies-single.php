	<?php while ($loop->have_posts()) { $loop->the_post(); $reply_id = get_the_ID(); ?>

		<div class="um-item">
			<div class="um-item-link"><a href="<?php bbp_reply_url( $reply_id ); ?>"><?php bbp_reply_title( $reply_id ); ?></a></div>
			<div class="um-item-meta">
				<span><?php printf( __('This topic has %s more replies','um-bbpress'), bbp_get_topic_reply_count( bbp_get_reply_topic_id( $reply_id ) ) - 1 ); ?></span>
			</div>
		</div>
		
	<?php } ?>
	
	<?php if ( isset($modified_args) && $loop->have_posts() && $loop->found_posts >= 10 ) { ?>
	
		<div class="um-load-items">
			<a href="#" class="um-ajax-paginate um-button" data-hook="um_bbpress_load_replies" data-args="<?php echo $modified_args; ?>"><?php _e('load more replies','um-bbpress'); ?></a>
		</div>
		
	<?php } ?>