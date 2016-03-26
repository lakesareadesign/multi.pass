<?php if ( $um_reviews->api->can_review( um_profile_id() ) ) { ?>

<?php

	um_fetch_user( get_current_user_id() );
	
?>

<div class="um-reviews-item">
	
	<div class="um-reviews-img"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('profile_photo',40); ?></a></div>
	<div class="um-reviews-prepost"><i class="um-faicon-pencil"></i> <?php _e('Write a review for this user','um-reviews'); ?></div>
	
	<div class="um-reviews-post review-new">

			<span class="um-reviews-avg" data-number="5" data-score="0"></span>

			<span class="um-reviews-title"></span>
			
			<span class="um-reviews-meta"><?php printf(__('by <a href="%s">%s</a>, %s','um-reviews'), um_user_profile_url(), um_user('display_name'), current_time('F d, Y') ); ?></span>

			<span class="um-reviews-content"></span>
			
			<div class="um-reviews-note"></div>
			
			<div class="um-reviews-tools">

			</div>

	</div>
	
	<div class="um-reviews-post review-form">
	
		<a href="#" class="um-reviews-cancel-add"><i class="um-icon-close"></i></a>

		<form class="um-reviews-form" action="" method="post">
		
			<span class="um-reviews-rate" data-key="rating" data-number="5" data-score="0"></span>

			<span class="um-reviews-title"><input type="text" name="title" placeholder="<?php _e('Enter subject...','um-reviews'); ?>" /></span>
			
			<span class="um-reviews-meta"><?php printf(__('by <a href="%s">%s</a>, %s','um-reviews'), um_user_profile_url(), um_user('display_name'), current_time('F d, Y') ); ?></span>

			<span class="um-reviews-content"><textarea name="content" placeholder="<?php _e('Enter your review...','um-reviews'); ?>"></textarea></span>
			
			<input type="hidden" name="user_id" id="user_id" value="<?php echo um_profile_id(); ?>" />
			<input type="hidden" name="reviewer_id" id="reviewer_id" value="<?php echo get_current_user_id(); ?>" />
			<input type="hidden" name="reviewer_publish" id="reviewer_publish" value="<?php echo um_user('can_publish_review'); ?>" />
			<input type="hidden" name="action" id="action" value="um_review_add" />
			
			<div class="um-field-error" style="display:none"></div>
			
			<span class="um-reviews-send"><input type="submit" value="<?php _e('Submit Review','um-reviews'); ?>" class="um-button" /></span>
			
		</form>

	</div>
	<div class="um-clear"></div>
	
</div>

<?php um_fetch_user( um_profile_id() ); ?>

<?php } ?>

<?php

if ( !is_user_logged_in() ) {
	
	echo '<div class="um-reviews-item">';
	
	printf(__('You are not logged in. Please <a href="%s">login</a> to review this user.','um-reviews'), um_get_core_page('login') );
	
	echo '</div>';

}

?>