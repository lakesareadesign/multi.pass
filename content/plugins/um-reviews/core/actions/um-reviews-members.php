<?php

	/***
	***	@add user rating in members directory
	***/
	add_action('um_members_after_user_name', 'um_reviews_add_rating', 50, 2 );
	function um_reviews_add_rating( $user_id, $args ) {
		global $um_reviews;
		
		if ( !um_get_option('members_show_rating') ) return;
		
		if ( !um_user('can_have_reviews_tab') ) return;
		
		?>
		
		<div class="um-member-rating"><span class="um-reviews-avg" data-number="5" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"></span></div>
		
		<?php

	}
	
	/***
	***	@Needed for new user signups
	***/
	add_action('um_after_user_is_approved', 'um_reviews_sync_new_user');
	function um_reviews_sync_new_user( $user_id ) {
		
		if ( !get_user_meta( $user_id, '_reviews_avg', true ) ) {
			update_user_meta( $user_id, '_reviews_avg', 0.00 );
		}
		
	}