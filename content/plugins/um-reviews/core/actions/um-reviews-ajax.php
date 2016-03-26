<?php

	/***
	***	@remove a review
	***/
	add_action('wp_ajax_nopriv_um_review_trash', 'um_review_trash');
	add_action('wp_ajax_um_review_trash', 'um_review_trash');
	function um_review_trash(){
		global $ultimatemember, $um_reviews;
		extract($_POST);
		
		if ( !$um_reviews->api->can_remove( $user_id ) ) return;
		
		$um_reviews->api->undo_review( $review_id );
			
		wp_delete_post( $review_id, true );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@flag a review
	***/
	add_action('wp_ajax_nopriv_um_review_flag', 'um_review_flag');
	add_action('wp_ajax_um_review_flag', 'um_review_flag');
	function um_review_flag(){
		global $ultimatemember, $um_reviews;
		extract($_POST);
		
		update_post_meta( $review_id, '_flagged', 1 );
		
		$output['response'] = __('This review has been flagged for admin review','um-reviews');
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
	
	/***
	***	@add a review to user
	***/
	add_action('wp_ajax_nopriv_um_review_add', 'um_review_add');
	add_action('wp_ajax_um_review_add', 'um_review_add');
	function um_review_add(){
		global $ultimatemember, $um_reviews;
		extract($_POST);
		
		$output['error'] = '';
		if ( !isset( $reviewer_id ) || !isset( $user_id ) || !isset( $rating ) || !isset( $title ) || !isset( $content ) )
			$output['error'] = __('Invalid request','um-reviews');
		
		if ( !isset($action_do) && !$um_reviews->api->can_review( $user_id ) )
			$output['error'] = __('You can not rate this user.','um-reviews');

		if ( !$rating )
			$output['error'] = __('Please add a rating.','um-reviews');
		
		if ( !$title )
			$output['error'] = __('You must provide a title.','um-reviews');
		
		if ( !$content )
			$output['error'] = __('You must provide review content.','um-reviews');

		if ( !$output['error'] ) {
			
			// prepare review array
			$output['rating'] = $rating;
			$output['title'] = stripslashes( $title );
			$output['content'] = wpautop( stripslashes($content) );
			
			// add review
			if ( isset( $action_do ) && $action_do == 'edit' ) {
				
				$args = array(
					'ID'				=> $review_id,
					'post_title'		=> $output['title'],
					'post_content'		=> $output['content']
				);
				wp_update_post( $args );
				
				update_post_meta( $review_id, '_rating', $output['rating'] );

			} else {
				
				$args = array(
					'post_title'		=> $output['title'],
					'post_content'		=> $output['content'],
					'post_type' 	  	=> 'page',
					'post_status'		=> 'publish',
					'post_author'   	=> $user_id,
				);
				$review_id = wp_insert_post( $args );
				wp_update_post( array('ID' => $review_id, 'post_type' => 'um_review' ) );
				
				update_post_meta( $review_id, '_reviewer_id', $reviewer_id );
				update_post_meta( $review_id, '_user_id', $user_id );

				update_post_meta( $review_id, '_status', (int) $reviewer_publish );

				update_post_meta( $review_id, '_rating', $output['rating'] );
				
				// send a mail notification
				um_fetch_user( $user_id );
				$reviews_url = add_query_arg('profiletab', 'reviews', um_user_profile_url() );
				
				$reviewer = get_userdata( $reviewer_id );
				$reviewer = $reviewer->display_name;
				
				$ultimatemember->mail->send( um_user('user_email'), 'review_notice', array(
				
					'plain_text' => 1,
					'path' => um_reviews_path . 'templates/email/',
					'tags' => array(
						'{rating}',
						'{reviews_link}',
						'{reviewer}',
						'{review_content}'
					),
					'tags_replace' => array(
						sprintf(__('%s star','um-reviews'), $output['rating']),
						$reviews_url,
						$reviewer,
						stripslashes( $content )
					)
					
				) );
				
				// reviewed, reviewer (ID and display name), and reviews link
				do_action('um_review_is_published', $user_id, $reviewer_id, $reviewer, $reviews_url, stripslashes($output['title']), $review_id );
				
			}
		
			if ( $reviewer_publish ) {
				
				update_post_meta( $review_id, '_status', 1 );

				// update users who reviewed the user
				$reviews = get_user_meta( $user_id, '_reviews', true );
				$reviews[ $reviewer_id ] = $output['rating'];
				update_user_meta( $user_id, '_reviews', $reviews );
				
				// update compounded ratings
				$reviews_compound = get_user_meta( $user_id, '_reviews_compound', true );

				if ( isset( $action_do ) && $action_do == 'edit' ) {
					$reviews_compound = (int)$reviews_compound - $rating_old;
				}
				if ( $reviews_compound < 0 ) $reviews_compound = 0;
				$reviews_compound = (int)$reviews_compound + $output['rating'];
				update_user_meta( $user_id, '_reviews_compound', $reviews_compound );
				
				// update total reviews count
				$reviews_total = get_user_meta( $user_id, '_reviews_total', true );
				if ( isset( $action_do ) && $action_do == 'edit' ) {
					
					// no update to total reviews
					
				} else {

					if ( !$reviews_total ) {
						$reviews_total = 1;
					} else {
						$reviews_total = $reviews_total + 1;
					}
					update_user_meta( $user_id, '_reviews_total', $reviews_total );
				
				}
				
				// update rating average
				$reviews_avg = $reviews_compound / $reviews_total;
				$reviews_avg = number_format( $reviews_avg, 2 );
				update_user_meta( $user_id, '_reviews_avg', $reviews_avg );
			
			} else {
				$output['pending'] = __('This review will be moderated by an admin before it is live.','um-reviews');
			}
		
		}
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}