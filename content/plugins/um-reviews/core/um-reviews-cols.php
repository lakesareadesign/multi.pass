<?php

class UM_Reviews_Cols {

	function __construct() {
		
		add_filter('manage_edit-um_review_columns', array(&$this, 'manage_edit_um_review_columns') );
		add_action('manage_um_review_posts_custom_column', array(&$this, 'manage_um_review_posts_custom_column'), 10, 3);
		
	}
	
	/***
	***	@Custom columns
	***/
	function manage_edit_um_review_columns($columns) {
	
		$admin = new UM_Admin_Metabox();
		
		$title = $columns['title'];
		unset( $columns['title'] );
		unset( $columns['date'] );
		unset( $columns['cb'] );
		
		$columns['review_from'] = __('From','um-reviews');
		$columns['review_to'] = __('To','um-reviews');
		$columns['review_rating'] = __('Rating','um-reviews');
		$columns['review_date'] = __('Date','um-reviews');
		$columns['review_flag'] = __('Flagged','um-reviews');
		$columns['title'] = $title;
		
		return $columns;
		
	}
	
	/***
	***	@Display cusom columns
	***/
	function manage_um_review_posts_custom_column($column_name, $id) {
		global $wpdb, $ultimatemember, $um_reviews;
		
		switch ($column_name) {
			
			case 'review_flag':
			
				$flagged = get_post_meta( $id, '_flagged', true );
				if ( $flagged ) {
					echo '<span class="um-adm-ico inactive um-admin-tipsy-n" title="'.__('Flagged','um-reviews').'"><i class="um-faicon-flag"></i></span>';
				}
				break;
				
			case 'review_rating':
			
				$rating = get_post_meta( $id, '_rating', true );
				echo '<span class="um-reviews-avg" data-number="5" data-score="'. $rating . '"></span>';
				
				break;
				
			case 'review_from':
			
				$user_id = get_post_meta( $id, '_reviewer_id', true );
				um_fetch_user( $user_id );
				echo '<a href="'. um_user_profile_url() .'" target="_blank">'. um_user('profile_photo', 32) .'</a>';
				break;
				
			
			case 'review_date':
				echo get_the_time('F d, Y');
				break;
				
			case 'review_to':
			
				$user_id = get_post_meta( $id, '_user_id', true );
				um_fetch_user( $user_id );
				echo '<a href="'. um_user_profile_url() .'" target="_blank">'. um_user('profile_photo', 32) .'</a>';
				break;
				
		}
		
	}
	
}