<?php

	/***
	***	@block user from adding review
	***/
	add_action('um_action_user_request_hook', 'um_reviews_process_user_admin', 10, 2 );
	function um_reviews_process_user_admin( $action, $user_id ) {
		global $ultimatemember;
		if ( !um_current_user_can('edit', $user_id ) ) return;
		
		if ( $action == 'um_block_add_review' ) {
			update_user_meta( $user_id, '_cannot_add_review', 1 );
			exit( wp_redirect( $ultimatemember->permalinks->get_current_url( true ) ) );
		}
		
		if ( $action == 'um_unblock_add_review' ) {
			delete_user_meta( $user_id, '_cannot_add_review' );
			exit( wp_redirect( $ultimatemember->permalinks->get_current_url( true ) ) );
		}
	}
	
	/***
	***	@allowed permissions
	***/
	add_action('um_review_front_actions', 'um_review_front_actions', 99, 4 );
	function um_review_front_actions( $user_id, $reviewer_id, $my_id, $review_id ) {
		global $um_reviews;
		
		if ( $um_reviews->api->can_flag( $review_id ) ) {
			echo '<div class="um-reviews-flag"><a href="#"><i class="um-faicon-flag"></i> <span>' . __('Report','um-reviews') . '</span></a></div>';
		}

		if ( $um_reviews->api->already_reviewed( $user_id ) && $reviewer_id == $my_id ) {
			echo '<div class="um-reviews-edit"><a href="#"><i class="um-faicon-pencil"></i> <span>'.__('Edit','um-reviews') .'</span></a></div>';
		} else if (  $um_reviews->api->can_edit( $reviewer_id ) ) {
			echo '<div class="um-reviews-edit"><a href="#"><i class="um-faicon-pencil"></i> <span>'.__('Edit','um-reviews') .'</span></a></div>';
		}
		
		if ( $um_reviews->api->can_remove( $reviewer_id ) ) {
			echo '<div class="um-reviews-remove"><a href="#" data-review_id="'. $review_id .'" data-remove="'. __('Are you sure you want to remove this review?','um-reviews') . '"><i class="um-faicon-trash"></i> <span>' .__('Remove','um-reviews'). '</span></a></div>';
		}

	}