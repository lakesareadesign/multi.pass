<?php

class UM_Reviews_API_Core {

	function __construct() {

	}
	
	/***
	***	@
	***/
	function adjust_rating( $postid, $old_rating, $new_rating ) {
		update_post_meta( $postid, '_rating', $new_rating );
		
		$user_id = get_post_meta( $postid, '_user_id', true );
		$reviewer_id = get_post_meta( $postid, '_reviewer_id', true );

		$reviews = get_user_meta( $user_id, '_reviews', true );
		if ( isset( $reviews[ $reviewer_id ] ) ) {
			$reviews[ $reviewer_id ] = $new_rating;
			update_user_meta( $user_id, '_reviews', $reviews );
		}
		
		$reviews_compound = get_user_meta( $user_id, '_reviews_compound', true );
		$reviews_compound = (int)$reviews_compound - $old_rating;
		$reviews_compound = (int)$reviews_compound + $new_rating;
		update_user_meta( $user_id, '_reviews_compound', $reviews_compound );
		
		// total reviews
		$reviews_total = get_user_meta( $user_id, '_reviews_total', true );

		// update rating average
		if ( $reviews_compound > 0 ) {
			$reviews_avg = $reviews_compound / $reviews_total;
			$reviews_avg = number_format( $reviews_avg, 2 );
			update_user_meta( $user_id, '_reviews_avg', $reviews_avg );
		}
		
	}
	
	/***
	***	@
	***/
	function publish_review( $postid ) {

		$user_id = get_post_meta( $postid, '_user_id', true );
		$reviewer_id = get_post_meta( $postid, '_reviewer_id', true );
		$rating = get_post_meta( $postid, '_rating', true );

		// update users who reviewed the user
		$reviews = get_user_meta( $user_id, '_reviews', true );
		if ( !isset( $reviews[ $reviewer_id ] ) ) {
			$reviews[ $reviewer_id ] = $rating;
			update_user_meta( $user_id, '_reviews', $reviews );
		}

		// update compounded ratings
		$reviews_compound = absint( get_user_meta( $user_id, '_reviews_compound', true ) );
		if ( $reviews_compound <= 0 ) {
			$reviews_compound = $rating;
		} else {
			$reviews_compound = $reviews_compound + $rating;
		}
		update_user_meta( $user_id, '_reviews_compound', $reviews_compound );

		// total reviews
		$reviews_total = get_user_meta( $user_id, '_reviews_total', true );
		$reviews_total = $reviews_total + 1;
		if ( $reviews_total < 0 ) $reviews_total = 0;
		update_user_meta( $user_id, '_reviews_total', $reviews_total );

		// update rating average
		if ( $reviews_compound > 0 ) {
			$reviews_avg = $reviews_compound / $reviews_total;
			$reviews_avg = number_format( $reviews_avg, 2 );
			update_user_meta( $user_id, '_reviews_avg', $reviews_avg );
		} else {
			update_user_meta( $user_id, '_reviews_avg', number_format( 0, 2 ) );
		}

	}
	
	/***
	***	@
	***/
	function undo_review( $postid ) {

		$user_id = get_post_meta( $postid, '_user_id', true );
		$reviewer_id = get_post_meta( $postid, '_reviewer_id', true );
		$rating = get_post_meta( $postid, '_rating', true );

		// update users who reviewed the user
		$reviews = get_user_meta( $user_id, '_reviews', true );
		if ( isset( $reviews[ $reviewer_id ] ) ) {
			unset( $reviews[ $reviewer_id ] );
			update_user_meta( $user_id, '_reviews', $reviews );
		}

		// update compounded ratings
		$reviews_compound = get_user_meta( $user_id, '_reviews_compound', true );
		$reviews_compound = (int)$reviews_compound - $rating;
		update_user_meta( $user_id, '_reviews_compound', $reviews_compound );

		// total reviews
		$reviews_total = get_user_meta( $user_id, '_reviews_total', true );
		$reviews_total = $reviews_total - 1;
		if ( $reviews_total < 0 ) $reviews_total = 0;
		update_user_meta( $user_id, '_reviews_total', $reviews_total );

		// update rating average
		if ( $reviews_compound > 0 ) {
			$reviews_avg = $reviews_compound / $reviews_total;
			$reviews_avg = number_format( $reviews_avg, 2 );
			update_user_meta( $user_id, '_reviews_avg', $reviews_avg );
		} else {
			update_user_meta( $user_id, '_reviews_avg', number_format( 0, 2 ) );
		}

	}
	
	/***
	***	@
	***/
	function get_filter() {
		if ( isset( $_REQUEST['filter'] ) && $_REQUEST['filter'] <= 5 && $_REQUEST['filter'] > 0 ) {
			return $_REQUEST['filter'];
		}
		return 0;
	}
	
	/***
	***	@
	***/
	function set_filter() {
		if ( isset( $_REQUEST['filter'] ) && $_REQUEST['filter'] <= 5 && $_REQUEST['filter'] > 0 ) {
			$this->rating_filter = $_REQUEST['filter'];
		} else {
			$this->rating_filter = '';
		}
	}
	
	/***
	***	@
	***/
	function get_reviews( $user_id ) {
		$my_review_ = false;
		
		$args = array(
			'post_type' => 'um_review',
			'posts_per_page' => -1,
			'author' => $user_id,
			'post_status' => array('publish'),
		);
		
		if ( $this->already_reviewed( $user_id ) ) {
			$my_review = $this->get_review_detail( $user_id, get_current_user_id() );
			$args['post__not_in'] = array($my_review->ID);
			$my_review_ = true;
		}
		
		$args['meta_query'][] = array(
			'key' => '_status',
			'value' => 1,
			'compare' => '='
		);
			
		if ( $this->rating_filter ) {
			$args['meta_query'][] = array(
				'key' => '_rating',
				'value' => $this->rating_filter,
				'compare' => '='
			);
		}
		
		$review_query = new WP_Query( $args );
		
		$reviews = $review_query->posts;
		
		if ( isset( $review_query->posts ) && $review_query->found_posts > 0 ) {
			
			return $review_query->posts;
		
		} else {
			if ( $my_review_ == true ) {
				return -1;
			} else {
				return false;
			}
		}
	}
	
	/***
	***	@
	***/
	function get_review_detail( $user_id, $reviewer_id ) {
		
		$args = array(
			'post_type' => 'um_review',
			'posts_per_page' => 1,
			'author' => $user_id,
			'post_status' => array('publish'),
		);
		
		$args['meta_query'][] = array(
			'key' => '_reviewer_id',
			'value' => $reviewer_id,
			'compare' => '='
		);
		
		$review_query = new WP_Query( $args );
		$review = $review_query->posts;
		if ( isset( $review[0] ) )
			return $review[0];
		return 0;
	}
	
	/***
	***	@
	***/
	function is_pending( $post_id ) {
		$status = get_post_meta( $post_id, '_status', true );
		if ( $status == 0 )
			return true;
		return false;
	}
	
	/***
	***	@
	***/
	function already_reviewed( $user_id = false ) {
		
		$args = array(
			'post_type' => 'um_review',
			'posts_per_page' => 1,
			'author' => $user_id,
			'post_status' => array('publish'),
		);
		
		$args['meta_query'][] = array(
			'key' => '_reviewer_id',
			'value' => get_current_user_id(),
			'compare' => '='
		);
		
		$review_query = new WP_Query( $args );
		$review = $review_query->found_posts;
		
		if ( $review > 0 )
			return true;
		return false;
	}
	
	/***
	***	@
	***/
	function can_edit( $user_id = false ) {
		if ( $user_id == get_current_user_id() && um_user_can('can_remove_own_review') )
			return true;
		if ( um_user_can('can_remove_review') )
			return true;
		return false;
	}
	
	/***
	***	@
	***/
	function is_flagged( $review_id ) {
		if ( get_post_meta( $review_id, '_flagged', true ) )
			return true;
		return false;
	}
	
	/***
	***	@
	***/
	function can_flag( $review_id ) {
		
		// already flagged
		if ( get_post_meta( $review_id, '_flagged', true ) )
			return false;
	
		// logged in but trying as guest
		if ( um_get_option('can_flag_review') == 'loggedin' && !is_user_logged_in() )
			return false;
		
		// reviewed only but not true
		if ( um_get_option('can_flag_review') == 'reviewed' ) {
			$user_id = get_post_meta( $review_id, '_user_id', true );
			if ( $user_id != get_current_user_id() ) {
				return false;
			}
		}
		
		return true;
		
	}
	
	/***
	***	@
	***/
	function can_remove( $user_id ) {
		if ( $user_id == get_current_user_id() && um_user_can('can_remove_own_review') )
			return true;
		if ( um_user_can('can_remove_review') )
			return true;
		return false;
	}
	
	/***
	***	@
	***/
	function is_blocked( $user_id = false ) {
		$user_id = ( $user_id ) ? $user_id : get_current_user_id();
		if ( get_user_meta( $user_id, '_cannot_add_review', true ) )
			return true;
		return false;
	}
		
	/***
	***	@
	***/
	function can_review( $user_id = false ) {
		
		if ( !is_user_logged_in() )
			return false;
		
		if ( $this->is_blocked() )
			return false;
		
		if ( !um_user_can('can_review') )
			return false;
		
		if ( um_user_can('can_review_roles') && !in_array( get_user_meta( $user_id, 'role', true ), um_user_can('can_review_roles') ) )
			return false;

		if ( $this->already_reviewed( $user_id ) )
			return false;

		if ( $user_id && $user_id == get_current_user_id() )
			return false;

		return true;
	}
	
	/***
	***	@
	***/
	function rating_header() {
		$result = ( um_is_myprofile() ) ? __('Your Rating','um-reviews') : __('User Rating','um-reviews');
		return $result;
	}
	
	/***
	***	@
	***/
	function avg_rating( $user_id = null ) {
		
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		$total_ratings = (int) get_user_meta( $user_id, '_reviews_total', true );
		$avg_rating = (double) get_user_meta( $user_id, '_reviews_avg', true );
		
		if ( $total_ratings == 1 ) {
			$result = sprintf(__('%s average based on %s review.','um-reviews'), number_format( $avg_rating, 2), number_format( $total_ratings ) );
		} else {
			$result = sprintf(__('%s average based on %s reviews.','um-reviews'), number_format( $avg_rating, 2), number_format( $total_ratings ) );
		}
		
		if ( $total_ratings == 0 && um_is_myprofile() )
			$result = __('Nobody has reviewed you yet.','um-reviews');
		
		if ( $total_ratings == 0 && !um_is_myprofile() )
			$result = __('Nobody has reviewed this user yet.','um-reviews');
		
		return $result;
	}
	
	/***
	***	@
	***/
	function get_rating( $user_id = null ) {
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		$result = (double) get_user_meta( $user_id, '_reviews_avg', true );
		return number_format( $result, 2 );
	}
	
	/***
	***	@
	***/
	function get_avg_rating( $user_id = null ) {
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		$result = (double) get_user_meta( $user_id, '_reviews_avg', true );
		return number_format( $result, 2 );
	}
	
	/***
	***	@
	***/
	function get_reviews_count( $user_id = null ) {
		$user_id = ( $user_id ) ? $user_id : um_profile_id();
		$result = (int) get_user_meta( $user_id, '_reviews_total', true );
		return $result;
	}
	
	/***
	***	@
	***/
	function generate_star_rating_url( $i ) {
		global $ultimatemember;
		$nav_link = $ultimatemember->permalinks->get_current_url( get_option('permalink_structure') );
		$nav_link = remove_query_arg( 'um_action', $nav_link );
		$nav_link = remove_query_arg( 'subnav', $nav_link );
		$nav_link = add_query_arg('profiletab', 'reviews', $nav_link );
		$nav_link = add_query_arg('filter', $i, $nav_link );
		return $nav_link;
	}
	
	/***
	***	@
	***/
	function get_details() {
		$vals = '';
		
		$reviews = get_user_meta( um_profile_id(), '_reviews', true );
		$reviews_total = get_user_meta( um_profile_id(), '_reviews_total', true );
		
		if ( $reviews ) {
			$vals = array_count_values($reviews);
		}
		
		for( $i = 5; $i >= 1; $i-- ) {
			
			$count_of_reviews = ( isset( $vals[$i] ) ) ? $vals[$i] : 0;
			
			if ( $reviews_total ) {
				$progress = number_format( ( ( $count_of_reviews / $reviews_total ) * 100 ) );
			} else {
				$progress = 0;
			} ?>
		
		<span class="um-reviews-detail">
			<span class="um-reviews-d-s"><a href="<?php echo $this->generate_star_rating_url( $i ); ?>"><?php if ( $this->get_filter() == $i ) { echo '<strong>'. sprintf(__('%s Star','um-reviews'), $i ) .'</strong>'; } else { echo sprintf(__('%s Star','um-reviews'), $i); } ?></a></span>
			<a href="<?php echo $this->generate_star_rating_url( $i ); ?>" class="um-reviews-d-p um-tip-n" title="<?php echo sprintf(__('%s reviews (%s)','um-reviews'), $count_of_reviews, $progress . '%' ); ?>"><span data-width="<?php echo $progress; ?>"></span></a>
			<span class="um-reviews-d-n"><?php echo $count_of_reviews; ?></span>
		</span>
		
		<?php
		}
	}
	
}