<div class="um-admin-metabox um-admin-metabox-review">

	<?php if ( get_post_meta( get_the_ID(), '_flagged', true ) ) { ?>
	<div class="um-admin-review-flagged">
	
		<span class="heading"><?php _e('Flagged:','um-reviews'); ?></span>
		
		<p><?php _e('This review has been flagged. Change the status below.','um-reviews'); ?></p>
		
		<select name="_flagged" id="_flagged">
			<option value="1" <?php selected(1, $ultimatemember->query->get_meta_value('_flagged') ); ?>><?php _e('Under Review','um-reviews'); ?></option>
			<option value="0" <?php selected(0, $ultimatemember->query->get_meta_value('_flagged') ); ?>><?php _e('Reviewed','um-reviews'); ?></option>
		</select>
		
	</div>
	<?php } ?>
	
	<div class="um-admin-review-from">
		
		<span class="heading"><?php _e('From:','um-reviews'); ?></span>
		
		<?php
			
			$user_id = get_post_meta( get_the_ID(), '_reviewer_id', true );
			um_fetch_user( $user_id );
			echo '<a href="'. um_user_profile_url() .'" target="_blank">'. um_user('profile_photo', 40) . um_user('display_name') . '</a>';
		
		?>
		
	</div>
	
	<div class="um-admin-review-to">
	
		<span class="heading"><?php _e('To:','um-reviews'); ?></span>
		
		<?php
			
			$user_id = get_post_meta( get_the_ID(), '_user_id', true );
			um_fetch_user( $user_id );
			echo '<a href="'. um_user_profile_url() .'" target="_blank">'. um_user('profile_photo', 40) . um_user('display_name') . '</a>';
		
		?>
		
	</div>
	
	<div class="um-admin-review-rating">
	
		<span class="heading"><?php _e('Rating:','um-reviews'); ?></span>
		
		<?php
			
			$rating = get_post_meta( get_the_ID(), '_rating', true );
			echo '<span class="um-reviews-rate" data-key="rating" data-number="5" data-score="'. $rating . '"></span>';
		
		?>
		
	</div>
	
	<div class="um-admin-review-status">
	
		<span class="heading"><?php _e('Status:','um-reviews'); ?></span>

		<select name="_status" id="_status">
			<option value="1" <?php selected(1, $ultimatemember->query->get_meta_value('_status') ); ?>><?php _e('Approved','um-reviews'); ?></option>
			<option value="0" <?php selected(0, $ultimatemember->query->get_meta_value('_status') ); ?>><?php _e('Pending','um-reviews'); ?></option>
		</select>
		
	</div>
	
</div>